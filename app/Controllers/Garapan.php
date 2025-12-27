<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GarapanModel;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\WorkerModel;
use App\Models\LaborCostModel;

class Garapan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $garapanModel = new GarapanModel();
        
        // 1. Ambil Data Header
        $aktif = $garapanModel->getLengkap('Aktif');
        $riwayat = $garapanModel->getLengkap('Riwayat');

        // 2. FUNGSI LAMPIRKAN DETAIL (Kunci agar detail muncul)
        $attachDetail = function(&$arrayData) {
            foreach($arrayData as &$row) {
                // Detail Material
                $row['detail_materials'] = $this->db->table('garapan_materials')
                    ->select('materials.nama_material, garapan_materials.qty, materials.satuan, materials.warna')
                    ->join('materials', 'materials.id = garapan_materials.material_id')
                    ->where('garapan_id', $row['id'])
                    ->get()->getResultArray();
                
                // Detail Target (PENTING: select product_id untuk retur)
                $row['detail_products'] = $this->db->table('garapan_products')
                    ->select('products.nama_barang, products.size, products.kode_barang, garapan_products.qty_target, garapan_products.qty_hasil, garapan_products.qty_retur, garapan_products.product_id, garapan_products.ongkos_satuan') 
                    ->join('products', 'products.id = garapan_products.product_id')
                    ->where('garapan_id', $row['id'])
                    ->get()->getResultArray();
            }
        };

        // Pasang detail ke KEDUA array (Aktif & Riwayat)
        $attachDetail($aktif);
        $attachDetail($riwayat);

        $data = [
            'title'           => 'Manajemen Garapan',
            'garapan_aktif'   => $aktif,
            'garapan_riwayat' => $riwayat,
            'materials'       => (new MaterialModel())->findAll(),
            'products'        => (new ProductModel())->findAll(),
            'workers'         => (new WorkerModel())->where('status', 'Aktif')->findAll(),
        ];

        return view('garapan/index', $data);
    }

    // --- SIMPAN SPK ---
    public function store()
    {
        $garapanModel = new GarapanModel();
        
        // Ambil Input
        $noFaktur = $this->request->getPost('no_faktur');
        $workerId = $this->request->getPost('worker_id');
        $tglSpk   = $this->request->getPost('tanggal_spk');
        
        $matIds = $this->request->getPost('material_id'); 
        $matQtys = $this->request->getPost('material_qty'); 
        $prodIds = $this->request->getPost('product_id'); 
        $prodQtys = $this->request->getPost('product_qty'); 

        if(!$workerId || empty($prodIds)) {
            return redirect()->back()->with('error', 'Data Penjahit atau Target tidak boleh kosong!');
        }

        $this->db->transStart(); // Mulai Transaksi Aman

        // 1. Simpan Header
        $garapanId = $garapanModel->insert([
            'no_faktur' => $noFaktur,
            'worker_id' => $workerId,
            'tanggal_spk' => $tglSpk,
            'status' => 'Proses',
            'total_biaya' => 0
        ]);

        // 2. Simpan Material & Kurangi Stok
        if($matIds) {
            foreach($matIds as $i => $mId) {
                if(!empty($mId) && $matQtys[$i] > 0) {
                    $this->db->table('garapan_materials')->insert([
                        'garapan_id' => $garapanId, 'material_id' => $mId, 'qty' => $matQtys[$i]
                    ]);
                    $this->db->query("UPDATE materials SET stok = stok - ? WHERE id = ?", [$matQtys[$i], $mId]);
                }
            }
        }

        // 3. Simpan Target
        $totalOngkos = 0;
        if($prodIds) {
            foreach($prodIds as $j => $pId) {
                if(!empty($pId) && $prodQtys[$j] > 0) {
                    $cekOngkos = $this->db->table('labor_costs')->where('product_id', $pId)->get()->getRowArray();
                    $biayaSatuan = $cekOngkos ? $cekOngkos['biaya'] : 0;
                    
                    $this->db->table('garapan_products')->insert([
                        'garapan_id' => $garapanId, 'product_id' => $pId, 'qty_target' => $prodQtys[$j], 'ongkos_satuan' => $biayaSatuan
                    ]);
                    $totalOngkos += ($biayaSatuan * $prodQtys[$j]);
                }
            }
        }
        $garapanModel->update($garapanId, ['total_biaya' => $totalOngkos]);

        $this->db->transComplete(); // Selesai Transaksi

        if ($this->db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal menyimpan garapan.');
        }

        return redirect()->to('/garapan')->with('success_print', $garapanId); 
    }

    // --- TERIMA GARAPAN (LOGIC UPDATE RIWAYAT) ---
    public function terima($id)
    {
$garapanModel = new GarapanModel();
        
        $aksi = $this->request->getPost('aksi');
        $qtyReturInput = $this->request->getPost('qty_retur');
        
        // --- [PENTING] AMBIL INPUT BONUS & BERSIHKAN TITIK (.) ---
        $rawBonus = $this->request->getPost('bonus');
        $rawPotongan = $this->request->getPost('potongan');
        
        // Ubah "10.000" jadi "10000" (Angka Murni)
        $bonus = $rawBonus ? str_replace('.', '', $rawBonus) : 0;
        $potongan = $rawPotongan ? str_replace('.', '', $rawPotongan) : 0;
        // ---------------------------------------------------------

    $bonus = $rawBonus ? str_replace('.', '', $rawBonus) : 0;
    $potongan = $rawPotongan ? str_replace('.', '', $rawPotongan) : 0;
    
    // ... lanjut ke kode if($aksi == 'Batal') ...

        // Skenario Batal
        if($aksi == 'Batal') {
            $garapanModel->update($id, ['status' => 'Batal', 'tanggal_selesai' => date('Y-m-d H:i:s')]);
            return redirect()->to('/garapan')->with('error', 'Garapan Dibatalkan.');
        }

        $this->db->transStart(); // Mulai Transaksi

        $targets = $this->db->table('garapan_products')->where('garapan_id', $id)->get()->getResultArray();
        $totalUpahReal = 0;

        foreach($targets as $t) {
            $pId = $t['product_id'];
            $targetQty = $t['qty_target'];
            
            // Hitung Hasil & Retur
            if ($aksi == 'Retur') {
                $jmlRusak = isset($qtyReturInput[$pId]) ? (int)$qtyReturInput[$pId] : 0;
                $jmlTerima = $targetQty - $jmlRusak;
            } else {
                $jmlRusak = 0;
                $jmlTerima = $targetQty;
            }

            if($jmlTerima < 0) $jmlTerima = 0;

            // Update Detail (PENTING: ini yang menyimpan data ke riwayat)
            $this->db->table('garapan_products')->where('id', $t['id'])->update([
                'qty_hasil' => $jmlTerima,
                'qty_retur' => $jmlRusak
            ]);

            // Update Stok Gudang (Hanya yang bagus)
            if($jmlTerima > 0) {
                $this->db->query("UPDATE products SET stok = stok + ? WHERE id = ?", [$jmlTerima, $pId]);
            }

            // Hitung Upah Real (Hanya yang bagus dibayar)
            $totalUpahReal += ($jmlTerima * $t['ongkos_satuan']);
        }

        // Update Header Status Menjadi Selesai/Revisi (Agar pindah ke Tab Riwayat)
        $statusAkhir = ($aksi == 'Retur') ? 'Revisi' : 'Selesai';
$garapanModel->update($id, [
            'status' => ($aksi == 'Retur') ? 'Revisi' : 'Selesai',
            'total_biaya' => $totalUpahReal, // Ini total murni jahit
            'bonus' => $bonus,                 // <--- PASTIKAN INI TERTULIS
            'potongan' => $potongan,           // <--- PASTIKAN INI TERTULIS
            'tanggal_selesai' => date('Y-m-d H:i:s')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            // Jika masuk sini, berarti database error (kemungkinan kolom qty_retur hilang)
            return redirect()->to('/garapan')->with('error', 'Gagal update! Cek Database (Kolom qty_retur).');
        }

        return redirect()->to('/garapan')->with('success_print_gaji', $id);
    }

    // --- CETAK SPK ---
    public function printSpk($id)
    {
        // Query Manual agar ID pasti ketemu
        $garapan = $this->db->table('garapans')
            ->select('garapans.*, workers.nama_tukang, workers.telepon, workers.alamat')
            ->join('workers', 'workers.id = garapans.worker_id')
            ->where('garapans.id', $id)
            ->get()->getRowArray();

        if(!$garapan) return "Data tidak ditemukan!";

        $materials = $this->db->table('garapan_materials')
            ->select('garapan_materials.*, materials.nama_material, materials.satuan, materials.warna')
            ->join('materials', 'materials.id = garapan_materials.material_id')
            ->where('garapan_id', $id)->get()->getResultArray();
            
        $products = $this->db->table('garapan_products')
            ->select('garapan_products.*, products.nama_barang, products.kode_barang')
            ->join('products', 'products.id = garapan_products.product_id')
            ->where('garapan_id', $id)->get()->getResultArray();

        return view('garapan/print_spk', ['garapan' => $garapan, 'materials' => $materials, 'products' => $products]);
    }
    
    // --- CETAK GAJI (FIX BLANK PAGE) ---
    // --- CETAK GAJI (UPDATE: AMBIL ALAMAT & TELP) ---
    public function printGaji($id)
    {
        // Query Manual agar ID pasti ketemu
        $garapan = $this->db->table('garapans')
            // PERUBAHAN DISINI: Tambahkan workers.telepon dan workers.alamat
            ->select('garapans.*, workers.nama_tukang, workers.telepon, workers.alamat') 
            ->join('workers', 'workers.id = garapans.worker_id')
            ->where('garapans.id', $id)
            ->get()->getRowArray();

        if(!$garapan) return "Data Upah tidak ditemukan!";

        $products = $this->db->table('garapan_products')
            ->select('garapan_products.*, products.nama_barang')
            ->join('products', 'products.id = garapan_products.product_id')
            ->where('garapan_id', $id)->get()->getResultArray();

        return view('garapan/print_gaji', ['garapan' => $garapan, 'products' => $products]);
 
    }
    // --- HAPUS GARAPAN (KHUSUS OWNER) ---
    public function delete($id)
    {
        // 1. CEK KEAMANAN: Hanya Owner yang boleh
        // Pastikan saat login session role diset sebagai 'Owner'
        if(session()->get('role') != 'owner') {
            return redirect()->to('/garapan')->with('error', 'Akses Ditolak! Hanya Owner yang bisa menghapus riwayat.');
        }

        $garapanModel = new GarapanModel();
        
        // 2. HAPUS DATA (Termasuk detailnya)
        // Kita gunakan Transaction agar aman
        $this->db->transStart();
        
        // Hapus Detail Material & Produk dulu (Manual delete agar bersih)
        $this->db->table('garapan_materials')->where('garapan_id', $id)->delete();
        $this->db->table('garapan_products')->where('garapan_id', $id)->delete();
        
        // Hapus Header Garapan
        $garapanModel->delete($id);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return redirect()->to('/garapan')->with('error', 'Gagal menghapus data.');
        }

        return redirect()->to('/garapan')->with('success', 'Data Riwayat berhasil dihapus permanen.');
    }
}