<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\User_model;
use CodeIgniter\Email\Email;

class Signup extends Controller
{
    protected $helpers = ['form'];
    public function index()
    {
        $data['error'] = "";
        echo view('template/header');
        echo view('signup');
        echo view('template/footer');
    }
    public function sendEmail()
    {
        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|alpha_numeric|min_length[3]|max_length[15]|is_unique[users.username]',
                'errors' => [
                    'required' => 'All accounts must have {field} provided.',
                    'alpha_numeric' => 'The username field can only contain alphabetical and numeric characters.',
                    'min_length' => 'The length of the username should longer than 3 characters',
                    'max_length' => 'The max length of username is 15 characters long.',
                ],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[6]|max_length[15]|matches[passconf]',
                'errors' => [
                    'required' => 'The password field is required',
                    'min_length' => 'The password strenth is too weak, it must be at least {param} characters long.',
                    'max_length' => 'The max length of password is 15 characters long.',
                    'matches' => 'The password and confirmation password do not match.',
                ],
            ],
            'passconf' => [
                'label'  => 'Confirm Password',
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'matches' => 'The confirmation password and password do not match.',
                ],
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'The email field is required.',
                    'valid_email' => 'The email must be a valid email.'
                ],
            ],
        ];
     
        if (! $this->validate($rules)) {
            echo view('template/header');
            echo view('signup', ['validation' => $this->validator]);
            echo view('template/footer');
            
        } else {
            $model = new User_model();

            $verificationCode = rand(100000, 999999);

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $username = $this->request->getPost('username');

            $model->save([
                'email' => $email,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'verification_code' => $verificationCode,
            ]);

            // Set the username in order to get the verification code from database later.
            $session = session();
            $session->set('username', $username);

            $sendResult = $this->email_verification($email, $verificationCode);
            if ($sendResult) {
                $data = ['source' => 'signup'];
                echo view('template/header');
                echo view('email_verification', $data);
                echo view('template/footer');
            } else {
                $data = ['error' => 'Error sending email. Please try again later.'];
                echo view('template/header');
                echo view('signup', $data);
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
}
