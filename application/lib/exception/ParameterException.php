<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/16
 * Time: 3:18
 */

namespace app\lib\exception;
use app\lib\exception\BaseException;

class ParameterException extends BaseException
{
    //http状态码 404 200
    public $code = 400;
    //错误具体信息
    public $msg = '参数错误';
    //自定义的错误码
    public $errorCode = 10000;
}