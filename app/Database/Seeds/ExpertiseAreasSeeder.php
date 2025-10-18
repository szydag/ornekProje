<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExpertiseAreasSeeder extends Seeder
{
    public function run()
    {
        // Büyük veri setini ayrı bir PHP dosyasından alıyoruz:
        // Bu dosya `return [ ['parent_id'=>..., 'name_tr'=>'...', 'name_en'=>'...'], ... ];` döndürüyor.
        $data = require APPPATH . 'Database/Seeds/data/expertise_areas_data.php';

        // Güvenli parça parça insert (100’lük bloklar)
        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            $this->db->table('expertise_areas')->insertBatch($chunk);
        }
    }
}
