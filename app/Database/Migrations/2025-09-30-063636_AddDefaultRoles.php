<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultRoles extends Migration
{
    public function up()
    {
        // Rolleri ekle
        $this->db->table('roles')->insertBatch([
            ['role_name' => 'Admin'],
            ['role_name' => 'Yönetici'],
            ['role_name' => 'Sekreterya'],
            ['role_name' => 'Hakem'],
            ['role_name' => 'Editör'],
        ]);
    }

    public function down()
    {
        // Eklenen rolleri geri al
        $this->db->table('roles')->whereIn('role_name', [
            'Admin', 'Yönetici', 'Sekreterya', 'Hakem', 'Editör'
        ])->delete();
    }
}
