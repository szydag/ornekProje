<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesFixTimestamps extends Migration
{
    public function up()
    {
        // 1) start_date ekle (yoksa)
        if (! $this->db->fieldExists('start_date', 'courses')) {
            $this->forge->addColumn('courses', [
                'start_date' => [
                    'type' => 'DATE', // istersen DATETIME
                    'null' => false,
                    'after' => 'status',
                ],
            ]);
        }

        // 2) updated_at ekle (yoksa)
        if (! $this->db->fieldExists('updated_at', 'courses')) {
            $this->forge->addColumn('courses', [
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'after'   => 'created_at',
                ],
            ]);
        }

        // 3) created_at'ı NULL kabul et (veya default CURRENT_TIMESTAMP ver)
        // MySQL sürümüne göre aşağıdakinden birini tercih et:
        $this->db->query("ALTER TABLE `courses` MODIFY `created_at` DATETIME NULL");

        // NOT: İsterseniz:
        // $this->db->query("ALTER TABLE `courses` 
        //   MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        // Rollback için minimum işlemler
        // $this->forge->dropColumn('courses', 'start_date');
        // $this->forge->dropColumn('courses', 'updated_at');
        // created_at eski haline dönmüyor (riskli), boş bırakıyoruz.
    }
}
