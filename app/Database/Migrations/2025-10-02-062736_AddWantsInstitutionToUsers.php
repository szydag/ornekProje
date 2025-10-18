<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWantsInstitutionToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users',
         ['wants_institution' => ['type'=>'TINYINT',
         'constraint'=>1,'default'=>0]]);
    }

    public function down()
    {
        $this->forge->dropColumn('users',
         'wants_institution');
    }
}
