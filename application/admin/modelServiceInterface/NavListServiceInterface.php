<?php
namespace app\admin\modelServiceInterface;

interface NavlistServiceInterface
{
    /**
     * 添加栏目
     * @$data array 需要插入的数组
     * @return 返回插入的id
     */
    public function insertNavlist($data);

    /**
     * 查询栏目
     * @$where array 查询条件
     * @return 返回目标数据
     */
    public function selectNavlist($where=null);

    /**
     * 删除栏目
     * @n$data string 删除的id用逗号隔开
     * @return 返回成功数量
     */
    public function deleteNavlist($data);

    /**
     * 删除栏目
     * @$data array 需要修改项的数组
     * @return 返回0或者1
     */
    public function updateNavlist($data);
}