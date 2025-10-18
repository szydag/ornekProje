<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstitutionTypes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('institution_types');

        // Varsayılan kayıtlar
        $data = [
            ['name' => 'Üniversiteler'],
            ['name' => 'Eğitim Kurumları'],
            ['name' => 'Sağlık Kurumları'],
            ['name' => 'Özel Kurumlar'],
            ['name' => 'Kamu Kurumları'],
            ['name' => 'Sivil Toplum Kuruluşları'],
            ['name' => 'Diğer'], // "Diğer" seçeneği, ek bilgi eklenmeyecek
        ];

        $this->db->table('institution_types')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('institution_types');
    }
}
