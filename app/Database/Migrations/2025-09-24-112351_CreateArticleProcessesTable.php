<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialWorkflowsTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'admin_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'processes_code' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'action_code' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('learning_material_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('admin_id');

        // Foreign Keys
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('admin_id', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('learning_material_workflows');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_workflows', true);
    }
}
