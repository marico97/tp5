<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/16
 * Time: 2:07
 */

namespace app\api\Validate;


class VerificationValidate extends BaseValidate
{

    protected $rule= [
        'mobile'=>'require|number|length:11'
];

}