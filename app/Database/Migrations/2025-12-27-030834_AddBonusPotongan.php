<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBonusPotongan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('garapans', [
            'bonus' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'after'      => 'total_biaya'
            ],
            'potongan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'after'      => 'bonus'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('garapans', ['bonus', 'potongan']);
    }
}