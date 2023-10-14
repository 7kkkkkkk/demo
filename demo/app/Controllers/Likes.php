<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Comment_model;
use App\Models\CommentLike_model;

class Likes extends Controller
{
    public function updateLikes()
    {
        $commentId = $this->request->getPost('commentId');
        $isLiked = $this->request->getPost('isLiked');
        // it records which user like which comment in a post
        $commentLikeModel = new CommentLike_model();
        // it records comments in posts
        $commentModel = new Comment_model();

        if ($isLiked == "Like") {
            $data = [
                'username' => session()->get('username'),
                'comment_id' => $commentId,
            ];
            $commentLikeModel->insert($data);
             
        } else {
            $commentLikeModel->where('comment_id', $commentId)
                ->where('username', session()->get('username'))->delete();
        }
        // like count data is from comment like model
        $liekCount = $commentModel->getLikeCount($commentId);
        $response = [
            'success' => true,
            'likeCount' => $liekCount,
        ];

        return $this->response->setJSON($response);
    }
}
