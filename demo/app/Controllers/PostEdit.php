<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Posts_model;
use App\Models\Course_model;

class PostEdit extends Controller
{ 
    public function index()
    {
        $username = session()->get('username');

        $courseModel = new Course_model();
        $userCourses = $courseModel->getUserCourse($username);
        $data = [
            'user_courses' => $userCourses
        ];
        
        echo view('template/header');
        echo view('post_edit', $data);
        echo view('template/footer');
    }

    public function upload_image()
    {        
        $imagePaths = [];
        if ($imagefile = $this->request->getFiles()) {
            foreach ($imagefile['images'] as $img) {
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(WRITEPATH . 'uploads', $newName);
                    array_push($imagePaths, $newName);
                }
            }
            return $this->response->setJSON(['success' => true, 'imagePaths' => $imagePaths]);
        } else {
            return $this->response->setJSON(['fail' => true]);
        }     
    }    

    public function post()
    {
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');
        $images = $this->request->getPost('images');
        if (strpos($images[0], ',') !== false) {
            // Multiple values separated by commas
            $imageArray = explode(',', $images[0]);
        } else {
            // String is a single value
            $imageArray = array($images[0]);
        }        
        // print_r($imageArray);
        $course_code = $this->request->getPost('course');
        $currentDateTime = new \DateTime();
        $dateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $data = [
            'title' => $title,
            'content' => $content,
            'username' => session()->get('username'),
            'created_at' => $dateTimeString,
            'course_code' => $course_code,
        ];
        $model = new Posts_model();
        $postId = $model->createPost($data);
        foreach ($imageArray as $image) {
            $imageData = [
                'post_id' => $postId,
                'image_path' => $image,
            ];
            $model->insertPostImages($imageData);
        }
        return redirect()->to(base_url('/'));
    }
}
