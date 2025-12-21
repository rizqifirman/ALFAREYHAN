<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $data = [
            [
                'username'     => 'owner',
                'password'     => '123456', // Password mentah, nanti di-hash otomatis oleh Model
                'nama_lengkap' => 'Bapak Owner',
                'role'         => 'owner',
            ],
            [
                'username'     => 'produksi',
                'password'     => '123456',
                'nama_lengkap' => 'Staff Produksi',
                'role'         => 'produksi',
            ],
            [
                'username'     => 'kasir',
                'password'     => '123456',
                'nama_lengkap' => 'Mba Kasir',
                'role'         => 'kasir',
            ],
            [
                'username'     => 'accounting',
                'password'     => '123456',
                'nama_lengkap' => 'Staff Akunting',
                'role'         => 'accounting',
            ],
        ];

        // Insert Batch tidak memicu 'beforeInsert' callback di CI4 lama, 
        // jadi kita looping insert() biasa agar password ter-hash aman.
        foreach ($data as $user) {
            $userModel->insert($user);
        }
    }
}