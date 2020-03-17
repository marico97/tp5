<?php
/**
 * Created by PhpStorm.
 * Users: moqintao
 * Date: 2020/3/14
 * Time: 10:30
 */

namespace app\api\controller;


use think\Controller;
use think\Request;

class BaseController extends Controller
{
    protected static $result_no = [
    "code"=>0,
    "info"=>'',
    'data'=>NULL
];

    protected static $result_yes = [
        "code"=>200,
        "info"=>'ok!',
        'data'=>NULL
    ];

    public function __construct()
    {
        header('Access-Control-Allow-Origin:*');
        header('Content-Type:application/json; charset=utf-8');
    }

    protected static function ojbk($data=NUll)
    {

        if(empty($data)?$data:null) {}
        self::$result_yes['data'] = $data;
        return json(self::$result_yes,JSON_UNESCAPED_UNICODE);//解析成中文方便自己测试
    }

    protected static function NoNoNo($info='Error!')
    {
        self::$result_no['info'] = $info;
        return json(self::$result_no,JSON_UNESCAPED_UNICODE);//解析成中文方便自己测试
    }

     protected function responseJson($code=200, $msg="success", $data=[], $status=200) {
            $resp = array('code'=>$code, 'msg'=>$msg, 'data'=>$data);

         // 返回JSON数据格式到客户端 包含状态信息
         header('Content-Type:application/json; charset=utf-8');
         return json($resp, $status);
    }
    protected function testerror() {
        ini_set("display_errors","On");
        error_reporting(E_ALL);
    }

    // 解析 ajax 请求体数据
     protected function ajaxJsonData() {
            return json_decode(file_get_contents('php://input'));
    }

    // 获取请求体数据
     protected function bodyParams($key='') {
            $body = $this->ajaxJsonData();
            if (isset($body[$key])) {
                return $body[$key];
        } else {
                   return null;
        }
    }

    // 解析查询字符串数据
     protected function queryParams($key='') {
            if (isset($_GET[$key])) {
                    return $_GET[$key];
         } else {
                   return null;
        }
    }
    //图片上传
    public function file_upload($file,$name)
    {
        // 获取表单上传文件
        if ($file) {
            //上传图片
            //限制文件大小,格式,并在public下创建uplaods目录
            $info = $file->validate(['size' => 2097152, 'ext' => 'jpg,png,BMP,JPEG'])->move(
                ROOT_PATH . 'public' . DS . 'images');

            if ($info) {

                self::$result_yes = [
                    "code"=>200,
                    "title"=>$info->getFilename(),
                    'src'=>str_replace("\\","/",$info->getSaveName())
                ];
                 //拼接路径, 保存到数据库,前台可以直接取出来assign
                if (!self::$result_yes['src']) {
                    return self::NoNoNo('上传失败');
                }
            }
            else {
                return self::NoNoNo('上传为空');
            }
            return json(self::$result_yes);
        }


    }
}
