<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/16
 * Time: 1:35
 */

namespace app\lib\exception;
use app\lib\exception\BaseException;

class UsersMissException extends BaseException
{
    public $code = 404;
    public $msg = '不存在';
    public $errorCode = 40000;
}