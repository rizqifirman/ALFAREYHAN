<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        // 1. CEK KEAMANAN: Cuma Owner yang boleh masuk sini
        // Gunakan strcasecmp agar 'owner' == 'Owner'
        if (strcasecmp(session()->get('role'), 'owner') != 0) {
            return redirect()->to('/dashboard')->with('error', 'Akses Ditolak! Menu ini khusus Owner.');
        }

        $userModel = new UserModel();
        $data = [
            'title' => 'Manajemen Akun',
            'users' => $userModel->orderBy('role', 'ASC')->findAll()
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        // Cek Owner
        if (strcasecmp(session()->get('role'), 'owner') != 0) return redirect()->back();

        $userModel = new UserModel();

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
            // Password WAJIB di-hash (enkripsi)
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status'       => 'Aktif'
        ];

        $userModel->insert($data);
        return redirect()->to('/users')->with('success', 'Akun baru berhasil dibuat.');
    }

    public function update($id)
    {
        // Cek Owner
        if (strcasecmp(session()->get('role'), 'owner') != 0) return redirect()->back();

        $userModel = new UserModel();
        
        $passwordBaru = $this->request->getPost('password');

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
            'status'       => $this->request->getPost('status')
        ];

        // LOGIKA GANTI PASSWORD:
        // Jika kolom password diisi, update passwordnya.
        // Jika kosong, biarkan password lama.
        if (!empty($passwordBaru)) {
            $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);
        return redirect()->to('/users')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Cek Owner
        if (strcasecmp(session()->get('role'), 'owner') != 0) return redirect()->back();

        $userModel = new UserModel();
        $userModel->delete($id);
        
        return redirect()->to('/users')->with('success', 'Akun berhasil dihapus.');
    }
}