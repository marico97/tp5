<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 14:48
 */
class  set_token{
public function set_token($user_name){
    $information ['state'] = false;
    $time = time();
    $header = array('typ' => 'JWT');
    $array = array(
        'iss' => 'http://api.creatshare.com', // 权限验证作者
        'iat' => $time, // 时间戳
        'exp' => 3600, // token有效期，1小时
        'sub' => 'demo', // 案例
        'user_name' => $user_name
    ) ;
    // 用户名

    $str = base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($array)); // 数组转成字符
    $str = urlencode($str); // 通过url转码
    $information ['token'] = $str;
    $this->save_token($user_name, $information ['token']); // 将用户token存放进用户数据库
    $information ['username'] = $user_name; // 返回用户名
    $information ['state'] = true;
    return $information;
}
}