<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToDokumen extends Migration
{
    public function up()
    {
        $fields = [
            'kebutuhan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('dokumen', $fields);

        $modify = [
            'file_path' => [
                'name'       => 'file_path',
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ]
        ];
        $this->forge->modifyColumn('dokumen', $modify);
    }

    public function down()
    {
        $this->forge->dropColumn('dokumen', ['kebutuhan', 'keterangan']);
        
        // Not rolling back file_path to NOT NULL strictly, because it might contain nulls now
    }
}
