<?php
/**
 * Created by PhpStorm.
 * Users: moqintao
 * Date: 2020/3/14
 * Time: 16:18
 */
namespace app\api\Validate;
use app\api\Validate\BaseValidate;
class UsersValidate extends BaseValidate

{

    /**
     * 定义验证规则
     * 格式：'字段名'    => ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username'=> 'require|unique:users',
        'password'=> 'require',
        'realname'=> 'require',
        'email'=> 'require|unique:users|email',
        'telphone'=> 'require|unique:users|number|length:11',
        'idnumber'=>'require|unique:users',
        'address'=> 'require',
        'hobby'=>'require',
    ];


    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    => '错误信息'
     *
     * @var array
     */
//    protected $message = [
//        'username.require'      => '名称不能为空',
//        'username.unique:users'    => '名称已经存在',
//        'password.require'      => '密码不能为空',
//        'password.alphaNum'     => '密码只能以字母、数字组成',
//        'password.min'          => '密码最小长度：6个字符',
//        'password.max'          => '密码最大长度：15个字符',
//        'code.require'          => '验证码不能为空',
//        'code.captcha'          => '验证码错误',
//    ];


}