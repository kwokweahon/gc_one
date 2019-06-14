<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-26
 * Time: 2:00
 */

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    //定义规则
    protected $rule = [
        'name'  =>  'require|max:25',
        'email' =>  'email',
    ];

    //规则语义信息
    protected $message = [
        'name.require'  =>  '用户名必须',
        'email' =>  '邮箱格式错误',
    ];
    //在指定场景中，启用某些规则进行校验
    protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];
}