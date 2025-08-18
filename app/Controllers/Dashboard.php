<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $data['username'] = $session->get('username');
        $data['role_id'] = $session->get('role_id');

        return view('dashboard', $data);
    }
}