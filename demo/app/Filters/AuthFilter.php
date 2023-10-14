<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in
        if (!$this->isLoggedIn()) { // Customize this function based on your authentication system
            // Redirect to login page or show access denied message
            return redirect()->to(base_url('/login'));
        }
       

        // User is logged in, allow access to the page
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the controller executes
        return $response;
    }

    protected function isLoggedIn()
    {
        $cookieUsername = isset($_COOKIE['username']);
        $sessionUsername = session()->get('username');

        return $cookieUsername || $sessionUsername;
    }
}
