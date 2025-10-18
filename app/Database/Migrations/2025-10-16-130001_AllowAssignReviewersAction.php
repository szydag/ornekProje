<?php
declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

final class AllowAssignReviewersAction extends Migration
{
    public function up(): void
    {
        // Allow storing custom workflow action codes like "assign_reviewers".
        $this->forge->modifyColumn('learning_material_workflows', [
            'action_code' => [
                'name'       => 'action_code',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }

    public function down(): void
    {
        // Revert to the original limited set of action codes.
        $this->forge->modifyColumn('learning_material_workflows', [
            'action_code' => [
                'name'       => 'action_code',
                'type'       => "ENUM('revizyon','revizyonok','onay','red','yayinla','onizleme')",
                'null'       => true,
            ],
        ]);
    }
}

