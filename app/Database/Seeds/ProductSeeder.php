<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ProductModel;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_barang' => 'P001',
                'nama_barang' => 'Koko Modern Al-Fatih',
                'jenis'       => 'Baju Taqwa',
                'target'      => 'Ayah',
                'size'        => 'L',
                'kain'        => 'Toyobo Premium',
                'stok'        => 24,
                'gambar'      => 'koko.jpg'
            ],
            [
                'kode_barang' => 'P002',
                'nama_barang' => 'Gamis Syari Aisyah',
                'jenis'       => 'Gamis',
                'target'      => 'Ibu',
                'size'        => 'M',
                'kain'        => 'Jetblack Arab',
                'stok'        => 5,
                'gambar'      => 'gamis.jpg'
            ],
            // Tambahkan data dummy agar pagination terlihat
        ];
        
        // Loop tambah data dummy sampai 15 baris
        for($i=3; $i<=15; $i++){
            $data[] = [
                'kode_barang' => 'P00'.$i,
                'nama_barang' => 'Produk Contoh '.$i,
                'jenis'       => 'Kaos',
                'target'      => 'Anak',
                'size'        => 'XL',
                'kain'        => 'Cotton Combed',
                'stok'        => rand(1, 100),
                'gambar'      => 'default.png'
            ];
        }

        $model = new ProductModel();
        $model->insertBatch($data);
    }
}