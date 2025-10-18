<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTopicsTable extends Migration
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
                'type'       => 'TEXT', // uzun başlıklar için TEXT tercih ettim; istersen VARCHAR(255) yapabilirsin
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('topics');

        $now = date('Y-m-d H:i:s');

        $names = [
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Güvenliği Yönetimi',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Modelleme, Yönetim ve Ontolojiler',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri Eğitimi',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri Felsefesi, Araştırma Yöntemleri ve Teori',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri Geliştirme Metodolojileri ve Uygulamaları',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri Kullanıcı Deneyimi Tasarımı ve Geliştirme',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri Organizasyonu ve Yönetimi',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > E-Devlet',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Elektronik Belge Yönetim Sistemleri',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > İş Süreçleri Yönetimi',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Karar Desteği ve Grup Destek Sistemleri',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Organizasyonel, Organizasyon Dışı ve Küresel Bilgi Sistemleri',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Sürdürülebilir Kalkınma ve Kamu Yararına Bilgi Sistemleri',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Yönetim Bilişim Sistemleri',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgi Sistemleri > Bilgi Sistemleri (Diğer)',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Aktif Algılama',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Bilgisayar Görüşü',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Görüntü İşleme',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Hesaplamalı Görüntüleme',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Multimodal Analiz ve Sentez',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Örüntü Tanıma',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Resim ve Video Kodlama',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Ses İşleme',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Video İşleme',
            'Bilgi ve Bilgi İşleme Bilimleri > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama > Bilgisayar Görüşü ve Çoklu Ortam Hesaplama (Diğer)',
            'Dil, İletişim ve Kültür > Dilbilim > Toplumsal Dilbilim',
            'Dil, İletişim ve Kültür > Dilbilim > Uygulamalı Dilbilim ve Eğitim Dilbilimi',
            'Dil, İletişim ve Kültür > Dilbilim > Dilbilim (Diğer)',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Afrika Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Alman Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Anadolu Dilleri, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Arap Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Arnavut Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Asya Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Avrupa Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Boşnak Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Bulgar Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Çağdaş Yunan Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Çin Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Ermeni Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Fars Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Fransız Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Güney-Doğu Asya Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Hırvat Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Hint Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Hollanda Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > İngiliz ve İrlanda Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > İspanyol Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > İtalyan Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Japon Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Kafkas Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Kore Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Kuzey Amerika Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Kürt Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Latin Amerika Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Leh Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Macar Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Modern Türk Edebiyatı',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Portekiz Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Rus Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Slav Dilleri, Edebiyatları ve Kültürleri',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Urdu Dili, Edebiyatı ve Kültürü',
            'Dil, İletişim ve Kültür > Dünya Dilleri, Edebiyatı ve Kültürü > Dünya Dilleri, Edebiyatı ve Kültürü (Diğer)',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Basılı Kültür',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Çağdaş Tiyatro Çalışmaları',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Çocuk Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Dijital Edebiyat',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Edebi Teori',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Ekoeleştiri',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Genç Yetişkin Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Hititoloji',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Karşılaştırmalı ve Ulusötesi Edebiyat',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Latince ve Klasik Yunan Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Modern ve Postmodern Edebiyat',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Ortaçağ Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Popüler ve Tür Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Romantik Dönem Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Rönesans Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Sömürge Dönemi Sonrası Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Stilistik ve Metinsel Analiz',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Sümeroloji',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Türk İslam Edebiyatı',
            'Dil, İletişim ve Kültür > Edebi Çalışmalar > Edebi Çalışmalar (Diğer)',
            'Dil, İletişim ve Kültür > Türk Halk Bilimi > Alevilik Bektaşilik Araştırmaları',
            'Dil, İletişim ve Kültür > Türk Halk Bilimi > Türkiye Dışındaki Türk Halk Bilimi',
            'Dil, İletişim ve Kültür > Türk Halk Bilimi > Türkiye Sahası Türk Halk Bilimi',
            'Dil, İletişim ve Kültür > Türk Halk Bilimi > Türk Halk Bilimi (Diğer)',
            'Eğitim > Alan Eğitimleri > Alan Eğitimleri (Diğer)',
            'Eğitim > Eğitim Programları ve Öğretim > Çok Kültürlü Eğitim',
            'Eğitim > Eğitim Programları ve Öğretim > Değerler Eğitimi',
            'Eğitim > Eğitim Programları ve Öğretim > Eğitimde Hazırbulunuşluluk',
            'Eğitim > Eğitim Programları ve Öğretim > Eğitimde Program Değerlendirme',
            'Eğitim > Eğitim Programları ve Öğretim > Eğitimde Program Geliştirme',
            'Eğitim > Eğitim Programları ve Öğretim > Eğitimin Felsefi ve Sosyal Temelleri',
            'Eğitim > Eğitim Programları ve Öğretim > Eğitimin Psikolojik Temelleri',
            'Eğitim > Eğitim Programları ve Öğretim > Hayat Boyu Öğrenme',
            'Eğitim > Eğitim Programları ve Öğretim > Hizmetiçi Eğitim',
            'Eğitim > Eğitim Programları ve Öğretim > İnformal Öğrenme',
            'Eğitim > Eğitim Programları ve Öğretim > Karşılaştırmalı ve Kültürlerarası Eğitim',
            'Eğitim > Eğitim Programları ve Öğretim > Okul Dışı Öğrenme',
        ];

        $rows = array_map(static fn($name) => [
            'name'       => $name,
            'created_at' => $now,
            'updated_at' => $now,
        ], $names);

        $this->db->table('topics')->insertBatch($rows);
    }

    public function down()
    {
        $this->forge->dropTable('topics', true);
    }
}
