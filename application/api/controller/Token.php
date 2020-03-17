<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 15:09
 */

namespace app\api\controller;


use think\Controller;

class Token extends BaseController
{
//                $token = Token::createToken($mobile); //创建一个
//$result = Token::checkToken($mobile); //解析token
//           $token = Token::getToken();    //从http请求头获取
//这些可以重写·因为加密规则不同



//namespace App\Http\Controllers\Auth;
//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
//class TokenController extends Controller{
    /**
     * header
     * @var array
     */
    private static $header = [
        "type" => "token",
        "alg"  => "HS256"
    ];    /**
 * create payload
 * @param $memberId
 * @param $permission
 * @return array
 */
    private static function payload($memberId)
    {
        return [
            "iss"       => "http://api.creatshare.com",
            "iat"       => $_SERVER['REQUEST_TIME'],
            "exp"       => $_SERVER['REQUEST_TIME'] + 7200,
            "GivenName" => "CreatShare",
            "memberId"  => $memberId,
        ];
    }    /**
 * encode data
 * @param $data
 * @return string
 */
    private static function encode($data)
    {
        return base64_encode(json_encode($data));
    }    /**
 * generate a signature
 * @param $header
 * @param $payload
 * @param string $secret
 * @return string
 */
    private static function signature($header, $payload, $secret = 'secret')
    {
        return hash_hmac('sha256', $header.$payload, $secret);
    }    /**
 * generate a token
 * @param $memberId
 * @param $permission
 * @return string
 */
    public static function createToken($memberId)
    {
        $header = self::encode(self::$header);
        $payload = self::encode(self::payload($memberId));
        $signature = self::signature($header, $payload);
        return $header . '.' .$payload . '.' . $signature;
    }    /**
 * check a token
 * @param $jwt
 * @param string $key
 * @return array|string
 */
    public static function checkToken($jwt, $key = 'secret')
    {
        $token = explode('.', $jwt);
        if (count($token) != 3)
            return 'token invalid';
        list($header64, $payload64, $sign) = $token;
        if (self::signature($header64 , $payload64) !== $sign)
            return 'token invalid';
        $header = json_decode(base64_decode($header64), JSON_OBJECT_AS_ARRAY);
        $payload = json_decode(base64_decode($payload64), JSON_OBJECT_AS_ARRAY);
        if ($header['type'] != 'token' || $header['alg'] != 'HS256')
            return 'token invalid';
        if ($payload['iss'] != 'http://api.creatshare.com' || $payload['GivenName'] != 'CreatShare')
            return 'token invalid';
        if (isset($payload['exp']) && $payload['exp'] < time())
            return 'timeout';
        return [
            'memberId' => $payload['memberId'],
            'permission' =>$payload['permission']
        ];
    }    /**
 * get a token
 * @return null
 */
    public static function getToken()
    {
        $token = null;
        if (isset($_SERVER['HTTP_AUTHORIZATION']))
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        return $token;
    }
}