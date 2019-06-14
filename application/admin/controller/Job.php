<?php

namespace app\admin\controller;

use app\admin\modelService\JobService;
use think\Controller;
use think\Request;
use think\Db;

class Job extends Controller
{
    public $status_row = [0 => '未处理', 1 => '已处理'];

    public function index()
    {

        $jobService = new JobService();
        $job_rows   = $jobService->selectjob();

        foreach ($job_rows as $key => $value) {
            $job_rows[$key]['username']    = Db('User')->where('user_id', $value['user_id'])->value('username');
            $job_rows[$key]['status_name'] = $this->status_row[$value['status']];
        }

        //echo "<pre>";print_r($job_rows->toArray());die;

        $this->assign('job_rows', $job_rows);

        return $this->fetch();
    }

    public function detail()
    {
        if (Request::instance()->isGet()) {
            $data    = Request::instance()->param(false);
            $job_row = Db('Job')->where('job_id', $data['job_id'])->find();


            $job_row['user_name']    = Db('User')->where('user_id', $job_row['user_id'])->value('username');
            $job_row['status_name'] = $this->status_row[$job_row['status']];


            $this->assign('job_row', $job_row);

            //var_dump($job_row);die;

            return $this->fetch();
        }

    }

    public function replay()
    {
        if (Request::instance()->isGet()) {
            $data    = Request::instance()->param(false);
            $job_row = Db('Job')->where('job_id', $data['job_id'])->find();

            $this->assign('job_row', $job_row);

            //var_dump($job_row);die;

            return $this->fetch();
        }

    }

    public function replayExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data           = Request::instance()->param(false);
            $data['status'] = 1;
            //print_r($data);die;
            Db::startTrans();
            $jobService = new JobService();
            $rs         = $jobService->updateJob($data);
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

    public function deleteExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);
            Db::startTrans();
            $jobService = new JobService();
            $rs         = $jobService->deletejob($data['job_id']);
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