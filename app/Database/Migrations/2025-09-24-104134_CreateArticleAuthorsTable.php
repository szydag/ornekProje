<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLearningMaterialContributorsTable extends Migration
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
                'null'       => true, // sistem kullanıcısı değilse null
            ],
            'type' => [ // 'yazar' | 'cevirmen'
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'order_number' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],

            // — Snapshot alanları (opsiyonel ama raporlama için pratik) —
            'orcid' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'surname' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'mail' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
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
                'constraint' => 120,
                'null'       => true,
            ],
            'title_id' => [ // unvan id
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        // PRIMARY KEY
        $this->forge->addKey('id', true);

        // Indexler (sık sorgulanan kolonlar)
        $this->forge->addKey(['learning_material_id']);
        $this->forge->addKey('user_id');
        $this->forge->addKey('title_id');
        $this->forge->addKey('country_id');

        // Foreign Keys
        $this->forge->addForeignKey('learning_material_id', 'learning_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('title_id', 'titles', 'id', 'SET NULL', 'CASCADE');       // tablo adın 'titles' ise
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'SET NULL', 'CASCADE');  // tablo adın 'countries' ise

        $this->forge->createTable('learning_material_contributors');
    }

    public function down()
    {
        $this->forge->dropTable('learning_material_contributors', true);
    }
}
