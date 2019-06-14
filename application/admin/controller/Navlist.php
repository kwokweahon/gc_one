<?php

namespace app\admin\controller;


use app\admin\modelService\NavlistService;
use think\Controller;
use think\Db;
use think\Request;

class Navlist extends Controller
{
    public $status_row = [0 => '已下架', 1 => '已发布'];

    public function index()
    {
        $nav_rows = db('nav')->column('nav_name', 'nav_id');

        $param = input('post.');
        $where = [];
        if (isset($param['nav_id']) && $param['nav_id'] > 0) {
            $where['nav_id'] = $param['nav_id'];
        } else {
            $param['nav_id'] = '';
        }

        if (isset($param['title']) && strlen($param['title'])) {
            $where['title'] = ['like', '%' . $param['title'] . '%'];
        } else {
            $param['title'] = '';
        }

        $navlistService = new NavlistService();
        $nav_list_rows  = $navlistService->selectNavlist($where);
        //echo "<pre>";print_r($nav_list_rows);die;


        foreach ($nav_list_rows as $key => $value) {
            $nav_list_rows[$key]['status_name'] = $this->status_row[$value['status']];
            $nav_list_rows[$key]['nav_name']    = $nav_rows[$value['nav_id']];

        }

        $this->assign('nav_list_rows', $nav_list_rows);
        $this->assign('nav_rows', $nav_rows);
        $this->assign('param', $param);

        return $this->fetch();
    }

    public function add()
    {
        $nav_list = db('nav')->where('status', 1)->column('nav_name', 'nav_id');

        $this->assign('nav_list', $nav_list);
        return $this->fetch();
    }

    public function addExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data        = Request::instance()->param(false);
            $content_img = '';
            if ($data['content_img']) {
                $content_img = explode(',', $data['content_img']);
            }

            if ($content_img) {
                foreach ($content_img as $key => $value) {
                    if (!$value) {
                        unset($content_img[$key]);
                    }
                }
                $data['thumimg']=$content_img[0];
            }

            $content = ['content_text' => $data['content_text'], 'content_img' => $content_img];

            $data['content'] = json_encode($content);

            //var_dump($data);die;

            $val_rs = $this->validate($data, 'NavList');

            if (true !== $val_rs) {
                $this->error($val_rs);
            } else {
                unset($data['content_img']);
                unset($data['content_text']);
                $data['clickcount'] = 0;
                $data['zan']        = 0;
                $data['createtime'] = date('Y-m-d H:i:s', time());
                $data['status']     = 1;
                Db::startTrans();
                $navlistService = new NavlistService();
                $rs             = $navlistService->insertNavlist($data);
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
            $data = Request::instance()->param(false);
            Db::startTrans();
            $navlistService = new NavlistService();
            $rs             = $navlistService->deleteNavlist($data['list_id']);
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
            $navlistService = new NavlistService();
            $rs             = $navlistService->updateNavlist($data);
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

            $nav_rows = db('nav')->column('nav_name', 'nav_id');

            $nav_list_row             = Db('nav_list')->where('list_id', $data['list_id'])->find();
            $nav_list_row['nav_name'] = $nav_rows[$nav_list_row['nav_id']];

            $content                      = json_decode($nav_list_row['content'], true);
            $nav_list_row['content_text'] = $content['content_text'];

            $nav_list_row['content_img']  = $content['content_img'];
//            var_dump($nav_list_row['content_img']);
//            die;
            //$nav_list_row['content_text'] =


            $this->assign('nav_rows', $nav_rows);
            $this->assign('nav_list_row', $nav_list_row);

            return $this->fetch();
        }


    }

    public function editExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);
            $content_img = '';
            if ($data['content_img']) {
                $content_img = explode(',', $data['content_img']);
            }

            if ($content_img) {
                foreach ($content_img as $key => $value) {
                    if (!$value) {
                        unset($content_img[$key]);
                    }
                }

                $data['thumimg']=$content_img[0];
            }

            $content = ['content_text' => $data['content_text'], 'content_img' => $content_img];

            $data['content'] = json_encode($content);

            unset($data['content_text']);
            unset($data['content_img']);

            //print_r($data);die;
            Db::startTrans();
            $navListService = new NavListService();
            $rs             = $navListService->updateNavList($data);
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

    public function upload()
    {
        $file = request()->file('file');
        //var_dump($file);

        $folder = input('param.folder');
        $dir    = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'images' . DS . $folder;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $info = $file->validate(['size'=>1.5*1024*1024,'ext'=>'jpg,png,gif'])->move($dir);
        if ($info) {
            $filePath = DS . 'uploads' . DS . 'images' . DS . $info->getSaveName();
            $filePath = str_replace("\\", "/", $filePath);   //替换\为/
            return json(['state' => '上传成功', 'filePath' => $filePath]);
        } else {
            echo json(['state'=>$file->getError()]);
        }

    }
}
