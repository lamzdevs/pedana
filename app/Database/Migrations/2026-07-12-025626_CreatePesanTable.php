<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesanTable extends Migration
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
            'pengirim_role' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'penerima_role' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'isi_pesan' => [
                'type' => 'TEXT',
            ],
            'is_read' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('pesan');
    }

    public function down()
    {
        $this->forge->dropTable('pesan');
    }
}
