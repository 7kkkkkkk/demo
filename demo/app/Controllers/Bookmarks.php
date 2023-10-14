<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Bookmarks_model;

class Bookmarks extends Controller
{
    public function updateBookmark()
    {
        $postId = $this->request->getPost('postId');
        $isBookmarked = $this->request->getPost('isBookmarked');
        $username = session()->get('username');
        $model = new Bookmarks_model();

        if ($isBookmarked == "false") {
            $data = [
                'username' => $username,
                'post_id' => $postId,
            ];
            $model->insert($data);
             
        } else {
            $model->deleteBookmark($username, $postId);
        }

        $response = [
            'success' => true,
        ];

        return $this->response->setJSON($response);
    }
}
