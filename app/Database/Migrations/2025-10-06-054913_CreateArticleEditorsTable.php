<?php
declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialEditorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'learning_material_id'   => ['type'=>'INT','unsigned'=>true],
            'editor_id'    => ['type'=>'INT','unsigned'=>true],
            'assigned_at'  => ['type'=>'DATETIME','null'=>false],
            'decision_code'=> ['type'=>'VARCHAR','constraint'=>20,'null'=>true], // onizleme|revizyon|red
            'decided_at'   => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['learning_material_id','editor_id']);
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('editor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('learning_material_editors');
    }
    public function down()
    {
        $this->forge->dropTable('learning_material_editors', true);
    }
}
