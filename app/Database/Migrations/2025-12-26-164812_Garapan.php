<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Garapan extends Migration
{
    public function up()
    {
        // 1. Tabel Utama Garapan (SPK)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'no_faktur' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'worker_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_spk' => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATETIME', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['Proses', 'Selesai', 'Batal', 'Revisi'], 'default' => 'Proses'],
            'total_biaya' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0], // Ongkos Jahit Total
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('garapans');

        // 2. Tabel Material Keluar (Bahan yang dibawa tukang)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'garapan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'material_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'qty' => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('garapan_materials');

        // 3. Tabel Target Produk (Baju yang harus jadi)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'garapan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ongkos_satuan' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0], // Ongkos per pcs
            'qty_target' => ['type' => 'INT', 'constraint' => 11],
            'qty_hasil' => ['type' => 'INT', 'constraint' => 11, 'default' => 0], // Diisi saat setor
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('garapan_products');
    }

    public function down()
    {
        $this->forge->dropTable('garapan_products');
        $this->forge->dropTable('garapan_materials');
        $this->forge->dropTable('garapans');
    }
}