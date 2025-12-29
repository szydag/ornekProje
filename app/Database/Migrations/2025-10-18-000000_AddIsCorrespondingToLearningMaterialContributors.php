<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

final class AddIsCorrespondingToLearningMaterialContributors extends Migration
{
    public function up(): void
    {
        $table = 'learning_material_contributors';
        $db = $this->db ?? db_connect();

        if (!$db->fieldExists('is_corresponding', $table)) {
            $this->forge->addColumn($table, [
                'is_corresponding' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'after' => 'title_id',
                ],
            ]);
        }
    }

    public function down(): void
    {
        $table = 'learning_material_contributors';
        $db = $this->db ?? db_connect();

        if ($db->fieldExists('is_corresponding', $table)) {
            $this->forge->dropColumn($table, 'is_corresponding');
        }
    }
}
