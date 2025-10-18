<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndefiniteToCourses extends Migration
{
    public function up()
    {
        $fields = [
            'indefinite' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'comment'    => '0=Belirli süreli, 1=Süresiz',
                'after'      => 'end_date', // end_date sütunundan sonra eklenecek
            ],
        ];

        $this->forge->addColumn('courses', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', 'indefinite');
    }
}
