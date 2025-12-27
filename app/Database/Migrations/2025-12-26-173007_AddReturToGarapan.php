<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReturToGarapan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('garapan_products', [
            'qty_retur' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'after'      => 'qty_hasil'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('garapan_products', 'qty_retur');
    }
}