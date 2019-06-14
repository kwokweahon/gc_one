<?php
namespace app\admin\modelServiceInterface;

interface UserServiceInterface{

    /**
     * 查询栏目
     * @$where array 查询条件
     * @return 返回目标数据
     */
    public function selectUser($where=null);
}