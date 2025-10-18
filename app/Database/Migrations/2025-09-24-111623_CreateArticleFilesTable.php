<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialFilesTable extends Migration
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
            'file_type' => [
                'type'       => 'INT',
                'constraint' => 4, // örn: 1=intihal raporu, 2=başvuru dosyası vs.
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255, // dosya adı/path
                'null'       => false,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
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

        $this->forge->createTable('learning_material_files');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_files', true);
    }
}
