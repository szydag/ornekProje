<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUnvanlarTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('titles');

        // Varsayılan akademik unvanlar
        $data = [
            ['name' => 'Akademik Ünvanı Yok'],
            ['name' => 'Prof. Dr.'],
            ['name' => 'Doç. Dr.'],
            ['name' => 'Yrd. Doç. Dr.'],
            ['name' => 'Dr.'],
            ['name' => 'Uzman'],
            ['name' => 'Arş. Gör.'],
            ['name' => 'Okutman'],
            ['name' => 'Yüksek Lisans'],
            ['name' => 'Doktora'],
            ['name' => 'Öğretim Görevlisi'],
            ['name' => 'Prof.'],
            ['name' => 'Doç.'],
            ['name' => 'Yrd. Doç.'],
            ['name' => 'Uzm. Dr.'],
            ['name' => 'Dr. Öğr. Üyesi'],
            ['name' => 'Dr. Öğretim Görevlisi'],
            ['name' => 'Dr. Arş. Gör.'],
        ];

        $this->db->table('titles')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('titles');
    }
}
