<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-07
 * Time: 18:37
 */

namespace app\admin\modelService;

use app\admin\model\User;
use app\admin\modelServiceInterface\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function selectUser($where=null)
    {
        $user      = new User();
        $user_rows = $user->where($where)->order('user_id', 'desc')->paginate(20);

        return $user_rows;
    }
}