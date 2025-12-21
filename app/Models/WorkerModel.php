<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkerModel extends Model
{
    protected $table            = 'workers';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['kode_tukang', 'nama_tukang', 'telepon', 'alamat', 'status'];
}