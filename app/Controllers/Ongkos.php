<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaborCostModel;
use App\Models\ProductModel;

class Ongkos extends BaseController
{
    // --- EXPORT EXCEL (UPDATE FITUR JSON) ---
    public function exportExcel()
    {
        // 1. Bersihkan Buffer agar file tidak rusak
        if (ob_get_level()) ob_end_clean();

        $model = new LaborCostModel();
        // Ambil semua data
        $data = $model->findAll();

        // 2. Header File Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Ongkos_Jahit_".date('Ymd_His').".xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");

        // 3. Buat Tabel HTML untuk Excel
        echo '<table border="1">';
        echo '<thead>
                <tr style="background-color:#f2f2f2;">
                    <th>Kode ID</th>
                    <th>Nama Produk</th>
                    <th>Detail / Atribut</th> <th>Biaya Jahit</th>
                </tr>
              </thead>
              <tbody>';
        
        foreach ($data as $row) {
            // A. URAIKAN JSON DETAIL MENJADI TEKS
            // Contoh JSON: {"Size":"XL", "Model":"Slim"} -> Jadi Teks: "Size: XL, Model: Slim"
            $details = json_decode($row['detail'], true);
            $detailStr = '';
            
            if ($details && is_array($details)) {
                foreach($details as $key => $val) {
                    $detailStr .= $key . ': ' . $val . ', ';
                }
                // Hapus koma terakhir
                $detailStr = rtrim($detailStr, ', ');
            } else {
                $detailStr = '-';
            }

            // B. TAMPILKAN BARIS
            echo '<tr>
                    <td>' . $row['kode_ongkos'] . '</td>
                    <td>' . $row['nama_produk'] . '</td>
                    <td>' . $detailStr . '</td>
                    <td>' . $row['biaya'] . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
        exit;
    }
  public function index()
    {
        $model = new LaborCostModel();
        $productModel = new ProductModel();
        
        $keyword = $this->request->getVar('keyword');
        $perPage = $this->request->getVar('per_page') ? $this->request->getVar('per_page') : 5;

        // LOGIKA BARU: Mengambil gambar dari tabel products menggunakan JOIN
        $builder = $model->select('labor_costs.*, products.gambar as gambar_produk, products.nama_barang')
                         ->join('products', 'products.id = labor_costs.product_id', 'left');

        if ($keyword) {
            $builder->groupStart() // Grouping agar logika OR tidak merusak filter lain
                    ->like('labor_costs.nama_produk', $keyword)
                    ->orLike('labor_costs.kode_ongkos', $keyword)
                    ->groupEnd();
        }

        $data_ongkos = $builder->paginate($perPage, 'ongkos');

        $data = [
            'title'   => 'Standar Ongkos Jahit',
            'ongkos'  => $data_ongkos,
            'products'=> $productModel->findAll(),
            'pager'   => $model->pager,
            'keyword' => $keyword,
            'perPage' => $perPage
        ];

        return view('ongkos/index', $data);
    }

    public function store()
    {
        $model = new LaborCostModel();
        $productModel = new ProductModel();

        // Ambil Nama Produk
        $prodId = $this->request->getPost('product_id');
        $produk = $productModel->find($prodId);
        $namaProduk = $produk ? $produk['nama_barang'] : 'Produk Hapus';

        // Proses Atribut ke JSON
        $attrKeys = $this->request->getPost('attr_key');
        $attrVals = $this->request->getPost('attr_value');
        $detailArray = [];
        if ($attrKeys) {
            foreach ($attrKeys as $index => $key) {
                if (!empty($key) && !empty($attrVals[$index])) {
                    $detailArray[$key] = $attrVals[$index];
                }
            }
        }
        $jsonDetail = json_encode($detailArray);

        // TIDAK ADA UPLOAD GAMBAR LAGI DISINI

        $model->save([
            'kode_ongkos' => 'O' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT),
            'product_id'  => $prodId,
            'nama_produk' => $namaProduk,
            'detail'      => $jsonDetail,
            'biaya'       => $this->request->getPost('biaya'),
            // 'gambar' dihapus, karena ikut produk
        ]);

        return redirect()->to('/ongkos')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update()
    {
        $model = new LaborCostModel();
        $productModel = new ProductModel();
        $id = $this->request->getPost('id');
        
        // Update Nama Produk
        $prodId = $this->request->getPost('product_id');
        $produk = $productModel->find($prodId);
        $namaProduk = $produk ? $produk['nama_barang'] : $this->request->getPost('nama_produk_lama');

        // Proses JSON
        $attrKeys = $this->request->getPost('attr_key');
        $attrVals = $this->request->getPost('attr_value');
        $detailArray = [];
        if ($attrKeys) {
            foreach ($attrKeys as $index => $key) {
                if (!empty($key) && !empty($attrVals[$index])) {
                    $detailArray[$key] = $attrVals[$index];
                }
            }
        }
        $jsonDetail = json_encode($detailArray);

        // TIDAK ADA UPDATE GAMBAR DISINI

        $model->update($id, [
            'product_id'  => $prodId,
            'nama_produk' => $namaProduk,
            'detail'      => $jsonDetail,
            'biaya'       => $this->request->getPost('biaya'),
        ]);

        return redirect()->to('/ongkos')->with('success', 'Data diperbarui!');
    }
    // --- FITUR PRINT HALAMAN KHUSUS (PASTI BERHASIL) ---
    public function print()
    {
        $model = new LaborCostModel();
        
        // Ambil data (Bisa dimodifikasi jika ingin ikut filter search, tapi ini ambil semua dulu biar aman)
        // Kita gunakan logika JOIN yang sama agar gambar & nama produk muncul
        $builder = $model->select('labor_costs.*, products.gambar as gambar_produk, products.nama_barang')
                         ->join('products', 'products.id = labor_costs.product_id', 'left')
                         ->orderBy('labor_costs.id', 'DESC');
                         
        $data = [
            'title'  => 'Cetak Ongkos Jahit',
            'ongkos' => $builder->findAll()
        ];

        return view('ongkos/print', $data);
    }
}