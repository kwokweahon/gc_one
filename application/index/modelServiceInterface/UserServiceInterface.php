<?php

namespace app\index\modelServiceInterface;
interface UserServiceInterface{
    /**
     * 添加用户
     * @name string 用户名
     * @return mixed 返回列用户表数组
     */
    public function add();
}