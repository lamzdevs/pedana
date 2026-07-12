<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login');
    }

    public function process_login()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if ($user['status'] === 'Pending') {
                session()->setFlashdata('alert_error', 'Akses Ditolak! Akun Anda sedang menunggu persetujuan Administrator.');
                return redirect()->to(base_url('/'));
            }

            if ($user['status'] !== 'Aktif') {
                session()->setFlashdata('alert_error', 'Akses Ditolak! Akun Anda telah dinonaktifkan oleh Administrator. Silakan hubungi pengelola sistem.');
                return redirect()->to(base_url('/'));
            }

            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                    'email'    => $user['email'],
                    'role'     => $user['role'],
                    'profile_pic' => $user['profile_pic'] ?? 'profil.png',
                    'isLoggedIn' => true
                ]);
                return redirect()->to(base_url('dashboard'));
            } else {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('/'));
            }
        } else {
            session()->setFlashdata('error', 'Username tidak ditemukan!');
            return redirect()->to(base_url('/'));
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function process_register()
    {
        $model = new UserModel();

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'guest',
            'status'   => 'Pending',
        ];

        $model->insert($data);
        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to(base_url('/'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
