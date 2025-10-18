<?php
declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLearningMaterialEditorsTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('learning_material_editors', [
            'editor_id' => [
                'name'       => 'editor_id',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addColumn('learning_material_editors', [
            'editor_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => false,
                'after'      => 'learning_material_id',
            ],
            'assigned_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'editor_id',
            ],
        ]);

        if (!$this->indexExists('learning_material_editors', 'learning_material_editors_editor_email_idx')) {
            $this->db->query('CREATE INDEX learning_material_editors_editor_email_idx ON learning_material_editors(editor_email)');
        }
        if (!$this->indexExists('learning_material_editors', 'learning_material_editors_material_email_uq')) {
            $this->db->query('CREATE UNIQUE INDEX learning_material_editors_material_email_uq ON learning_material_editors(learning_material_id, editor_email)');
        }
    }

    public function down()
    {
        if ($this->indexExists('learning_material_editors', 'learning_material_editors_material_email_uq')) {
            $this->db->query('DROP INDEX learning_material_editors_material_email_uq ON learning_material_editors');
        }
        if ($this->indexExists('learning_material_editors', 'learning_material_editors_editor_email_idx')) {
            $this->db->query('DROP INDEX learning_material_editors_editor_email_idx ON learning_material_editors');
        }

        $this->forge->dropColumn('learning_material_editors', ['editor_email', 'assigned_by']);

        $this->forge->modifyColumn('learning_material_editors', [
            'editor_id' => [
                'name'       => 'editor_id',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }

    private function indexExists(string $table, string $index): bool
    {
        $result = $this->db->query('SHOW INDEX FROM ' . $this->db->escapeIdentifiers($table) . ' WHERE Key_name = ' . $this->db->escape($index));
        return $result !== false && $result->getNumRows() > 0;
    }
}
