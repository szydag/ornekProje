<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLearningMaterialsAddContentTypeId extends Migration
{
    protected string $fkName = 'fk_learning_materials_content_type_id';

    public function up()
    {
        // Mevcut alanları oku
        $fields = array_map('strtolower', $this->db->getFieldNames('learning_materials'));

        // Eski VARCHAR kolonu varsa kaldır
        if (in_array('content_type', $fields, true)) {
            $this->forge->dropColumn('learning_materials', 'content_type');
        }

        // Yeni INT FK kolonu yoksa ekle
        if (! in_array('content_type_id', $fields, true)) {
            $this->forge->addColumn('learning_materials', [
                'content_type_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'course_id',
                ],
            ]);
        }

        // FK ekle (açık isim veriyoruz ki down()'da güvenle silelim)
        $this->db->query(
            "ALTER TABLE `learning_materials`
             ADD CONSTRAINT `{$this->fkName}`
             FOREIGN KEY (`content_type_id`)
             REFERENCES `content_types`(`id`)
             ON DELETE SET NULL
             ON UPDATE CASCADE"
        );
    }

    public function down()
    {
        // Önce FK'yi kaldır
        // Not: MySQL'de index'i de kaldırmak gerekebilir; çoğu durumda otomatik kaldırılır.
        $this->forge->dropForeignKey('learning_materials', $this->fkName);

        // Kolonu kaldır
        $fields = array_map('strtolower', $this->db->getFieldNames('learning_materials'));
        if (in_array('content_type_id', $fields, true)) {
            $this->forge->dropColumn('learning_materials', 'content_type_id');
        }

        // Eski VARCHAR kolonu geri ekle
        $this->forge->addColumn('learning_materials', [
            'content_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'course_id',
            ],
        ]);
    }
}
