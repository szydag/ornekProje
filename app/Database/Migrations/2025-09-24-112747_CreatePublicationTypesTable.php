<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContentTypesTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('content_types');

        // Varsayılan içerik türleri
        $data = [
            ['name' => 'Video Ders'],
            ['name' => 'Ders Notları'],
            ['name' => 'Sunum'],
            ['name' => 'Eğitim Dokümanı'],
            ['name' => 'Alıştırma'],
            ['name' => 'Örnek Olay'],
            ['name' => 'Proje Çalışması'],
            ['name' => 'Quiz'],
            ['name' => 'Etkileşimli İçerik'],
            ['name' => 'Okuma Materyali'],
            ['name' => 'Kod Örneği'],
            ['name' => 'Çalışma Kağıdı'],
            ['name' => 'İnfografik'],
            ['name' => 'Podcast'],
            ['name' => 'Animasyon'],
            ['name' => 'Simülasyon'],
            ['name' => 'Lab Çalışması'],
            ['name' => 'Değerlendirme'],
            ['name' => 'Kaynak Doküman'],
            ['name' => 'Öğretim Rehberi'],
            ['name' => 'Kısa Video'],
            ['name' => 'Web Semineri'],
            ['name' => 'Eğitim Oyunu'],
            ['name' => 'Diğer'],
        ];

        $this->db->table('content_types')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('content_types', true);
    }
}
