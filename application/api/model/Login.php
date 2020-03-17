<?php
/**
 * Created by PhpStorm.
 * User: moqintao
 * Date: 2020/3/14
 * Time: 16:31
 */

namespace app\api\controller;
use app\api\validate\User;
use app\index\model\Users;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Session;
use think\Request;

//use app\index\model\LoginLog;

class Login extends Controller
{


 /**
     * 登陆 - ajax
     * @param Request $request
     * @param validateUser $validateUser
     * @param User $user
     * @param LoginLog $loginLog
     * @return array|mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(Request $request,validateUser $validateUser,User $user,LoginLog $loginLog){
        if($request->isAjax()){
            //获取提交数据
            $data = $request->param();
            //验证器验证提交数据
            if (true !== $validateUser->check($data)) {
                return $validateUser->getError();
            }
            //到此步骤，你可以尝试到验证器有没有起作用..........

            //判断用户是否存在
            $hasUser = $user->addUser($data['username']);
            if(empty($hasUser)){
                return json(['code' => -1, 'data' => '', 'msg' => '用户名错误']);
            }
            //判断密码是否正确、添加登陆日志
            if(md5(md5($data['password'])) != $hasUser['u_password']){
                $loginLog->writeLog($hasUser['id'],$data['username'],'用户【'.$data['username'].'】登录失败：密码错误',2);
                return json(['code' => -2, 'data' => '', 'msg' => '密码错误']);
            }
            //判断用户状态、添加登陆日志
            if(1 != $hasUser['u_status']){
                $loginLog->writeLog($hasUser['id'],$data['username'],'用户【'.$data['username'].'】登录失败：该账号被禁用',2);
                return json(['code' => -3, 'data' => '', 'msg' => '该账号被禁用']);
            }
            //保存用户信息
            Session::set('u_name', $data['username']);
            Session::set('l_user_id', $hasUser['id']);
            //更新管理员状态
            $param = [
                'u_login_num'  => $hasUser['u_login_num'] + 1,
                'u_login_ip'   => $request->ip(),
                'u_login_time' => time()
            ];
            if($user->updateUser($hasUser['id'],$param)){
                $loginLog->writeLog($hasUser['id'],session('u_name'),'用户【'.session('u_name').'】登录成功',1);
            }
            return json(['code' => 1, 'data' => url('index/index'), 'msg' => '登录成功']);
        }else{
            return $this->fetch();
        }
    }

    /**
     * 验证码
     * @param Captcha $captcha
     * @return \think\Response
     */
    public function verify(Captcha $captcha)
    {
        //图片验证码高度
        $captcha->imageH = 32;
        //图片验证码宽度
        $captcha->imageW = 100;
        //验证码
        $captcha->codeSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //验证码长度
        $captcha->length = 4;
        //是否画混淆曲线
        $captcha->useNoise = false;
        //验证码字体大小
        $captcha->fontSize = 14;
        return $captcha->entry();
    }


}