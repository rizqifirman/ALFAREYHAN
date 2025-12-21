<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{

public function up()
    {
        // Perhatikan: Semua kolom harus ada di dalam satu array besar []
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['owner', 'produksi', 'kasir', 'accounting'],
                'default'    => 'kasir',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Set Primary Key
        $this->forge->addKey('id', true);
        
        // Buat Tabel
        $this->forge->createTable('users');
    }
public function down()
{
    // Ini perintah untuk menghapus tabel jika nanti kita rollback
    $this->forge->dropTable('users');
}
}
