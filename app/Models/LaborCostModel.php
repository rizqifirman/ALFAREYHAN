<?php

namespace App\Models;

use CodeIgniter\Model;

class LaborCostModel extends Model
{
    protected $table            = 'labor_costs';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields = [
        'kode_ongkos', 
        'product_id',   // Baru
        'nama_produk', 
        'detail',       // Baru (Pengganti Kategori & Ukuran)
        'biaya', 
        'gambar'
    ];
}