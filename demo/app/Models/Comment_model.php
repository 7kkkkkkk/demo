<?php

namespace App\Models;

use CodeIgniter\Model;

class Comment_model extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['post_id', 'username', 'content', 'created_at', 'updated_at', 'likes'];

    public function getComments($postId)
    {
        $query = $this->select('comments.*, users.filename')
            ->join('users', 'comments.username = users.username')
            ->where('comments.post_id', $postId)
            ->orderBy('comments.created_at', 'ASC')
            ->get();
    
        return $query->getResult();
    }
    
    
    public function addComment($postId, $username, $content)
    {
        $data = [
            'post_id' => $postId,
            'username' => $username,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->insert($data);
        return $result;
    }
    public function getLikeCount($comment_id)
    {
        $query = $this->where('id', $comment_id)
                ->get()
                ->getRow();
        return $query->likes;
    }
}