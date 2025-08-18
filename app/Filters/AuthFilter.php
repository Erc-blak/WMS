<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Check user role against allowed roles
        if ($arguments && count($arguments) > 0) {
            $user_role_id = session()->get('role_id');
            if (! in_array($user_role_id, $arguments)) {
                // Deny access if user's role is not in the allowed roles
                return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}