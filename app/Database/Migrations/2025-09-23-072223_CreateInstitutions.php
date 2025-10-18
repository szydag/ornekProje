<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstitutions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => false,
            ],
            'institution_type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // tür silinirse kurum kalabilsin
            ],
            'language_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'country_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('institution_type_id');
        $this->forge->addKey('language_id');
        $this->forge->addKey('country_id');
        $this->forge->createTable('institutions', true);

        // Foreign Keys
        $this->db->query('ALTER TABLE institutions
            ADD CONSTRAINT fk_institutions_type
                FOREIGN KEY (institution_type_id) REFERENCES institution_types(id)
                ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT fk_institutions_language
                FOREIGN KEY (language_id) REFERENCES languages(id)
                ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT fk_institutions_country
                FOREIGN KEY (country_id) REFERENCES countries(id)
                ON DELETE SET NULL ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        // FK'leri düşürüp tabloyu sil
        $this->db->query('ALTER TABLE institutions
            DROP FOREIGN KEY fk_institutions_type,
            DROP FOREIGN KEY fk_institutions_language,
            DROP FOREIGN KEY fk_institutions_country
        ');
        $this->forge->dropTable('institutions', true);
    }
}
