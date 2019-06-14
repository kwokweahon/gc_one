<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 16:35
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();

    }

    public function doLogin()
    {
        $param = input('post.');


        if (empty($param['admin_name'])) {
            $this->error('用户名不能为空！');
        }

        if (empty($param['admin_pwd'])) {
            $this->error('密码不能为空！');
        }

        $has = Db('admin')->where('admin_name', $param['admin_name'])->find();

        if (empty($has)) {
            $this->error('用户名或密码错误！');
        }

        if ($has['admin_pwd'] != md5($param['admin_pwd'])) {
            $this->error('用户名或密码错误！');
        }

        cookie('admin_id', $has['admin_id'], 3600);
        cookie('admin_name', $has['admin_name'], 3600);
        $this->redirect('/admin/index');

    }

    public function logout()
    {
        cookie('admin_id', null);
        cookie('admin_name', null);

        $this->redirect('/admin/Login/index');
    }

}