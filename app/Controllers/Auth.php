<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Login - Milky Dessert Box'
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_active'] == 1) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($sessionData);

                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin');
                } else {
                    return redirect()->to('/');
                }
            } else {
                session()->setFlashdata('error', 'Akun Anda tidak aktif.');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Email atau password salah.');
            return redirect()->back();
        }
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Register - Milky Dessert Box'
        ];

        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'role' => 'customer'
        ];

        if ($this->userModel->insert($data)) {
            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/auth/login');
        } else {
            session()->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
