<?php
namespace app\index\controller;

use think\Request;

class Index extends \think\Controller
{
    //json 返回
    public function index()
    {
        if(Request::instance()->isPost()){
            echo '<pre>';
            print_r(imageUpload());
            echo '</pre>';die;
        }else{
            return view('frq');
        }

    }
    //视图渲染
    public function frq(){
        return view('frq');
    }

    //表单校验
    public function add(){
        if(Request::instance()->isPost()){
            $data = Request::instance()->param(false);
            $result = $this->validate($data,'User');
            if($result){
                $this->error('校验失败','http://localhost/thinkphp5/public/index.php');
            }else{
               $userService = new \app\index\modelService\UserService();
               $ret = $userService->add();
               return json($ret);
               //$this->fetch('frq',$ret);
                //$this->success('校验成功','http://localhost/thinkphp5/public/index.php');
            }
        }
    }

}
