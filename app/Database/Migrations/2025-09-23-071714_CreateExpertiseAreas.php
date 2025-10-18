<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExpertiseAreas extends Migration
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
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'name_tr' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'name_en' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('parent_id'); // ağaç sorguları için index
        $this->forge->addForeignKey('parent_id', 'expertise_areas', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('expertise_areas');
    }

    public function down()
    {
        $this->forge->dropTable('expertise_areas', true);
    }
}
