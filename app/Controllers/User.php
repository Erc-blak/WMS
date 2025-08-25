<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class User extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->select('users.*, roles.name as role_name')
                                ->join('roles', 'roles.id = users.role_id')
                                ->findAll();

        return view('user/list', $data);
    }
    
    public function create()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();

        return view('user/add', $data);
    }

    public function save()
    {
        $userModel = new UserModel();

        $rules = [
            'username' => 'required|is_unique[users.username]|min_length[3]|max_length[100]',
            'password' => 'required|min_length[8]',
            'role_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role_id' => $this->request->getPost('role_id'),
        ];
        
        if ($userModel->insert($data)) {
            return redirect()->to('/users')->with('success', 'User created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create user. Please try again.');
        }
    }

    public function edit($id = null)
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        
        $data['user'] = $userModel->find($id);
        $data['roles'] = $roleModel->findAll();

        if ($data['user'] === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('user/edit', $data);
    }

    public function update($id = null)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[100]',
            'role_id' => 'required|integer',
        ];

        if ($this->request->getPost('username') !== $user['username']) {
            $rules['username'] .= '|is_unique[users.username]';
        }
        
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role_id' => $this->request->getPost('role_id'),
        ];
        
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to('/users')->with('success', 'User updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function delete($id = null)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        
        if ($user === null) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        if ($userModel->delete($id)) {
            return redirect()->to('/users')->with('success', 'User deleted successfully!');
        } else {
            return redirect()->to('/users')->with('error', 'Failed to delete user.');
        }
    }
}