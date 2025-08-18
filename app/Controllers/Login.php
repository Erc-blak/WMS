<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            $password_verify = password_verify($password, $user['password']);

            if ($password_verify) {
                $ses_data = [
                    'user_id'    => $user['id'],
                    'username'   => $user['username'],
                    'role_id'    => $user['role_id'],
                    'isLoggedIn' => true,
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard'); // We will create this page next
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}