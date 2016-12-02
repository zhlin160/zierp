<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/2 0002
 * Time: 14:23
 */

namespace app\admin\validate;


use think\Validate;

class Supplier extends Validate
{
    protected $rule = [
        'categoryId'  =>  'require|number',
        'code' =>  'require|number',
        'name' => 'require|number',
    ];

}