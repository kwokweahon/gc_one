<?php

/**
 * 文件上传
 * @param null $saveFullPath 文件保存绝对路径 /data/nginx/xiangmu/upload/images/tenxun/shop
 * @param null $domainPath 文件保存相对路径（必须包含在 $saveFullPath 内）/upload/images/tenxun/shop
 * @return array
 */
function imageUpload($saveFullPath = null,$domainPath = null){
    $domainPath = empty($domainPath) ? DS . 'public' . DS . 'uploads' . DS . date('Ymd') . DS: $domainPath;
    $saveFullPath = empty($saveFullPath) ? ROOT_PATH . 'public' . DS . 'uploads' . DS . date('Ymd') : $saveFullPath;

    $files = isset($_FILES) ? $_FILES : [];
    $returnArr = array();
    if (!empty($files)) {
        // 处理上传文件
        $array = [];
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $item  = [];
                $keys  = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++) {
                    if (empty($file['tmp_name'][$i]) || !is_file($file['tmp_name'][$i])) {
                        continue;
                    }
                    $temp['key'] = $key;
                    foreach ($keys as $_key) {
                        $temp[$_key] = $file[$_key][$i];
                    }
                    $item[] = (new \think\File($temp['tmp_name']))->setUploadInfo($temp);
                }
                $array[$key] = $item;
            } else {
                if ($file instanceof \think\File) {
                    $array[$key] = $file;
                } else {
                    if (empty($file['tmp_name']) || !is_file($file['tmp_name'])) {
                        continue;
                    }
                    $array[$key] = (new \think\File($file['tmp_name']))->setUploadInfo($file);
                }
            }
        }
        if(!empty($array)){
            foreach ($array as $filename => $fileObjct){
                if ($fileObjct instanceof \think\File) {
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $fn = ($fileObjct->getInfo())['name'];
                    $sn = md5((microtime(true)) . uniqid() . rand(1000000000,99999999999)). '.' . (explode('.',$fn))[1];
                    $info = $fileObjct->move($saveFullPath,$sn);
                    $returnArr[$filename] = $domainPath.$info->getSaveName();
                } else if(is_array($fileObjct)){
                    foreach($fileObjct as $k => $f){
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $fn = ($f->getInfo())['name'];
                        $sn = md5((microtime(true)) . uniqid() . rand(1000000000,99999999999)). '.' . (explode('.',$fn))[1];
                        $inf = $f->move($saveFullPath,$sn);
                        $returnArr[$filename][$k] = $domainPath.$inf->getSaveName();
                    }
                }
            }
        }

    }
    return $returnArr;
}
