<?php

namespace App\Models;

use CodeIgniter\Model;

class Bookmarks_model extends Model
{
    protected $table = 'bookmarks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'username', 'post_id'];

    public function isBookmarked($post_id, $username)
    {
        $query = $this->where('username', $username)
                ->where('post_id', $post_id)
                ->get();
        $result = $query->getResult();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteBookmark($username, $postId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bookmarks');
        $builder->where('username', $username);
        $builder->where('post_id', $postId);
        $builder->delete();
    }
}