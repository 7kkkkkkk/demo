<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email', 'filename', 'verification_code'];
    public function login($username, $password)
    {        
        $query = $this->where('username', $username)->get();   
        if ($query->getRowArray()) {
            $data = $query->getRowArray();
            if (password_verify($password, $data['password'])) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function check() {
        $query = $this->where('username', 'infs3202')->get();  
        if ($query->getRowArray()) {
            return $query->getRowArray();
        }
    }

    public function get_data($username)
    {
        $query = $this->where('username', $username)->get();   
        if ($query->getRowArray()) {
            return $query->getRowArray();
        }
        return false;
    }

    public function update_profile($oldUsername, $data){
        $db = \Config\Database::connect();
        $builder = $db->table('users');

        $isUserExisted = $this->where('username', $data['username'])->first();
        $isEmailExisted = $this->where('email', $data['email'])->first();
        $oldEmail = $this->where('username', $oldUsername)->first()['email'];
        if ($isUserExisted !== NULL && $data['username'] !== $oldUsername) {
            throw new \Exception('Username already exists');
        } elseif ($isEmailExisted !== NULL && $data['email'] !== $oldEmail) {
            throw new \Exception('Email already exists');
        }
        $builder->where('username', $oldUsername)->set($data)->update();
    }

    public function update_data($username, $data){
        $db = \Config\Database::connect();
        $builder = $db->table('users');

        $builder->where('username', $username)->set($data)->update();
    }

    public function upload_filename($username, $filename)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        if ($builder->where('username', $username)->update(['filename' => $filename])) {
            return true;
        } else {
            return false;
        }
    }

    public function update_verification_status($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        if ($builder->where('username', $username)->update(['verification_status' => 1])) {
            return true;
        } else {
            return false;
        }
    }
}
