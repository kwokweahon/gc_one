<?php

namespace app\admin\controller;


use app\admin\modelService\AdminService;
use think\Controller;
use think\Request;
use think\Db;

class Admin extends Controller
{
    public function index()
    {
        $adminService = new AdminService();
        $admin_rows   = $adminService->selectAdmin();

        $this->assign('admin_rows', $admin_rows);
        //var_dump($admin_rows);die;
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function addExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);

            $admin_rows = Db('admin')->where('admin_name', $data['admin_name'])->find();
            if ($admin_rows) {
                $this->error('你已经注册过请填写其他账户名');
            }

            $val_rs = $this->validate($data, 'Admin');
            //var_dump($val_rs);die;
            if (true !== $val_rs) {
                $this->error($val_rs);
            } else {
                $data['createtime'] = date('Y-m-d H:i:s', time());
                $data['admin_pwd']  = md5($data['admin_pwd']);
                Db::startTrans();
                $adminService = new AdminService();
                $rs           = $adminService->insertAdmin($data);
                if ($rs <= 0) {
                    $result = false;
                }
                if ($result) {
                    Db::commit();
                    $this->success('保存成功', null, $rs);
                } else {
                    Db::rollback();
                    $this->error('操作失败');
                }
            }
        }
    }

    public function deleteExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data       = Request::instance()->param(false);
            $admin_name = Db('admin')->where('admin_id', $data['admin_id'])->value('admin_name');
            if ($admin_name == 'admin') {
                $this->error('此账号为超级管理员账号，不能删除');
            }
            Db::startTrans();
            $adminService = new AdminService();
            $rs           = $adminService->deleteAdmin($data['admin_id']);
            if ($rs <= 0) {
                $result = false;
            }
            if ($result) {
                Db::commit();
                $this->success('删除成功', null, $rs);
            } else {
                Db::rollback();
                $this->error('操作失败');
            }
        }
    }
}