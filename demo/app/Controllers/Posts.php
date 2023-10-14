<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Posts_model;
use App\Models\Comment_model;
use App\Models\Bookmarks_model;
use App\Models\CommentLike_model;

class Posts extends Controller
{
    public function index()
    {
        $model = new Posts_model();
        $data['posts'] = $model->getPosts();

        echo view('template/header');
        echo view('posts_list', $data);
        echo view('template/footer');
    }

    // display the post details page when user click in.
    public function show($postId)
    {
        $username = session()->get('username');

        $postModel = new Posts_model();
        $commentModel = new Comment_model();
        $bookmarksModel = new Bookmarks_model();
        $commentLikeModel = new CommentLike_model();

        $data['post'] = $postModel->getPost($postId);
        $data['comments'] = $commentModel->getComments($postId);
        $data['isBookmarked'] = $bookmarksModel->isBookmarked($postId, $username);
        $data['images'] = $postModel->getImagesByPostId($postId);
        
        foreach ($data['comments'] as $comment) {
            $comment->isLiked = $commentLikeModel->isLiked($comment->id, $username);
        }

        echo view('template/header');
        echo view('post_details', $data);
        echo view('template/footer');
    }

    public function addComment()
    {
        $postId = $this->request->getPost('post_id');
        $username = $this->request->getPost('username');
        $content = $this->request->getPost('content');

        $model = new Comment_model();
        $comments = $model->addComment($postId, $username, $content);
        if ($comments) {
            return redirect()->to(base_url('posts/'.$postId));
        }
    }

    public function fetchPosts()
    {
        $courseCode = $this->request->getPost('courseCode');
        $page = $this->request->getPost('page');
    
        // Define the number of posts to fetch per page
        $perPage = 8;
    
        // Calculate the offset based on the page number and perPage value
        $offset = ($page - 1) * $perPage;
    
        // Create an instance of the PostsModel
        $postsModel = new Posts_model();
    
        // Fetch the posts with the given course_code and pagination
        $posts = $postsModel->getPostsByCourseCode($courseCode, $perPage, $offset);
    
        // Pass the fetched posts to the view
        return $this->response->setJSON(['success' => true, 'posts' => $posts]);
    }
    
}
