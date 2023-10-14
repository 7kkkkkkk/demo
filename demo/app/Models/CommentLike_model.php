<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentLike_model extends Model
{
    protected $table = 'comments_likes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'username', 'comment_id'];

    public function isLiked($comment_id, $username)
    {
        $query = $this->where('username', $username)
                ->where('comment_id', $comment_id)
                ->get();
        $result = $query->getResult();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}