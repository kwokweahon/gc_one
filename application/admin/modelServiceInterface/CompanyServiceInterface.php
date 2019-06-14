<?php

namespace app\admin\modelServiceInterface;

interface CompanyServiceInterface{
    /**
     * 查询栏目
     * @$where array 查询条件
     * @return 返回目标数据
     */
    public function selectCompany($where=null);

    /**
     * 删除栏目
     * @$data array 需要修改项的数组
     * @return 返回0或者1
     */
    public function updateCompany($data);
}