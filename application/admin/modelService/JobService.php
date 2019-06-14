<?php

namespace app\admin\modelService;
use app\admin\model\Job;
use app\admin\modelServiceInterface\JobServiceInterface;

class JobService implements JobServiceInterface
{
    public function selectJob($where=null)
    {
        $job      = new Job();
        $job_rows = $job->where($where)->paginate(20);

        return $job_rows;
    }

    public function deleteJob($data)
    {

        $del_num = Job::destroy($data);

        return $del_num;
    }

    public function updateJob($data)
    {
        $job = new Job;
        $rs  = $job->update($data);

        if ($rs) {
            return 1;
        } else {
            return 0;
        }

    }

}