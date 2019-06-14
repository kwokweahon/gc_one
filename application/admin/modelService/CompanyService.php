<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-08
 * Time: 22:33
 */

namespace app\admin\modelService;


use app\admin\model\Company;

class CompanyService
{
    public function selectCompany($where=null)
    {
        $company      = new Company();
        $company_row = $company->where($where)->find();

        return $company_row;
    }

    public function updateCompany($data)
    {
        $company      = new Company();
        $rs  = $company->update($data);

        if ($rs) {
            return 1;
        } else {
            return 0;
        }

    }
}