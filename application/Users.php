<?php
namespace app\api\Controller;
use Guzzle\Http\Url;
use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Users extends Controller
{
/*
 * @
 */
    public function registPag()
    {
        //允许跨域条件
        header('Access-Control-Allow-Origin:*');
        //接受数据
        if (request()->isPost()) {
            $data = input('post.');

            if ($data) {
                //还是要检验数据?
                //查询传过来数据 有就返回 已存在 没有就

                $res = Db::table('ty_users')
                    ->where($data)
                    ->where('isdelete', 0)
                    ->find();

                if ($res) {
                    return json(['code' => 201, 'msg' => '已存在相同数据']);
                } else {
                    return json(['code' => 200, 'msg' => 'ok']);
                }

            }
        } else {
            return json(['code' => 202, 'msg' => '查询内容为空']);
        }
    }
    public function register()
    {
        //允许跨域条件
        header('Access-Control-Allow-Origin:*');
        //获取提交数据
        $data = input('post.');
        //检测器规则
        $validate = new Validate([
            ['username', 'require|unique:users', '名称不能为空|名称已经存在'],
            ['password', 'require', '密码不能为空'],
            ['realname', 'require', '真实姓名不能为空'],
            ['email', 'require|unique:users|email', 'email不能为空|email已经存在|请检查email格式'],
            ['telphone', 'require|unique:users|number|length:11', '手机不能为空|手机已经存在|手机号必须是数字|手机位数为11位请检查'],
            ['idnumber', 'require|unique:users', '身份证不能为空|身份证已经存在'],
            ['address', 'require', '地址不能为空'],
            ['hobby', 'require', '兴趣爱好不能为空'],
        ]);
        //校验提交数据
        if (request()->isPost()) {
            if (!$validate->check($data)) {
                $message = $validate->getError();
                return json(['code' => 203, 'msg' => $message]);
            } else {

                //拼接注册数据
                //检测爱好是否为数组,是则转换为字符串不是则非法操作
                if (isset($data['hobby'])) {
                    if (gettype($data['hobby']) !== "array") {
                        return json(['code' => 205, 'msg' => '异常操作非数组']);
                    }
                    $hobby = implode(",", $data['hobby']);
                }
                if (empty($data['belonguid'])) {
                    $data['belonguid'] = null;
                }

                //拼接
                $data['applydate'] = time();
                $arr = [
                    'username'  => $data['username'],
                    'password'  => $data['password'],
                    'realname'  => $data['realname'],
                    'email'     => $data['email'],
                    'telphone'  => $data['telphone'],
                    'idnumber'  => $data['idnumber'],
                    'address'   => $data['address'],
                    'hobby'     => $hobby,
                    'belonguid' => $data['belonguid'],
                    'image' =>$data['image'],
                    'applydate'=> $data['applydate']
                ];
                //插入数据库
                $result = Db::table('ty_users')->insert($arr);

                return json(['code' => 200, 'msg' => 'ok']);
            }




                //存数据库
//                $list = Db::name('users')->where('username','=',$data['username'] )->update([
//                    'image' => $res['data']['src']
//                ]);

                } else {
                    return json(['code' => 204, 'msg' => '注册失败,联系客服']);

    }
}



public function upload(){
    header('Access-Control-Allow-Origin:*');

    // 获取表单上传文件
    $file =$this->request->file('image');

    if ($file) {
        $res['code'] = 200;
        $res['msg'] = "上传成功";

        //上传图片
        //限制文件大小,格式,并在public下创建uplaods目录
        $info = $file->validate(['size'=>2097152,'ext'=>'jpg,png,BMP,JPEG'])->move(ROOT_PATH .
            'public' . DS . 'images');


        if ($info) {
            $res['data']['title'] = $info->getFilename();
            $filepath = $info->getSaveName();

            $res['data']['src'] =  $filepath; //拼接路径, 保存到数据库,前台可以直接取出来assign
//            $repla = str_replace("\\","/",$repla);
            if (!$res['data']['src']){
                $res['code'] = 207;
                $res['msg'] = '上传失败';
            }
        }
        else {
            $res['code'] = 207;
            $res['msg'] = '上传失败' . $file->getError();
        }
        return json($res);
}




        //    public function login(Request $request)//登陆接口
//    {
//            header('Access-Control-Allow-Origin:*');
//            if($request->isPost()){
//                $data=input('post.');
//                $result = $this->validate($data,'Users');
//
//                if(true !== $result){
//                return json(['status' => 'error','msg' => '用户名或者密码格式不正确！']);
//                }
//
//                $password=substr(md5($data['apassword']),8,16);
//                $result=Db::name('user')->where('username',$data['ausername'])->where('password',$password)->find();
//
//                if($result){
//                    switch ($result['status']) {
//                    case '0':
//                    case '1':
//                    session('userid', $result['id']);
//                    return json(['status' => 'success','msg' => '登陆成功！']);
//                    break;
//                    case '2':
//                    return json(['status' => 'error','msg' => '用户已被禁用，请联系管理员！']);
//                    break;
//                    }
//                }else{
//                return json(['status' => 'error','msg' => '用户名或者密码错误！']);
//            }
//        }
//    }
}
 public function telMsg($mobile){

    $host = "http://tongzhi.market.alicloudapi.com";
    $path = "/sms/send/template/notify/70";
    $method = "POST";
    $appcode = "2730bfe69f744c8bb494c1d9b1543f8f";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $code =  rand(10000, 99999) ;
    //测试请用默认短信模板,默认模板不可修改,如需自定义短信内容测试或正式发送,请联系旺旺或QQ1246073271进行申请
   $querys = array(
       "content" => "你的验证码是$code！",
       "mobile" => "$mobile"
   );
    $querys= http_build_query($querys);
    $bodys = "$code";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    var_dump(curl_exec($curl));
 }
}


