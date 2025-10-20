<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LearningMaterialSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_id' => 1,
                'content_type_id' => 1,
                'first_language' => 'tr',
                'status' => 'on_inceleme',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_id' => 2,
                'content_type_id' => 1,
                'first_language' => 'tr',
                'status' => 'on_inceleme',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_id' => 3,
                'content_type_id' => 1,
                'first_language' => 'tr',
                'status' => 'on_inceleme',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_id' => 4,
                'content_type_id' => 1,
                'first_language' => 'tr',
                'status' => 'on_inceleme',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_id' => 5,
                'content_type_id' => 1,
                'first_language' => 'tr',
                'status' => 'on_inceleme',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('learning_materials')->insertBatch($data);

        // Translations ekleyelim
        $translations = [
            [
                'learning_material_id' => 1,
                'lang' => 'tr',
                'title' => 'HTML Temelleri',
                'short_title' => 'HTML Temelleri',
                'self_description' => 'HTML ile web sayfası oluşturmanın temelleri',
            ],
            [
                'learning_material_id' => 2,
                'lang' => 'tr',
                'title' => 'Python Değişkenler ve Veri Tipleri',
                'short_title' => 'Python Temelleri',
                'self_description' => 'Python programlama dilinde değişkenler ve veri tipleri',
            ],
            [
                'learning_material_id' => 3,
                'lang' => 'tr',
                'title' => 'SQL Sorguları',
                'short_title' => 'SQL Temelleri',
                'self_description' => 'Veritabanı sorguları ve temel SQL komutları',
            ],
            [
                'learning_material_id' => 4,
                'lang' => 'tr',
                'title' => 'React Native Kurulum',
                'short_title' => 'RN Kurulum',
                'self_description' => 'React Native geliştirme ortamının kurulumu',
            ],
            [
                'learning_material_id' => 5,
                'lang' => 'tr',
                'title' => 'Excel ile Veri Analizi',
                'short_title' => 'Excel Analiz',
                'self_description' => 'Excel kullanarak veri analizi teknikleri',
            ]
        ];

        $this->db->table('learning_material_translations')->insertBatch($translations);
    }
}
