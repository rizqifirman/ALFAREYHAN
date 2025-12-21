<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        // Jika user sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model   = new UserModel();
        
        // Ambil input dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Cari data user di database
        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            // Cek Password (Hash Verification)
            if (password_verify($password, $pass)) {
                $ses_data = [
                    'id'       => $data['id'],
                    'username' => $data['username'],
                    'nama'     => $data['nama_lengkap'],
                    'role'     => $data['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                
                // Sukses: Ke Dashboard
                return redirect()->to('/');
            } else {
                // Gagal: Password Salah
                $session->setFlashdata('error', 'Password Salah');
                return redirect()->to('/login');
            }
        } else {
            // Gagal: Username Tidak Ditemukan
            $session->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}