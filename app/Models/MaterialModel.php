<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table            = 'materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'kode_material', 
        'nama_material', 
        'warna',    // <-- Baru
        'satuan', 
        'stok', 
        'harga_beli',
        'atribut',  // <-- Baru
        'gambar'
    ];

    protected $useTimestamps = true;
}