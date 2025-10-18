<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordRepeatToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'password_repeat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'password', // password alanından sonra gelsin
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'password_repeat');
    }
}
