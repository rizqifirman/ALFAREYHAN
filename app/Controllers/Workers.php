<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkerModel;

class Workers extends BaseController
{
    public function index()
    {
        $model = new WorkerModel();
        
        $keyword = $this->request->getVar('keyword');
        $perPage = $this->request->getVar('per_page') ? $this->request->getVar('per_page') : 5;

        if ($keyword) {
            $data_worker = $model->like('nama_tukang', $keyword)
                                 ->orLike('kode_tukang', $keyword)
                                 ->orLike('alamat', $keyword)
                                 ->paginate($perPage, 'workers');
        } else {
            $data_worker = $model->paginate($perPage, 'workers');
        }

        $data = [
            'title'   => 'Data Tukang',
            'workers' => $data_worker,
            'pager'   => $model->pager,
            'keyword' => $keyword,
            'perPage' => $perPage
        ];

        return view('workers/index', $data);
    }

    public function store()
    {
        $model = new WorkerModel();
        $model->save([
            'kode_tukang' => 'T-' . time(), // Generate ID otomatis
            'nama_tukang' => $this->request->getPost('nama_tukang'),
            'telepon'     => $this->request->getPost('telepon'),
            'alamat'      => $this->request->getPost('alamat'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/workers')->with('success', 'Data tukang berhasil ditambahkan!');
    }

    public function update()
    {
        $model = new WorkerModel();
        $id = $this->request->getPost('id');

        $model->update($id, [
            'nama_tukang' => $this->request->getPost('nama_tukang'),
            'telepon'     => $this->request->getPost('telepon'),
            'alamat'      => $this->request->getPost('alamat'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/workers')->with('success', 'Data tukang diperbarui!');
    }

    public function delete($id)
    {
        $model = new WorkerModel();
        $model->delete($id);
        return redirect()->to('/workers')->with('success', 'Data tukang dihapus!');
    }

    // --- EXPORT EXCEL ---
    public function exportExcel()
    {
        if (ob_get_level()) ob_end_clean();
        $model = new WorkerModel();
        $workers = $model->findAll();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Tukang_".date('Ymd').".xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");

        echo '<table border="1">';
        echo '<thead><tr><th>ID</th><th>Nama Tukang</th><th>Telepon</th><th>Alamat</th><th>Status</th></tr></thead><tbody>';
        foreach ($workers as $w) {
            echo '<tr>
                    <td>' . $w['kode_tukang'] . '</td>
                    <td>' . $w['nama_tukang'] . '</td>
                    <td>' . $w['telepon'] . '</td>
                    <td>' . $w['alamat'] . '</td>
                    <td>' . $w['status'] . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
        exit;
    }

    // --- EXPORT CSV ---
    public function exportCsv()
    {
        if (ob_get_level()) ob_end_clean();
        $model = new WorkerModel();
        $workers = $model->findAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Data_Tukang_'.date('Ymd').'.csv"');
        
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Nama Tukang', 'Telepon', 'Alamat', 'Status']);
        foreach ($workers as $w) {
            fputcsv($file, [$w['kode_tukang'], $w['nama_tukang'], $w['telepon'], $w['alamat'], $w['status']]);
        }
        fclose($file);
        exit;
    }
    // --- FITUR PRINT TUKANG ---
    public function print()
    {
        $model = new WorkerModel();
        $data = [
            'title'   => 'Daftar Tukang',
            'workers' => $model->findAll()
        ];
        return view('workers/print', $data);
    }
}