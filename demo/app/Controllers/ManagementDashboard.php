<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Posts_model;
use App\Models\Course_model;;

class ManagementDashboard extends Controller
{ 
    public function index()
    {
        $course_model = new Course_model();
        $postModel = new Posts_model();

        $data['enrollmentData'] = $course_model->getEnrollmentCountByCourse();
        $data['postsByCourse'] = $postModel->getPostsEachCourse();

        echo view('template/header');
        echo view('management-dashboard', $data);
        echo view('template/footer');
    }
}
