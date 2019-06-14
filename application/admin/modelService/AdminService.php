<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 15:55
 */

namespace app\admin\modelService;


use app\admin\model\Admin;
use app\admin\modelServiceInterface\AdminServiceInterface;

class AdminService implements AdminServiceInterface
{
    public function insertAdmin($data)
    {
        $admin = new Admin;
        $admin->data($data);
        $admin->save();

        return $admin->admin_id;
    }

    public function selectAdmin($where=null)
    {
        $admin      = new Admin();
        $admin_rows = $admin->where($where)->order('admin_id', 'desc')->paginate(20);

        return $admin_rows;
    }

    public function deleteAdmin($data)
    {

        $del_num = Admin::destroy($data);

        return $del_num;
    }
}