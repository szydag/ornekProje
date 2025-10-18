<?php
declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialReviewersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'learning_material_id'   => ['type'=>'INT','unsigned'=>true],
            'reviewer_id'  => ['type'=>'INT','unsigned'=>true],
            'assigned_at'  => ['type'=>'DATETIME','null'=>false],
            'decision_code'=> ['type'=>'VARCHAR','constraint'=>20,'null'=>true], // onay|revizyon|red
            'decided_at'   => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['learning_material_id','reviewer_id']);
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('learning_material_reviewers');
    }
    public function down()
    {
        $this->forge->dropTable('learning_material_reviewers', true);
    }
}
