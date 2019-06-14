<?php
/**
 * Created by PhpStorm.
 * User: kwokweahon
 * Date: 2019-05-29
 * Time: 20:42
 */

namespace app\admin\controller;
use app\admin\modelService\CommentService;
use think\Controller;
use think\Request;
use think\Db;

class Comment extends Controller
{
    public function index()
    {

        $commentService = new CommentService();
        $comment_rows   = $commentService->selectComment();

        foreach ($comment_rows as $key => $value) {
            $comment_rows[$key]['list_title'] = db('nav_list')->where('list_id', $value['list_id'])->value('title');
        }

        //echo "<pre>";print_r($comment_rows->toArray());die;

        $this->assign('comment_rows', $comment_rows);

        return $this->fetch();
    }

    public function deleteExe()
    {
        $result = true;
        if (Request::instance()->isAjax()) {
            $data = Request::instance()->param(false);
            Db::startTrans();
            $commentService = new CommentService();
            $rs             = $commentService->deleteComment($data['comment_id']);
            if ($rs <= 0) {
                $result = false;
            }
            if ($result) {
                Db::commit();
                $this->success('删除成功', null, $rs);
            } else {
                Db::rollback();
                $this->error('操作失败');
            }
        }
    }
}