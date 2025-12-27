<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // BAGIAN PENTING:
    // Kita tambahkan 'nama_lengkap' dan 'status' agar bisa diedit oleh Owner
    protected $allowedFields    = ['username', 'password', 'nama_lengkap', 'role', 'status'];

    // Aktifkan ini agar tahu kapan akun dibuat/diedit (Opsional, tapi bagus)
    protected $useTimestamps = false;
    // Ubah ke 'true' jika tabel database Anda punya kolom 'created_at' & 'updated_at'
}