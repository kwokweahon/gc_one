<?php

namespace app\admin\modelServiceInterface;

interface JobServiceInterface{
    /**
     * 查询栏目
     * @$where array 查询条件
     * @return 返回目标数据
     */
    public function selectJob($where=null);

    /**
     * 删除栏目
     * @n$data string 删除的id用逗号隔开
     * @return 返回成功数量
     */
    public function deleteJob($data);
}

