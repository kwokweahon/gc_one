<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-05-29
 * Time: 20:40
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Db;
use app\admin\modelService\NavService;

class Nav extends Controller
{
    public $status_row = [0 => '已下架', 1 => '已发布'];

    public function index()
    {
        $navService = new NavService();
        $nav_rows   = $navService->selectNav();

        foreach ($nav_rows as $key => $value) {
            $nav_rows[$key]['status_name'] = $this->status_row[$value['status']];
        }

        //var_dump($nav_rows);die;

        $this->assign('nav_rows', $nav_rows);

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

            $nav_count = Db('Nav')->where('status', 1)->count();
            if ($nav_count >= 7) {
                $this->error('栏目不能超过7个');
            }

            $val_rs = $this->validate($data, 'Nav');
            //var_dump($val_rs);die;
            if (true !== $val_rs) {
                $this->error($val_rs);
            } else {
                $data['nav_icon']   = '';
                $data['createtime'] = date('Y-m-d H:i:s', time());
                $data['status']     = 1;
                Db::startTrans();
                $navService = new NavService();
                $rs         = $navService->insertNav($data);
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
            $data    = Request::instance()->param(false);
            $nav_row = Db('nav_list')->where('nav_id', $data['nav_id'])->limit(1)->find();
            if ($nav_row) {
                $this->error('列表中有关联数据，不能删除');
            }
            Db::startTrans();
            $navService = new NavService();
            $rs         = $navService->deleteNav($data['nav_id']);
            if ($rs <= 0) {
                $result = false;
            }
            if ($result) {
                Db::commit();
                $this->success('删除成功', '', $rs);
            } else {
                Db::rollback();
                $this->error('操作失败');
            }
        }
    }

    public function downExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);
            //print_r($data);die;
            if ($data['status']) {
                $data['status'] = 0;
            } else {
                $data['status'] = 1;
            }
            Db::startTrans();
            $navService = new NavService();
            $rs         = $navService->updateNav($data);
            if ($rs <= 0) {
                $result = false;
            }
            if ($result) {
                Db::commit();
                $this->success('操作成功', null, $rs);
            } else {
                Db::rollback();
                $this->error('操作失败');
            }
        }
    }


    public function edit()
    {
        if (Request::instance()->isGet()) {
            $data = Request::instance()->param(false);

            $this->assign('nav', $data);

            return $this->fetch();
        }

    }

    public function editExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);
            //print_r($data);die;
            Db::startTrans();
            $navService = new NavService();
            $rs         = $navService->updateNav($data);
            if ($rs <= 0) {
                $result = false;
            }
            if ($result) {
                Db::commit();
                $this->success('修改成功', null, $rs);
            } else {
                Db::rollback();
                $this->error('操作失败');
            }
        }
    }
}

