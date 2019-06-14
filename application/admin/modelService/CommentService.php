<?php


namespace app\admin\modelService;
use app\admin\model\Comment;
use app\admin\modelServiceInterface\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    public function selectComment($where=null)
    {
        $comment      = new Comment();
        $comment_rows = $comment->where($where)->order('comment_id', 'desc')->paginate(20);

        return $comment_rows;
    }

    public function deleteComment($data)
    {

        $del_num = Comment::destroy($data);

        return $del_num;
    }

}