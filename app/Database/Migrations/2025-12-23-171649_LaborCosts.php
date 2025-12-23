<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LaborCosts extends Migration
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
            'kode_ongkos' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kategori' => [ // Contoh: Baju Taqwa, Gamis
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'ukuran' => [ // Atribut Opsional (L, M, XL)
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'biaya' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'default_ongkos.png',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('labor_costs');
    }

    public function down()
    {
        $this->forge->dropTable('labor_costs');
    }
}
