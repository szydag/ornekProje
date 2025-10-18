<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialTemplatesTable extends Migration
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
            'name' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'type' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'label' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'template_name' => [
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

        $this->forge->createTable('learning_material_templates');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_templates', true);
    }
}
