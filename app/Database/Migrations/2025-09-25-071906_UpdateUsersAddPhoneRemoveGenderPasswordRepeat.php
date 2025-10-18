<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersAddPhoneRemoveGenderPasswordRepeat extends Migration
{
    public function up()
    {
        // phone sütunu ekle
        $this->forge->addColumn('users', [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'mail', // mail sütunundan sonra gelsin
            ],
        ]);

        // password_repeat sütunu varsa kaldır
        if ($this->db->fieldExists('password_repeat', 'users')) {
            $this->forge->dropColumn('users', 'password_repeat');
        }

        // gender sütununu kaldır
        if ($this->db->fieldExists('gender', 'users')) {
            $this->forge->dropColumn('users', 'gender');
        }
    }

    public function down()
    {
        // phone sütununu geri al
        $this->forge->dropColumn('users', 'phone');

        // gender sütununu tekrar ekle
        $this->forge->addColumn('users', [
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['K','E','D'], // Kadın / Erkek / Diğer
                'null'       => true,
            ],
        ]);

        // password_repeat sütununu tekrar ekle
        $this->forge->addColumn('users', [
            'password_repeat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }
}
