<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 22:32
 */

namespace app\admin\controller;


use app\admin\modelService\CompanyService;
use think\Controller;
use think\Request;
use think\Db;

class Company extends Controller
{
    public function index()
    {
        $companyService = new CompanyService();
        $company_row    = $companyService->selectCompany();

        $this->assign('company_row', $company_row);

        return $this->fetch();
    }

    public function editExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);

            //print_r($data);die;

            $val_rs = $this->validate($data, 'Company');

            if (true !== $val_rs) {
                $this->error($val_rs);
            } else {
                Db::startTrans();
                $companyService = new CompanyService();
                $rs             = $companyService->updateCompany($data);

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
    }
}