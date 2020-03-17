<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/16
 * Time: 1:33
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //http状态码 404 200
    public $code = 400;
    //错误具体信息
    public $msg = '参数错误';
    //自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if (!is_array($params)){
            return ;
        }
        if (array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}