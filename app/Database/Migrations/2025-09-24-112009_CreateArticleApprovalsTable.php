<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialApprovalsTable extends Migration
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
            'learning_material_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rules_ok' => [
                'type'       => 'ENUM',
                'constraint' => ['evet', 'hayir'],
                'default'    => 'hayir',
            ],
            'all_authors_ok' => [
                'type'       => 'ENUM',
                'constraint' => ['evet', 'hayir'],
                'default'    => 'hayir',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('learning_material_id');

        // FK: learning_materials(id)
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('learning_material_approvals');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_approvals', true);
    }
}
