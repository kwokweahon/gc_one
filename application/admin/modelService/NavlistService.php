<?php


namespace app\admin\modelService;
use app\admin\model\NavList;
use app\admin\modelServiceInterface\NavListServiceInterface;

class NavlistService implements NavlistServiceInterface
{
    public function insertNavlist($data)
    {
        $nav_list = new NavList();
        $nav_list->data($data);
        $nav_list->save();

        return $nav_list->list_id;
    }

    public function selectNavlist($where=null)
    {
        $nav_list      = new Navlist();
        $nav_list_rows = $nav_list->where($where)->order('list_id', 'desc')->paginate(10);

        return $nav_list_rows;
    }

    public function deleteNavlist($data)
    {

        $del_num = NavList::destroy($data);

        return $del_num;
    }

    public function updateNavlist($data)
    {
        $nav_list = new Navlist();
        $rs  = $nav_list->update($data);

        if ($rs) {
            return 1;
        } else {
            return 0;
        }

    }
}