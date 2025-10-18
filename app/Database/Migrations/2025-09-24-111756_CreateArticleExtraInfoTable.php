<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialExtraInfoTable extends Migration
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
            'lang' => [
                'type'       => 'VARCHAR',
                'constraint' => 5, // örn: tr, en
                'null'       => true,
            ],
            'ethics_declaration' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'supporting_institution' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'thanks_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'project_number' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('learning_material_id');

        // FK: learning_materials(id)
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('learning_material_extra_info');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_extra_info', true);
    }
}
