<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-06-07
 * Time: 17:26
 */

namespace app\admin\controller;

use app\admin\modelService\UserService;
use think\Controller;
use think\Request;
use think\Db;

class User extends Controller
{
    public $gender_row = [1 => '男', 2 => '女'];

    public function index()
    {

        $param = input('post.');
        $where = [];

        if (isset($param['keyword']) && strlen($param['keyword'])) {
            $where['username|mobile'] = ['like', '%' . $param['keyword'] . '%'];
        } else {
            $param['keyword'] = '';
        }

        $userService = new UserService();
        $user_rows   = $userService->selectUser($where);

        foreach ($user_rows as $key => $value) {
            $user_rows[$key]['gender_name'] = $this->gender_row[$value['gender']];
            if (!$value['avatar_url']) {
                $user_rows[$key]['avatar_url'] = '/img/default_avatar.jpg';
            }
        }
        //echo "<pre>";print_r($user_rows->toArray());die;

        $this->assign('user_rows', $user_rows);
        $this->assign('param', $param);

        return $this->fetch();
    }


    public function detail()
    {

        if (Request::instance()->isGet()) {
            $data     = Request::instance()->param(false);
            $user_row = Db('User')->where('user_id', $data['user_id'])->find();

            $user_row['gender_name'] = $this->gender_row[$user_row['gender']];

            if (!$user_row['avatar_url']) {
                $user_row['avatar_url'] = '/img/default_avatar.jpg';
            }

            $this->assign('user_row', $user_row);

//            var_dump($user_row);
//            die;

            return $this->fetch();
        }
    }
}