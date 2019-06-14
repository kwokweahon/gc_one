<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-05-30
 * Time: 23:46
 */

namespace app\admin\validate;


use think\Validate;

class Nav extends Validate
{
    //定义规则
    protected $rule = [
        'nav_name' => 'require|max:8',
    ];

    //规则语义信息
    protected $message = [
        'nav_name.require' => '栏目名称不能为空',
        'nav_name.max'     => '栏目名称不能超过8个字符'
    ];

    //在指定场景中，启用某些规则进行校验
    protected $scene = [
        'addExe' => ['nav_name'],
    ];
}