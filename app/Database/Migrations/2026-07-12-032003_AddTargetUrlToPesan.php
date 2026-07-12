<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTargetUrlToPesan extends Migration
{
    public function up()
    {
        $fields = [
            'target_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'isi_pesan'
            ]
        ];
        $this->forge->addColumn('pesan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pesan', 'target_url');
    }
}
