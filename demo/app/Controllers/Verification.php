<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\User_model;

class Verification extends Controller
{
    public function checkVerification() {
        $inputCode = $this->request->getPost('verification_code');
        $username = session()->get('username');
        $source = $this->request->getPost('source');
        $model = new User_model();
        if ($source == 'forgot-password') {        
            if ( ! $model->where('username', $username)) {
                return redirect()->to(base_url('forgot_password'));
            } else {
                $verificationCode = ($model->get_data($username))['verification_code'];
                if ($verificationCode == $inputCode) {
                    echo view('template/header');
                    echo view('reset_password');
                    echo view('template/footer');
                } else {
                    $data = [
                        'error' => 'Verification code is incorrect. Please try again.',
                        'source' => 'forgot-password'
                    ];
                    echo view('template/header');
                    echo view('email_verification', $data);
                    echo view('template/footer');
                }
            }
        } else if ($source == 'signup') {
            if ( ! $model->where('username', $username)) {
                return redirect()->to(base_url('signup'));
            } else {
                $verificationCode = ($model->get_data($username))['verification_code'];
                if ($verificationCode == $inputCode) {
                    $model->update_verification_status($username);
                    $data = ['success' => 'Congratulations! You have created an account successfully!'];
                    echo view('template/header');
                    echo view('login', $data);
                    echo view('template/footer');
                } else {
                    $data = [
                        'error' => 'Verification code is incorrect. Please try again.',
                        'source' => 'signup'
                    ];
                    echo view('template/header');
                    echo view('email_verification', $data);
                    echo view('template/footer');
                }
            }
        }
    }
}
