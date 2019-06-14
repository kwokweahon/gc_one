<?php

namespace app\admin\modelService;


use app\admin\modelServiceInterface\NavServiceInterface;

use app\admin\model\Nav;

class NavService implements NavServiceInterface
{
    public function insertNav($data)
    {
        $nav = new Nav;
        $nav->data($data);
        $nav->save();

        return $nav->nav_id;
    }

    public function selectNav($where=null)
    {
        $nav      = new Nav;
        $nav_rows = $nav->where($where)->order('nav_id', 'desc')->paginate(20);

        return $nav_rows;
    }

    public function deleteNav($data)
    {

        $del_num = Nav::destroy($data);

        return $del_num;
    }

    public function updateNav($data)
    {
        $nav = new Nav;
        $rs  = $nav->update($data);

        if ($rs) {
            return 1;
        } else {
            return 0;
        }

    }


}