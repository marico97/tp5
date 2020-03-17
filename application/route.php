<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//页面校验参数接口
Route::POST('registPag','api/Users/registPag');
//注册接口,在本站注册页面提交参数后调用
Route::POST('register','api/Users/register');
//上传图片接口
Route::POST('upload','api/Users/upload');
//短信接口 使用时用post方式传递一个$mobile参数,就是传一个电话号码 例:http://ty.e-work.top/TY/tp5/tp5/public/index.php/upload?18866668888 
Route::POST('telMsg','api/Verification/telMsg');
Route::POST('login','api/Users/login');
Route::POST('getEmail','api/Users/getEmail');



