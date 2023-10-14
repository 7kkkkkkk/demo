<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Course_model;

class Home extends Controller
{
    public function index()
    {
        $username = session()->get('username');

        $courseModel = new Course_model();
        $allCourses = $courseModel->getAllCourses($username);
        $userCourses = $courseModel->getUserCourse($username);
        $data = [
            'user_courses' => $userCourses,
            'allCourses' => $allCourses
        ];
        
        echo view("template/header");
        echo view("index", $data);
        echo view("template/footer");
    }
}
