<?php

namespace App\Models;

use CodeIgniter\Model;

class GarapanModel extends Model
{
    protected $table = 'garapans';
    protected $primaryKey = 'id';
   // File: app/Models/GarapanModel.php

protected $allowedFields = [
    'no_faktur', 
    'worker_id', 
    'tanggal_spk', 
    'tanggal_selesai', 
    'status', 
    'total_biaya',
    'bonus',     // <--- WAJIB DITAMBAHKAN
    'potongan'   // <--- WAJIB DITAMBAHKAN
]; protected $useTimestamps = true;

public function getLengkap($status = null)
    {
        // Select lengkap dengan worker
        $builder = $this->select('garapans.*, workers.nama_tukang, workers.telepon, workers.alamat')
                        ->join('workers', 'workers.id = garapans.worker_id');
        
        if($status == 'Aktif') {
            // Tab Aktif hanya menampilkan yang masih Proses
            $builder->where('garapans.status', 'Proses');
        } elseif ($status == 'Riwayat') {
            // PERBAIKAN DISINI: Tambahkan 'Revisi' ke dalam daftar
            $builder->whereIn('garapans.status', ['Selesai', 'Batal', 'Revisi']);
        }
        
        return $builder->orderBy('garapans.id', 'DESC')->findAll();
    }
}