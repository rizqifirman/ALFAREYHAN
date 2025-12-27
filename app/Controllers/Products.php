<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Products extends BaseController
{
    
// --- FUNGSI EXPORT EXCEL (Simpel HTML Table) ---
    public function exportExcel()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll(); // Ambil SEMUA data tanpa pagination

        // Set Header agar browser membacanya sebagai file Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Produk_".date('Ymd').".xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");

        // Tampilkan Tabel HTML Sederhana (Excel bisa membaca ini)
        echo '<table border="1">';
        echo '<tr>
                <th>Kode Barang</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Target</th>
                <th>Size</th>
                <th>Kain</th>
                <th>Stok</th>
              </tr>';
        
        foreach ($data['products'] as $p) {
            echo '<tr>';
            echo '<td>' . $p['kode_barang'] . '</td>';
            echo '<td>' . $p['nama_barang'] . '</td>';
            echo '<td>' . $p['jenis'] . '</td>';
            echo '<td>' . $p['target'] . '</td>';
            echo '<td>' . $p['size'] . '</td>';
            echo '<td>' . $p['kain'] . '</td>';
            echo '<td>' . $p['stok'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    // --- FUNGSI EXPORT CSV ---
    public function exportCsv()
    {
        $model = new ProductModel();
        $products = $model->findAll(); // Ambil SEMUA data

        $filename = 'Data_Produk_' . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; "); 
        
        // Buat file CSV di memory
        $file = fopen('php://output', 'w');
        
        // Tulis Header Kolom
        $header = ['Kode Barang', 'Nama Produk', 'Jenis', 'Target', 'Size', 'Kain', 'Stok'];
        fputcsv($file, $header);
        
        // Tulis Data Baris per Baris
        foreach ($products as $p) {
            fputcsv($file, [
                $p['kode_barang'],
                $p['nama_barang'],
                $p['jenis'],
                $p['target'],
                $p['size'],
                $p['kain'],
                $p['stok']
            ]);
        }
        
        fclose($file);
        exit;
    }

    public function store()
    {
        $model = new ProductModel();

        // 1. Handle Upload Gambar
        $fileGambar = $this->request->getFile('foto');
        $namaGambar = 'default.png'; // Default jika tidak ada gambar

        if ($fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName(); // Generate nama acak
            $fileGambar->move('uploads', $namaGambar); // Pindah ke folder public/uploads
        }

        // 2. Generate Kode Barang Otomatis (Karena tidak ada di form input)
        // Contoh format: P-170923 (P + Timestamp acak)
        $kodeBarang = 'P-' . time(); 

        // 3. Simpan ke Database
        $model->save([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $this->request->getPost('nama_barang'),
            'warna'       => $this->request->getPost('warna'),
            'jenis'       => $this->request->getPost('jenis'),
            'target'      => $this->request->getPost('target'),
            'size'        => $this->request->getPost('size'),
            'kain'        => $this->request->getPost('kain'),
            'stok'        => $this->request->getPost('stok'),
            'gambar'      => $namaGambar,
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

// Fungsi Update Data
    public function update()
    {
        $model = new ProductModel();
        $id = $this->request->getPost('id'); // Ambil ID hidden dari form

        // Ambil data lama untuk cek gambar
        $produkLama = $model->find($id);

        // 1. Handle Gambar (Jika user ganti foto)
        $fileGambar = $this->request->getFile('foto');
        if ($fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            // Hapus gambar lama (jika bukan default)
            if ($produkLama['gambar'] != 'default.png' && file_exists('uploads/' . $produkLama['gambar'])) {
                unlink('uploads/' . $produkLama['gambar']);
            }
            // Upload gambar baru
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads', $namaGambar);
        } else {
            // Jika tidak ganti foto, pakai nama foto lama
            $namaGambar = $produkLama['gambar'];
        }

        // 2. Simpan Perubahan
        $model->update($id, [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jenis'       => $this->request->getPost('jenis'),
            'target'      => $this->request->getPost('target'),
            'size'        => $this->request->getPost('size'),
            'kain'        => $this->request->getPost('kain'),
            'stok'        => $this->request->getPost('stok'),
            'gambar'      => $namaGambar,
        ]);

        return redirect()->to('/products')->with('success', 'Data berhasil diperbarui!');
    }

    // Fungsi Menghapus Data
    public function delete($id)
    {
        $model = new ProductModel();
        
        // Cek dulu datanya ada atau tidak
        $produk = $model->find($id);
        
        if ($produk) {
            // Hapus gambar lama jika bukan default
            if ($produk['gambar'] != 'default.png' && file_exists('uploads/' . $produk['gambar'])) {
                unlink('uploads/' . $produk['gambar']);
            }

            // Hapus dari database
            $model->delete($id);
            return redirect()->to('/products')->with('success', 'Data berhasil dihapus');
        }
    }

    public function index()
    {
        $model = new ProductModel();
        
        // 1. Ambil keyword pencarian (jika ada)
        $keyword = $this->request->getVar('keyword');

        // 2. Ambil pilihan "per_page" dari dropdown (Default: 5 jika tidak dipilih)
        $perPage = $this->request->getVar('per_page') ? $this->request->getVar('per_page') : 5;

        // Logika Pencarian & Pagination
        if ($keyword) {
            $data_produk = $model->like('nama_barang', $keyword)
                                 ->orLike('kode_barang', $keyword)
                                 ->paginate($perPage, 'products'); // Gunakan variabel $perPage
        } else {
            $data_produk = $model->paginate($perPage, 'products'); // Gunakan variabel $perPage
        }

        $data = [
            'title' => 'Data Produk & Stok',
            'products' => $data_produk,
            'pager' => $model->pager,
            'keyword' => $keyword,
            'perPage' => $perPage // <-- PENTING: Kirim data ini ke View agar dropdown ingat pilihannya
        ];

        return view('products/index', $data);
    }
// --- IMPORT CSV PRODUK (MASS EDIT & INSERT) ---
    public function importCsv()
    {
        $file = $this->request->getFile('file_csv');

        if ($file && $file->isValid() && $file->getExtension() == 'csv') {
            
            $model = new ProductModel();
            $filePath = $file->getTempName();

            // 1. CEK FORMAT (KOMA vs TITIK KOMA)
            $handle = fopen($filePath, 'r');
            $header = fgets($handle);
            fclose($handle);

            // Cek mana yang lebih banyak
            $semicolon = substr_count($header, ';');
            $comma     = substr_count($header, ',');
            $delimiter = ($semicolon > $comma) ? ';' : ',';

            // 2. PROSES DATA
            $handle = fopen($filePath, 'r');
            fgetcsv($handle, 0, $delimiter); // Lewati Header

            $countUpdate = 0;
            $countInsert = 0;

            while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                
                // Fix jika terbaca 1 kolom panjang
                if (count($row) == 1 && strpos($row[0], $delimiter) !== false) {
                    $row = explode($delimiter, $row[0]);
                }

                if (count($row) < 2) continue;

                // Bersihkan Tanda Kutip
                $row = array_map(function($val) {
                    return trim(str_replace('"', '', $val));
                }, $row);

                // Mapping Kolom (Sesuaikan dengan urutan Export CSV Produk)
                // [0]Kode, [1]Nama, [2]Jenis, [3]Target, [4]Size, [5]Kain, [6]Stok
                $kode   = $row[0];
                $nama   = $row[1] ?? 'Produk Baru';
                $warna  = $row[2] ?? '-';
                $jenis  = $row[2] ?? '-';
                $target = $row[3] ?? '-';
                $size   = $row[4] ?? '-';
                $kain   = $row[5] ?? '-';
                $stok   = $row[6] ?? 0;

                if (empty($kode)) continue;

                // Bersihkan Stok (Hanya Angka)
                $stok = preg_replace('/[^0-9]/', '', $stok);

                // Cek Database
                $cekData = $model->where('kode_barang', $kode)->first();

                $dataSimpan = [
                    'nama_barang' => $nama,
                    'jenis'       => $jenis,
                    'target'      => $target,
                    'size'        => $size,
                    'kain'        => $kain,
                    'stok'        => $stok,
                ];

                if ($cekData) {
                    // Update jika kode ada
                    $model->update($cekData['id'], $dataSimpan);
                    $countUpdate++;
                } else {
                    // Buat baru jika kode tidak ada
                    $dataSimpan['kode_barang'] = $kode;
                    $dataSimpan['gambar'] = 'default.png';
                    $model->save($dataSimpan);
                    $countInsert++;
                }
            }
            
            fclose($handle);
            return redirect()->to('/products')->with('success', "Import Produk Selesai! Update: $countUpdate, Baru: $countInsert.");
        }

        return redirect()->to('/products')->with('error', 'Gagal upload file CSV.');
    }
// --- FITUR PRINT PRODUK ---
    public function print()
    {
        $model = new ProductModel();
        $data = [
            'title'    => 'Laporan Stok Produk',
            'products' => $model->findAll()
        ];
        return view('products/print', $data);
    }
}