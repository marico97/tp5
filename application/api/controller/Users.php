<?php
namespace app\api\controller;
use app\api\Validate\UsersValidate;
use think\Db;
class Users extends BaseController
{
    /**
     *给指定手机号发送验证码
     * @url /registPag
     * @http POST
     * TODO:return
     **/
    public function registPag()//注册页面验证
    {
        $data = input('post.');

        if($data)
        {
            $res = Db::name('users')->where($data)->find(); //待优化做成model映射orm
            if ($res)
            {
                return parent::NoNoNo("已存在");
            }else {
                return parent::ojbk("可以创建");
            }
        }else{
            return parent::NoNoNo("请输入内容");
        }
    }


    public function upload()//图片上传接口
    {
        $file =request()->file('image');
        if ($file){//上传图片 返回为图片路径
            return parent::file_upload($file,md5(time().$_FILES['image']['name']));
        }

    }


    //注册页面验证信息
    public function register()//注册->验证->入库
    {
        //获取提交数据
        $data = input('post.');
        //检测器校验数据
        (new UsersValidate())->gocheck();
                //拼接注册数据
                //检测爱好是否为数组,是则转换为字符串不是则非法操作
                if (isset($data['hobby'])) {
                    if (is_array($data['hobby'])) {
                        $hobby = implode(",", $data['hobby']);
                    }else{
                        return parent::NoNoNo('非数组');
                    }
                }
                if (empty($data['belonguid'])) {//推荐码默认为空
                    $data['belonguid'] = null;
                }

                $password=md5($data['password']);  //执行MD5散列


                $data['applydate'] = date('Y-m-d H:i:s',time());
                //拼接数据
                $arr = [
                    'username'  => $data['username'],
                    'password'  => $password,//不加盐就直接md5
                    'realname'  => $data['realname'],
                    'email'     => $data['email'],
                    'telphone'  => $data['telphone'],
                    'idnumber'  => $data['idnumber'],
                    'address'   => $data['address'],
                    'hobby'     => $hobby,
                    'belonguid' => $data['belonguid'],
                    'image'     => $data['image'],
                    'applydate'=> $data['applydate'],
                ];
                //插入数据库
                $result = Db::name('users')->insert($arr);
                //存数据库
                $uid = Db::name('users')->
                where('username',$data['username'])->
                field('uid')->find();

                $token = md5($data['username'].time());//生成token存入
                $result = Db::name('users')->where('uid',$uid['uid'])
                         ->setField(['token' => $token]);
                if ($result){
                return parent::ojbk('注册成功');
        } else {
            return parent::NoNoNo('注册失败,联系客服');
        }
    }


    public function login()//email和password登录
    {

        $input_info = input('post.');

        if ($input_info['email']){
        $username = Db::name('users')->
        where('email',$input_info['email'])->find();
        if (!$username){
            return parent::NoNoNo('email不存在');
        }

            $user = Db::name('users')->
            where('email',$input_info['email'])->
            where('password',md5($input_info['password']))
                ->find();

        if ($user){
            $a = Db::name('users')->where('email',$input_info['email'])->update(
                ['lang'=>$input_info['lang']]);
        return parent::ojbk($user['token']);
        }
        else{
            return parent::NoNoNo('密码错误');
        }
      }
    }



    public function getEmail()//检查email是否存在
    {

        $input_info = input('post.');

        if ($input_info['email']){
            $username = Db::name('users')->
            where('email',$input_info['email'])->find();
            if (!$username){
                return parent::NoNoNo('email不存在');
            }
            else{
                return parent::ojbk();
            }

        }
    }
}
