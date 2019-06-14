<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-05-29
 * Time: 17:57
 */

namespace app\admin\controller;


use think\Controller;

class Index extends Controller
{
    public function index()
    {
        if(cookie('admin_id')&&cookie('admin_name'))
        {
            return $this->fetch();
        }
        else{
            $this->redirect('login/index');
        }

    }

    public function welcome()
    {
        return "<div style='font-size: 16px'>湛江盛力管养部后台管理！</div>";
    }

}