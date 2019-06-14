<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-05-27
 * Time: 16:33
 */


namespace app\index\modelService;

use components\core\BaseObject;
use app\index\modelServiceInterface\UserServiceInterface;
use app\index\model\User;
use app\index\model\Dao;

class UserService extends BaseObject implements UserServiceInterface
{
    /**
     * 添加用户
     * @name string 用户名
     * @return mixed
     * @return mixed
     * @return mixed
     */
    public function add()
    {
        Dao::beginTransAction();
        try {


            Dao::commit();

            return '';
        } catch (\Exception $e) {
            Dao::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }

    }

}