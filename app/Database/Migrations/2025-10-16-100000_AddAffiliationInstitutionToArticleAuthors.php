<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

final class AddAffiliationInstitutionToLearningMaterialContributors extends Migration
{
    public function up(): void
    {
        $table = 'learning_material_contributors';
        $db = $this->db ?? db_connect();

        if (!$db->fieldExists('affiliation', $table)) {
            $this->forge->addColumn($table, [
                'affiliation' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'city',
                ],
            ]);
        }

        if (!$db->fieldExists('institution_id', $table)) {
            $this->forge->addColumn($table, [
                'institution_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'affiliation',
                ],
            ]);
        }
    }

    public function down(): void
    {
        $table = 'learning_material_contributors';
        $db = $this->db ?? db_connect();

        if ($db->fieldExists('institution_id', $table)) {
            $this->forge->dropColumn($table, 'institution_id');
        }

        if ($db->fieldExists('affiliation', $table)) {
            $this->forge->dropColumn($table, 'affiliation');
        }
    }
}
