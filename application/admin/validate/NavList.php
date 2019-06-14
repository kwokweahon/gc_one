<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-01
 * Time: 17:42
 */

namespace app\admin\validate;

use think\Validate;

class NavList extends Validate
{
    //定义规则
    protected $rule = [
        'title'   => 'require|max:50',
        'nav_id'  => 'require',
        'content_text' => 'require|max:2000',
    ];

    //规则语义信息
    protected $message = [
        'title.require'   => '标题不能为空',
        'title.max'       => '标题控制在50个字符内',
        'nav_id.require'  => '栏目类型不能为空',
        'content_text.require' => '内容不能为空',
        'content_text.max' => '标题控制在2000个字符内',
    ];

    //在指定场景中，启用某些规则进行校验
    protected $scene = [
        'addExe' => ['title', 'nav_id', 'content'],
    ];
}
