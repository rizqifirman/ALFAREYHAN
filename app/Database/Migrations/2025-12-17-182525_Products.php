<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_barang' => [ // ID (P001, P002)
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'jenis' => [ // Baju Taqwa, Gamis
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'target' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // <-- Bebas tampung teks apa saja
            ],
            'size' => [ // L, M, XL
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'kain' => [ // Toyobo, Jetblack
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'gambar' => [ // Nama file gambar
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'default.png',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}