<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\User_model;
use App\Models\Image_model;

class Profile extends Controller
{
    public function index()
    {
        // Once login, the user can see profile page.
        $model = new User_model();
        $username = session()->get("username");
        $data = $model->get_data($username);
        
        echo view('template/header');
        echo view('profile', $data);
        echo view('template/footer');
    }

    public function edit_profile() {
        $email = $this->request->getPost("email");
        $username = $this->request->getPost("username");
        $data = [
            'email' => $email,
            'username' => $username,
        ];
        $model = new User_model();
        $oldUsername = session()->get("username");
        try {
            $model->update_profile($oldUsername, $data);
            session()->set('username', $username);
            return redirect()->to(base_url('profile'));
        } catch (\Exception $e) {
            $data = $model->get_data($oldUsername);
            $data['error'] = $e->getMessage();
            echo view('template/header');
            echo view('profile', $data);
            echo view('template/footer');
        }
    }

    public function upload_image() {
        $username = session()->get('username');
        $model = new User_model();

        $picData = $this->upload();
        $userData = $model->get_data($username);

        echo view('template/header');
        echo view('profile', $picData + $userData);
        echo view('template/footer');
    }

    public function select_image() {
        $username = session()->get('username');
        $profilePictureUrl = $this->request->getPost('profile-picture');
        $model = new User_model();

        $data = [
            'filename' => $profilePictureUrl,
        ];
        $model->upload_filename($username, $data);
        return redirect()->to(base_url('profile'));
    }

    public function upload()
    {
        helper(['form', 'url']);
        
        $rules = [
            'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,jpg,jpeg,png,gif]',
        ];
        
        if ($this->validate($rules)) {
            $image = $this->request->getFile('image');
            
            $newName = $image->getRandomName();
            
            $path = ROOTPATH.'writable/uploads/';

            $image->move($path,$newName);

            $imageModel = new Image_model();

            // Crop the image
            $cropImage = $imageModel->crop($path,$newName);

            // Rotate the image
            $rotImage = $imageModel->rotate($path, $newName, 60);          
            
            $data['success'] = 'Image uploaded successfully.';
            $data['original'] = '/demo/writable/uploads/'.$newName; 
            $data['crop'] = '/demo/writable/uploads/'.$cropImage;
            $data['rot'] = '/demo/writable/uploads/'.$rotImage;            

            return $data;
        } else {
            $data['validation'] = $this->validator;
            return view('profile', $data);
        }
    }
}