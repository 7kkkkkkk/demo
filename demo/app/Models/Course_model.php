<?php

namespace App\Models;

use CodeIgniter\Model;

class Course_model extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_code';
    protected $allowedFields = ['course_code', 'course_name'];
    public function getUserCourse($username)
    {
        $query = $this->table('courses')
                      ->select('courses.*')
                      ->join('user_courses', 'user_courses.course_code = courses.course_code')
                      ->where('user_courses.username', $username)
                      ->get();
    
        return $query->getResult();
    }    

    public function addUserCourse($username, $courseCode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');
        $data = array(
            'username' => $username,
            'course_code' => $courseCode
        );
        $result = $builder->insert($data);
        return $result;
    }
    public function isUserCourseExists($username, $courseCode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');
        $builder->select('*');
        $builder->where('username', $username);
        $builder->where('course_code', $courseCode);
        $result = $builder->get()->getRow();
    
        return ($result !== null);
    }
    
    public function getAllCourses($username)
    {
        $userCourses = $this->getUserCourse($username);
        $courses = $this->findAll();
    
        $filteredCourses = [];
        foreach ($courses as $course) {
            $alreadyAdded = false;
            foreach ($userCourses as $userCourse) {
                if ($course['course_code'] === $userCourse->course_code) {
                    $alreadyAdded = true;
                    break;
                }
            }
            if (!$alreadyAdded) {
                $filteredCourses[] = $course;
            }
        }
    
        return $filteredCourses;
    }

    public function getRandomUserCourse()
    {
        // $db = \Config\Database::connect();
        // $builder = $db->table('user_courses');
        // $builder->select('*');
        // // $builder->where('course_code', 'COMP3200');
        // $builder->orderBy('RAND()');
        // $builder->limit(1);
        // $query = $builder->get();
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');
        $builder->select('*');
        $builder->orderBy('RAND()');
        $builder->limit(1);
        $query = $builder->get();
    
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row;
        }
    
        return null;
    }    

    public function getEnrollmentCountByCourse()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');
        $builder->select('course_code, COUNT(*) as enrollment_count');
        $builder->groupBy('course_code');
        $result = $builder->get()->getResult();

        return $result;
    }
}
