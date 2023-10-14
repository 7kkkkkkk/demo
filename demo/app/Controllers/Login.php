<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Course_model;

class Login extends Controller
{
    public function login()
    {
        // If user click 'remember me'
        if (isset($_COOKIE['username'])) {
            return redirect()->to(base_url('/home'));
        }
        else {
            // If user already login
            $session = session();
            $username = $session->get('username');
            // $password = $session->get('password');
            // if ($username && $password) {
            if ($username) {
                return redirect()->to(base_url('/home'));
            } else {
                $data['showNavbar'] = false;
                echo view('template/header', $data);
                echo view('login');
                echo view('template/footer');
            }
        }
    }

    public function check_login()
    {
        $data = ['error' => 'Incorrect username or password!'];
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $if_remember = $this->request->getPost('remember');

        $model = model('App\Models\User_model');
        $check = $model->login($username, $password);
        if ($check) {
            $session = session();
            $session->set('username', $username);
            // $session->set('password', $password);
            if ($if_remember) {
                setcookie('username', $username, time() + (86400 * 30), "/");
            }
            return redirect()->to(base_url());
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function logout()
    {   
        helper('cookie');
        $session = session();
        $session->destroy();
        //destroy the cookie
        setcookie('username', '', time() - 3600, "/");
        return redirect()->to(base_url('login'));
    }
}