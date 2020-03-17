<?php
/**
 * Created by PhpStorm.
 * Users: moqintao
 * Date: 2020/3/14
 * Time: 13:32
 */

namespace app\api\controller;
use app\api\Validate\VerificationValidate;
use app\lib\exception\UsersMissException;
use think\Db;
class Verification extends Token
{
    /**
     *给指定手机号发送验证码
     * @url /telMsg/:mobile
     * @http POST
     * @mobile 指定的手机号
     **/

    public function telMsg($mobile)
    {

                  //手机格式进行验证避免被陌生调用
                (new VerificationValidate())->gocheck();


                header('Access-Control-Allow-Origin:*');
                $res = Db::name('sms')
                         ->where("id", 1)
                         ->find();
                $sre = $res['appcode'];

                $host = "http://tongzhi.market.alicloudapi.com";
                $path = "/sms/send/template/notify/70";
                $method = "POST";
                $appcode = "$sre";
                $headers = array();
                array_push($headers, "Authorization:APPCODE " . $appcode);
                $code = rand(1000, 9999);

                //测试请用默认短信模板,默认模板不可修改,如需自定义短信内容测试或正式发送,请联系旺旺或QQ1246073271进行申请
                $querys = [
                    "content" => "【ework】注册验证码#$code#",
                    "mobile" => "$mobile"
                ];
                $querys = http_build_query($querys);
                $bodys = "";
                $url = $host . $path . "?" . $querys;

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_FAILONERROR, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, true);
                if (1 == strpos("$" . $host, "https://")) {
                    var_dump(curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                }

                $result = curl_exec($curl);
                $result = [
                    "code"=>200,
                    "info"=>'ok!',
                    'data'=>$code
                ];
                return json($result,JSON_UNESCAPED_UNICODE);
            }//短信获取接口

    }