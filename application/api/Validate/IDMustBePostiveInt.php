<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 14:26
 */

namespace app\api\Validate;
use app\api\Validate\BaseValidate;
class IDMustBePostiveInt extends BaseValidate
{

    protected $rule = [
        'id'=> 'require|isPositiveInteger',

    ];

    protected function isPositiveInteger($value,$rule = '',
        $data = '',$field = '')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
                return true;
        }else{
                return $field.'必须是正整数';
        }
    }
}