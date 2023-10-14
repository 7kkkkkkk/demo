<?php

namespace App\Models;

use CodeIgniter\Model;

class Posts_model extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'image', 'username', 'created_at', 'course_code'];

    public function getPosts()
    {
        $query = $this->orderBy('created_at', 'DESC')
                ->get();
        return $query->getResult();
    }

    public function getPost($id)
    {
        $query = $this->where('posts.id', $id)
                ->get();
        return $query->getRow();
    }

    public function createPost($data)
    {
        $this->insert($data);
        return $this->getInsertID();
    }    

    public function updatePost($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deletePost($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function searchPosts($keyword)
    {
        $query = $this->like('title', $keyword)
                ->get();
        
        return $query->getResult();
    }

    public function getPostsByCourseCode($courseCode, $perPage, $offset)
    {
        return $this->where('course_code', $courseCode)
                    ->findAll($perPage, $offset);
    }

    public function getPostsEachCourse()
    {
        $query = $this->db->table('posts')
            ->select('course_code, DATE(created_at) AS created_date, COUNT(*) AS post_count')
            ->where('created_at >=', '2023-05-15 00:00:00')
            ->where('created_at <=', '2023-05-19 23:59:59')
            ->groupBy('course_code, created_date')
            ->orderBy('course_code, created_date')
            ->get();
        // SELECT * FROM `posts` WHERE course_code = 'COMP3200' AND created_at >= '2023-05-15 00:00:00' AND created_at <= '2023-05-19 23:59:59';
        $results = $query->getResult();
    
        // Prepare the data array
        $courseData = [];
        foreach ($results as $row) {
            $courseCode = $row->course_code;
            $postCount = (int) $row->post_count;
    
            if (!isset($courseData[$courseCode])) {
                $courseData[$courseCode] = [
                    'course_code' => $courseCode,
                    'post_count' => [],
                ];
            }
    
            $courseData[$courseCode]['post_count'][] = $postCount;
        }
    
        // Return the course data
        return array_values($courseData);
    }
    public function insertPostImages($data) {
        $db = \Config\Database::connect();
        $query = $db->table('post_images');
        $query->insert($data);
    }

    public function getImagesByPostId($postId) {
        $db = \Config\Database::connect();
        $query = $db->table('post_images');
        $query->where('post_id', $postId);
        $result = $query->get()->getResultArray();
        return $result;
    }
}