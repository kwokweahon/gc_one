<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 16:14
 */

namespace app\admin\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'admin_name'   => 'require|max:20',
        'admin_pwd'  => 'require',
    ];

    //规则语义信息
    protected $message = [
        'admin_name.require'   => '管理员账户不能为空',
        'admin_name.max'       => '管理员账户在20个字符内',
        'admin_pwd.require'  => '管理员密码不能为空',
    ];

    //在指定场景中，启用某些规则进行校验
    protected $scene = [
        'addExe' => ['admin_name', 'admin_pwd'],
    ];
}