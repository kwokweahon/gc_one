<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 23:04
 */

namespace app\admin\validate;


use think\Validate;

class Company extends Validate
{

    protected $rule = [
        'company_name'          => 'max:50',
        'company_charge_person' => 'max:10',
        'company_tel'           => 'max:20',
        'company_mobile'        => 'number|max:11',
        'company_fax'           => 'max:20',
        'company_mail'          => 'email|max:50',
        'company_qq'            => 'number|max:20',
        'company_wechat'        => 'max:30',
        'company_brief_intr'    => 'max:300',
    ];

    //规则语义信息
    protected $message = [
        'company_name.max'          => '公司名称不能超过50个字符',
        'company_charge_person.max' => '公司负责人不能超过10个字符',
        'company_tel.max'           => '公司电话不能超过20个字符',
        'company_mobile.max'        => '公司手机不能超过11个字符',
        'company_mobile.number'     => '请填写正确的手机号码',
        'company_fax.max'           => '公司手机不能超过20个字符',
        'company_mail.email'        => 'email格式不对',
        'company_mail.max'          => '公司手机不能超过50个字符',
        'company_qq.max'            => '公司手机不能超过20个字符',
        'company_qq.number'         => '请填写qq号码',
        'company_wechat.max'        => '公司微信不能超过30个字符',
        'company_brief_intr.max'    => '公司简介不能超过300个字符',

    ];

    //在指定场景中，启用某些规则进行校验
    protected $scene = [
        'editExe' => ['company_name', 'company_charge_person', 'company_tel', 'company_mobile', 'company_fax', 'company_mail', 'company_qq', 'company_wechat', 'company_brief_intr'],
    ];
}