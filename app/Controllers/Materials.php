<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;

class Materials extends BaseController
{
    // 1. TAMPILKAN DATA
    public function index()
    {
        $model = new MaterialModel();
        
        $keyword = $this->request->getVar('keyword');
        $perPage = $this->request->getVar('per_page') ? $this->request->getVar('per_page') : 5;

        if ($keyword) {
            $data_material = $model->like('nama_material', $keyword)
                                   ->orLike('kode_material', $keyword)
                                   ->orLike('jenis', $keyword)
                                   ->paginate($perPage, 'materials');
        } else {
            $data_material = $model->paginate($perPage, 'materials');
        }

        $data = [
            'title'     => 'Data Material',
            'materials' => $data_material,
            'pager'     => $model->pager,
            'keyword'   => $keyword,
            'perPage'   => $perPage
        ];

        return view('materials/index', $data);
    }

    // 2. SIMPAN DATA BARU
    public function store()
    {
        $model = new MaterialModel();

        // Handle Gambar
        $fileGambar = $this->request->getFile('foto');
        $namaGambar = 'default.png';
        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads', $namaGambar);
        }

        // Handle Atribut JSON
        $attrNames = $this->request->getPost('attr_name');
        $attrValues = $this->request->getPost('attr_value');
        $atributJson = null;

        if ($attrNames && $attrValues) {
            $atributArray = [];
            for ($i = 0; $i < count($attrNames); $i++) {
                if (!empty($attrNames[$i]) && !empty($attrValues[$i])) {
                    $atributArray[] = [
                        'name' => $attrNames[$i],
                        'value' => $attrValues[$i]
                    ];
                }
            }
            $atributJson = json_encode($atributArray);
        }

        // --- PERBAIKAN: Masukkan harga_beli ke sini ---
        $model->save([
            'kode_material' => 'M-' . time(),
            'nama_material' => $this->request->getPost('nama_material'),
            'warna'         => $this->request->getPost('warna'),
            'satuan'        => $this->request->getPost('satuan'),
            'stok'          => $this->request->getPost('stok'),
            'harga_beli'    => $this->request->getPost('harga_beli'), // <--- SUDAH DITAMBAHKAN
            'atribut'       => $atributJson,
            'gambar'        => $namaGambar,
        ]);

        return redirect()->to('/materials')->with('success', 'Material berhasil ditambahkan!');
    }

    // 3. UPDATE DATA
    public function update()
    {
        $model = new MaterialModel();
        $id = $this->request->getPost('id');
        $dataLama = $model->find($id);

        if (!$dataLama) {
            return redirect()->to('/materials')->with('error', 'Data tidak ditemukan');
        }

        // Handle Gambar
        $fileGambar = $this->request->getFile('foto');
        $namaGambar = $dataLama['gambar'];

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            if ($dataLama['gambar'] != 'default.png' && file_exists('uploads/' . $dataLama['gambar'])) {
                unlink('uploads/' . $dataLama['gambar']);
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads', $namaGambar);
        }

        // Handle Atribut JSON
        $attrNames = $this->request->getPost('attr_name');
        $attrValues = $this->request->getPost('attr_value');
        $atributJson = null;

        if ($attrNames && $attrValues) {
            $atributArray = [];
            for ($i = 0; $i < count($attrNames); $i++) {
                if (!empty($attrNames[$i]) && !empty($attrValues[$i])) {
                    $atributArray[] = ['name' => $attrNames[$i], 'value' => $attrValues[$i]];
                }
            }
            $atributJson = json_encode($atributArray);
        }

        // --- PERBAIKAN: Masukkan harga_beli ke sini juga ---
        $model->update($id, [
            'nama_material' => $this->request->getPost('nama_material'),
            'warna'         => $this->request->getPost('warna'),
            'satuan'        => $this->request->getPost('satuan'),
            'stok'          => $this->request->getPost('stok'),
            'harga_beli'    => $this->request->getPost('harga_beli'), // <--- SUDAH DITAMBAHKAN
            'atribut'       => $atributJson,
            'gambar'        => $namaGambar,
        ]);

        return redirect()->to('/materials')->with('success', 'Material diperbarui!');
    }

    // 4. HAPUS DATA
    public function delete($id)
    {
        $model = new MaterialModel();
        $data = $model->find($id);
        
        if ($data) {
            if ($data['gambar'] != 'default.png' && file_exists('uploads/' . $data['gambar'])) {
                unlink('uploads/' . $data['gambar']);
            }
            $model->delete($id);
            return redirect()->to('/materials')->with('success', 'Material dihapus!');
        }
        return redirect()->to('/materials');
    }

    // --- 5. EXPORT EXCEL (PERBAIKAN BUFFER) ---
    public function exportExcel()
    {
        // Bersihkan output buffer agar file tidak corrupt
        if (ob_get_level()) ob_end_clean();

        $model = new MaterialModel();
        $materials = $model->findAll();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Material_".date('Ymd_His').".xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");

        // Tabel HTML Sederhana
        echo '<table border="1">';
        echo '<thead>
                <tr style="background-color:#f2f2f2;">
                    <th>Kode</th>
                    <th>Nama Material</th>
                    <th>Warna</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Atribut Tambahan</th>
                </tr>
              </thead>
              <tbody>';
        
        foreach ($materials as $m) {
            // Rapikan Atribut
            $attrText = '-';
            if ($m['atribut']) {
                $attrs = json_decode($m['atribut'], true);
                $temp = [];
                if (is_array($attrs)) {
                    foreach ($attrs as $a) {
                        $temp[] = ($a['name'] ?? '') . ': ' . ($a['value'] ?? '');
                    }
                    $attrText = implode(', ', $temp);
                }
            }

            echo '<tr>';
            echo '<td>' . $m['kode_material'] . '</td>';
            echo '<td>' . $m['nama_material'] . '</td>';
            echo '<td>' . $m['warna'] . '</td>';
            echo '<td>' . $m['satuan'] . '</td>';
            echo '<td>' . str_replace('.', ',', $m['stok']) . '</td>'; // Format angka indo
            echo '<td>' . $m['harga_beli'] . '</td>';
            echo '<td>' . $attrText . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        exit;
    }

    // --- 6. EXPORT CSV (PERBAIKAN BUFFER) ---
    public function exportCsv()
    {
        // Bersihkan output buffer agar file tidak corrupt
        if (ob_get_level()) ob_end_clean();

        $model = new MaterialModel();
        $materials = $model->findAll();

        $filename = 'Data_Material_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $file = fopen('php://output', 'w');
        
        // Header Kolom
        fputcsv($file, ['Kode', 'Nama Material', 'Warna', 'Satuan', 'Stok', 'Harga Beli', 'Atribut']);
        
        foreach ($materials as $m) {
            // Rapikan Atribut
            $attrText = '-';
            if ($m['atribut']) {
                $attrs = json_decode($m['atribut'], true);
                $temp = [];
                if (is_array($attrs)) {
                    foreach ($attrs as $a) {
                        $temp[] = ($a['name'] ?? '') . ': ' . ($a['value'] ?? '');
                    }
                    $attrText = implode(' | ', $temp); // Pakai pemisah | biar aman di CSV
                }
            }

            fputcsv($file, [
                $m['kode_material'], 
                $m['nama_material'], 
                $m['warna'], 
                $m['satuan'], 
                $m['stok'], 
                $m['harga_beli'],
                $attrText
            ]);
        }
        
        fclose($file);
        exit;
    }
   // --- 7. IMPORT CSV (VERSI FINAL - ANTI ERROR) ---
   // --- IMPORT CSV (VERSI PAKSA TITIK KOMA & PEMBERSIH KUTIP) ---
    public function importCsv()
    {
        $file = $this->request->getFile('file_csv');

        if ($file && $file->isValid() && $file->getExtension() == 'csv') {
            
            $model = new MaterialModel();
            $filePath = $file->getTempName();

            // 1. BACA BARIS PERTAMA UNTUK CEK PEMISAH
            $handle = fopen($filePath, 'r');
            $header = fgets($handle);
            fclose($handle);

            // Paksa cek: Mana yang lebih banyak? Titik Koma atau Koma?
            // Biasanya Excel Indonesia pakai Titik Koma (;)
            $semicolonCount = substr_count($header, ';');
            $commaCount     = substr_count($header, ',');

            $delimiter = ($semicolonCount > $commaCount) ? ';' : ',';

            // 2. PROSES DATA
            $handle = fopen($filePath, 'r');
            
            // Lewati Header
            fgetcsv($handle, 0, $delimiter); 

            $countUpdate = 0;
            $countInsert = 0;

            while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                
                // FIX: Jika data terbaca cuma 1 kolom padahal isinya panjang, 
                // berarti delimiter salah atau terbungkus kutip. Kita pecah manual.
                if (count($row) == 1 && strpos($row[0], $delimiter) !== false) {
                    $row = explode($delimiter, $row[0]);
                }

                // Validasi jumlah kolom (minimal ada Kode dan Nama)
                if (count($row) < 2) continue;

                // BERSIHKAN TANDA KUTIP (") YANG MENGGANGGU
                // Excel sering menambah kutip di awal/akhir string
                $row = array_map(function($value) {
                    return trim(str_replace('"', '', $value));
                }, $row);

                // Mapping Data
                // [0]Kode, [1]Nama, [2]Warna, [3]Satuan, [4]Stok, [5]Harga
                $kode   = $row[0];
                $nama   = $row[1] ?? 'Material Baru';
                $warna  = $row[2] ?? '-';
                $satuan = $row[3] ?? 'Pcs';
                $stok   = $row[4] ?? 0;
                $harga  = $row[5] ?? 0;

                // Skip jika kode kosong
                if (empty($kode)) continue;

                // Bersihkan Angka (Stok & Harga)
                // Hapus Rp, Titik Ribuan, ubah Koma desimal jadi Titik
                $stok  = str_replace(',', '.', $stok); // Misal 1,5 meter jadi 1.5
                $harga = preg_replace('/[^0-9]/', '', $harga); // Ambil angkanya saja

                // Cek Database
                $cekData = $model->where('kode_material', $kode)->first();

                $dataSimpan = [
                    'nama_material' => $nama,
                    'warna'         => $warna,
                    'satuan'        => $satuan,
                    'stok'          => $stok,
                    'harga_beli'    => $harga,
                ];

                if ($cekData) {
                    $model->update($cekData['id'], $dataSimpan);
                    $countUpdate++;
                } else {
                    $dataSimpan['kode_material'] = $kode;
                    $dataSimpan['gambar'] = 'default.png';
                    $model->save($dataSimpan);
                    $countInsert++;
                }
            }
            
            fclose($handle);
            return redirect()->to('/materials')->with('success', "Import Berhasil! Delimiter: ($delimiter). Update: $countUpdate, Baru: $countInsert.");
        }

        return redirect()->to('/materials')->with('error', 'Gagal upload file.');
    }
}