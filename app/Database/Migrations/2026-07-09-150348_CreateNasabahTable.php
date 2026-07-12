<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNasabahTable extends Migration
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
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'jenis_akun' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'no_rekening' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'tanggal_arsip' => [
                'type' => 'DATE',
            ],
            'no_arsip' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'Aktif',
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
        $this->forge->createTable('nasabah');
    }

    public function down()
    {
        $this->forge->dropTable('nasabah');
    }
}
