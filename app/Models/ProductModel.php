<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // UPDATE BAGIAN INI: Tambahkan jenis, target, size, kain, gambar
    protected $allowedFields    = [
        'kode_barang', 
        'nama_barang', 
        'warna',
        'jenis',        // <-- Baru
        'target',       // <-- Baru
        'size',         // <-- Baru
        'kain',         // <-- Baru
        'stok', 
        'gambar'        // <-- Baru
    ];

    protected $useTimestamps = true;
}