<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\User_model;
use CodeIgniter\Email\Email;

class ResetPassword extends Controller
{
    protected $helpers = ['form'];
    public function index()
    {
        echo view('template/header');
        echo view('forgot_password');
        echo view('template/footer');
    }
    public function sendEmail()
    {
        $model = new User_model();
        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|alpha_numeric|min_length[3]|max_length[15]',
                'errors' => [
                    'required' => 'All accounts must have {field} provided.',
                    'alpha_numeric' => 'The username field can only contain alphabetical and numeric characters.',
                    'min_length' => 'The length of the username should longer than 3 characters',
                    'max_length' => 'The max length of username is 15 characters long.',
                ],
            ],
            // 'password' => [
            //     'label'  => 'Password',
            //     'rules'  => 'required|min_length[6]|max_length[15]|matches[passconf]',
            //     'errors' => [
            //         'required' => 'The password field is required',
            //         'min_length' => 'The password strenth is too weak, it must be at least {param} characters long.',
            //         'max_length' => 'The max length of password is 15 characters long.',
            //         'matches' => 'The password and confirmation password do not match.',
            //     ],
            // ],
            // 'passconf' => [
            //     'label'  => 'Confirm Password',
            //     'rules'  => 'required|matches[password]',
            //     'errors' => [
            //         'matches' => 'The confirmation password and password do not match.',
            //     ],
            // ],
        ];

        if (! $this->validate($rules)) {
            echo view('template/header');
            echo view('signup', ['validation' => $this->validator]);
            echo view('template/footer');
            
        } else {
            $username = $this->request->getPost('username');
            $userExist = $model->get_data($username);
            if ($userExist) {
                $session = session();
                $session->set('username', $username);
                $verificationCode = rand(100000, 999999);

                // $password = $this->request->getPost('password');
                $email = $model->get_data($username)['email'];
                $data = [
                    // 'password' => password_hash($password, PASSWORD_DEFAULT),
                    'verification_code' => $verificationCode,
                ];
                $model->update_data($username, $data);

                $sendResult = $this->email_verification($email, $verificationCode);
                if ($sendResult) {
                    $data = ['source' => 'forgot-password'];
                    echo view('template/header');
                    echo view('email_verification', $data);
                    echo view('template/footer');
                } else {
                    echo view('template/header');
                    $data = ['error' => 'Error sending email. Please try again later.'];
                    echo view('forgot_password', $data);
                    echo view('template/footer');
                }
            } else {
                echo view('template/header');
                $data = ['error' => 'Invalid username'];
                echo view('forgot_password', $data);
                echo view('template/footer');
            }
        }
    }

    public function email_verification($toEmail, $verificationCode) {
        $email = new Email();

        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25
        ];
        $email->initialize($emailConf);
        $email->setTo($toEmail);
        $email->setFrom("leyi.deng@uq.edu.au", "Leyi");
        $email->setSubject('Verify Your Email Address');
        $email->setMessage('Please enter the following verification code to confirm your email address: ' . $verificationCode);
        return $email->send();
    }

    public function resetPassword() {
        $model = new User_model();
        $rules = [
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[6]|max_length[15]',
                'errors' => [
                    'required' => 'The password field is required',
                    'min_length' => 'The password strenth is too weak, it must be at least {param} characters long.',
                    'max_length' => 'The max length of password is 15 characters long.',
                ],
            ],
            'passconf' => [
                'label'  => 'Confirm Password',
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'matches' => 'The confirmation password and password do not match.',
                ],
            ],
        ];
        if (! $this->validate($rules)) {
            echo view('template/header');
            echo view('reset_password', ['validation' => $this->validator]);
            echo view('template/footer');
            
        } else {
            $username = session()->get('username');
            $password = $this->request->getPost('password');
            $data = [
                'password' => password_hash($password, PASSWORD_DEFAULT)
                // 'password' => $password
            ];
            $model->update_data($username, $data);  
            $data = ['success' => 'Congratulations! You have changed your password successfully!'];
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    } 
    public function check_verification() {
        $inputCode = $this->request->getPost('verification_code');
        $username = session()->get('username');
        $model = new User_model();
        if ( ! $model->where('username', $username)) {
            return redirect()->to(base_url('forgot_password'));
        } else {
            $verificationCode = ($model->get_data($username))['verification_code'];
            if ($verificationCode == $inputCode) {
                $model->update_verification_status($username);
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
    }
}