<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Önce temel seeder'ları çalıştır
        $this->call('ExpertiseAreasSeeder');
        $this->call('InstitutionsSeeder');
        $this->call('DemoUserSeeder');
        $this->call('CourseSeeder');
        $this->call('LearningMaterialSeeder');

        echo "\n✅ Tüm demo veriler başarıyla oluşturuldu!\n";
        echo "\n📋 Sunum için hazır kullanıcılar:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "👤 Admin:     admin@educontent.com    / admin123\n";
        echo "👤 Editör:   editor@educontent.com   / editor123\n";
        echo "👤 Hakem:     reviewer@educontent.com / reviewer123\n";
        echo "👤 Yazar:     author@educontent.com   / author123\n";
        echo "👤 Demo:      demo@educontent.com     / demo123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}


