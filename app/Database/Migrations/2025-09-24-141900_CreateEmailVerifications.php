<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailVerifications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => false,
            ],
            'code'  => [
                'type'       => 'VARCHAR',
                'constraint' => 64, // ihtiyacına göre 32/128 yapabilirsin
                'null'       => false,
            ],
            // "date" alanı: gönderim zamanı
            // MySQL 8+ için DATETIME default CURRENT_TIMESTAMP çalışır.
            'date'  => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            // Durum: pending / verified / expired
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'verified', 'expired'],
                'default'    => 'pending',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);               // PK
        $this->forge->addKey('email');                  // arama için index
        $this->forge->addKey('code', false, true);      // UNIQUE(code)
        $this->forge->createTable('email_verifications', true);
    }

    public function down()
    {
        $this->forge->dropTable('email_verifications', true);
    }
}
