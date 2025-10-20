<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Web Geliştirme Temelleri',
                'description' => 'HTML, CSS ve JavaScript ile web geliştirme temelleri',
                'status' => 1,
                'start_date' => '2024-01-15',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Python Programlama',
                'description' => 'Python programlama dilini öğrenme kursu',
                'status' => 1,
                'start_date' => '2024-02-01',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Veritabanı Yönetimi',
                'description' => 'MySQL ve SQL temelleri',
                'status' => 1,
                'start_date' => '2024-02-15',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Mobil Uygulama Geliştirme',
                'description' => 'React Native ile mobil uygulama geliştirme',
                'status' => 1,
                'start_date' => '2024-03-01',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Veri Analizi',
                'description' => 'Excel ve Python ile veri analizi',
                'status' => 1,
                'start_date' => '2024-03-15',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Proje Yönetimi',
                'description' => 'Agile ve Scrum metodolojileri',
                'status' => 1,
                'start_date' => '2024-04-01',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Siber Güvenlik',
                'description' => 'Temel siber güvenlik prensipleri',
                'status' => 1,
                'start_date' => '2024-04-15',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Yapay Zeka ve Makine Öğrenmesi',
                'description' => 'AI ve ML temelleri',
                'status' => 1,
                'start_date' => '2024-05-01',
                'indefinite' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('courses')->insertBatch($data);
    }
}
