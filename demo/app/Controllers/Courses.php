<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Course_model;

class Courses extends Controller
{ 
    public function addCourse()
    {
        $courseCode = $this->request->getPost('course_code');
        
        // Get the currently logged-in user's ID or username
        $username = session()->get('username');
        
        // Load the Course_model
        $courseModel = new Course_model();
        
        // Add the course for the user
        $courseModel->addUserCourse($username, $courseCode);
        
        // Redirect the user back to the index page or any other appropriate page
        return redirect()->to(base_url());

    }
}
