<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUlkeler extends Migration
{
    public function up()
    {
        // 1) Tablo yoksa oluştur
        if (! $this->db->tableExists('countries')) {
            $this->forge->addField([
                'id'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
                'name' => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
                'code' => ['type'=>'CHAR','constraint'=>2,'null'=>false],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('code');
            $this->forge->addKey('name');
            $this->forge->createTable('countries', true); // varsa hata verme
        }

        // 2) Seed verileri
        $rows = [
            // Avrupa
            ['code'=>'TR','name'=>'Türkiye'],
            ['code'=>'DE','name'=>'Almanya'],
            ['code'=>'FR','name'=>'Fransa'],
            ['code'=>'IT','name'=>'İtalya'],
            ['code'=>'ES','name'=>'İspanya'],
            ['code'=>'PT','name'=>'Portekiz'],
            ['code'=>'GB','name'=>'Birleşik Krallık'],
            ['code'=>'IE','name'=>'İrlanda'],
            ['code'=>'NL','name'=>'Hollanda'],
            ['code'=>'BE','name'=>'Belçika'],
            ['code'=>'LU','name'=>'Lüksemburg'],
            ['code'=>'AT','name'=>'Avusturya'],
            ['code'=>'CH','name'=>'İsviçre'],
            ['code'=>'SE','name'=>'İsveç'],
            ['code'=>'NO','name'=>'Norveç'],
            ['code'=>'DK','name'=>'Danimarka'],
            ['code'=>'FI','name'=>'Finlandiya'],
            ['code'=>'IS','name'=>'İzlanda'],
            ['code'=>'PL','name'=>'Polonya'],
            ['code'=>'CZ','name'=>'Çekya'],
            ['code'=>'SK','name'=>'Slovakya'],
            ['code'=>'HU','name'=>'Macaristan'],
            ['code'=>'RO','name'=>'Romanya'],
            ['code'=>'BG','name'=>'Bulgaristan'],
            ['code'=>'GR','name'=>'Yunanistan'],
            ['code'=>'HR','name'=>'Hırvatistan'],
            ['code'=>'SI','name'=>'Slovenya'],
            ['code'=>'RS','name'=>'Sırbistan'],
            ['code'=>'BA','name'=>'Bosna-Hersek'],
            ['code'=>'MK','name'=>'Kuzey Makedonya'],
            ['code'=>'AL','name'=>'Arnavutluk'],
            ['code'=>'ME','name'=>'Karadağ'],
            ['code'=>'XK','name'=>'Kosova'],
            ['code'=>'UA','name'=>'Ukrayna'],
            ['code'=>'MD','name'=>'Moldova'],
            ['code'=>'BY','name'=>'Belarus'],
            ['code'=>'LT','name'=>'Litvanya'],
            ['code'=>'LV','name'=>'Letonya'],
            ['code'=>'EE','name'=>'Estonya'],
            ['code'=>'RU','name'=>'Rusya Federasyonu'],
            ['code'=>'GE','name'=>'Gürcistan'],
            ['code'=>'AM','name'=>'Ermenistan'],
            ['code'=>'AZ','name'=>'Azerbaycan'],
            ['code'=>'CY','name'=>'Kıbrıs'],

            // Amerika kıtası
            ['code'=>'US','name'=>'Amerika Birleşik Devletleri'],
            ['code'=>'CA','name'=>'Kanada'],
            ['code'=>'MX','name'=>'Meksika'],
            ['code'=>'BR','name'=>'Brezilya'],
            ['code'=>'AR','name'=>'Arjantin'],
            ['code'=>'CL','name'=>'Şili'],
            ['code'=>'CO','name'=>'Kolombiya'],
            ['code'=>'PE','name'=>'Peru'],
            ['code'=>'VE','name'=>'Venezuela'],
            ['code'=>'UY','name'=>'Uruguay'],
            ['code'=>'PY','name'=>'Paraguay'],
            ['code'=>'BO','name'=>'Bolivya'],
            ['code'=>'EC','name'=>'Ekvador'],
            ['code'=>'GT','name'=>'Guatemala'],
            ['code'=>'CU','name'=>'Küba'],
            ['code'=>'DO','name'=>'Dominik Cumhuriyeti'],
            ['code'=>'HT','name'=>'Haiti'],
            ['code'=>'CR','name'=>'Kosta Rika'],
            ['code'=>'PA','name'=>'Panama'],
            ['code'=>'SV','name'=>'El Salvador'],
            ['code'=>'HN','name'=>'Honduras'],
            ['code'=>'NI','name'=>'Nikaragua'],
            ['code'=>'JM','name'=>'Jamaika'],
            ['code'=>'TT','name'=>'Trinidad ve Tobago'],
            ['code'=>'BS','name'=>'Bahamalar'],
            ['code'=>'BB','name'=>'Barbados'],

            // Asya
            ['code'=>'CN','name'=>'Çin'],
            ['code'=>'JP','name'=>'Japonya'],
            ['code'=>'KR','name'=>'Güney Kore'],
            ['code'=>'KP','name'=>'Kuzey Kore'],
            ['code'=>'IN','name'=>'Hindistan'],
            ['code'=>'PK','name'=>'Pakistan'],
            ['code'=>'BD','name'=>'Bangladeş'],
            ['code'=>'LK','name'=>'Sri Lanka'],
            ['code'=>'NP','name'=>'Nepal'],
            ['code'=>'BT','name'=>'Butan'],
            ['code'=>'MV','name'=>'Maldivler'],
            ['code'=>'IR','name'=>'İran'],
            ['code'=>'IQ','name'=>'Irak'],
            ['code'=>'SY','name'=>'Suriye'],
            ['code'=>'JO','name'=>'Ürdün'],
            ['code'=>'LB','name'=>'Lübnan'],
            ['code'=>'IL','name'=>'İsrail'],
            ['code'=>'PS','name'=>'Filistin'],
            ['code'=>'SA','name'=>'Suudi Arabistan'],
            ['code'=>'AE','name'=>'Birleşik Arap Emirlikleri'],
            ['code'=>'QA','name'=>'Katar'],
            ['code'=>'KW','name'=>'Kuveyt'],
            ['code'=>'OM','name'=>'Umman'],
            ['code'=>'YE','name'=>'Yemen'],
            ['code'=>'KZ','name'=>'Kazakistan'],
            ['code'=>'UZ','name'=>'Özbekistan'],
            ['code'=>'KG','name'=>'Kırgızistan'],
            ['code'=>'TJ','name'=>'Tacikistan'],
            ['code'=>'TM','name'=>'Türkmenistan'],
            ['code'=>'AF','name'=>'Afganistan'],
            ['code'=>'MM','name'=>'Myanmar'],
            ['code'=>'TH','name'=>'Tayland'],
            ['code'=>'LA','name'=>'Laos'],
            ['code'=>'KH','name'=>'Kamboçya'],
            ['code'=>'VN','name'=>'Vietnam'],
            ['code'=>'MY','name'=>'Malezya'],
            ['code'=>'SG','name'=>'Singapur'],
            ['code'=>'ID','name'=>'Endonezya'],
            ['code'=>'PH','name'=>'Filipinler'],
            ['code'=>'BN','name'=>'Brunei'],
            ['code'=>'MN','name'=>'Moğolistan'],
            ['code'=>'TW','name'=>'Tayvan'],
            ['code'=>'HK','name'=>'Hong Kong'],
            ['code'=>'MO','name'=>'Makao'],

            // Afrika
            ['code'=>'EG','name'=>'Mısır'],
            ['code'=>'MA','name'=>'Fas'],
            ['code'=>'DZ','name'=>'Cezayir'],
            ['code'=>'TN','name'=>'Tunus'],
            ['code'=>'LY','name'=>'Libya'],
            ['code'=>'SD','name'=>'Sudan'],
            ['code'=>'SS','name'=>'Güney Sudan'],
            ['code'=>'ET','name'=>'Etiyopya'],
            ['code'=>'SO','name'=>'Somali'],
            ['code'=>'KE','name'=>'Kenya'],
            ['code'=>'UG','name'=>'Uganda'],
            ['code'=>'TZ','name'=>'Tanzanya'],
            ['code'=>'RW','name'=>'Ruanda'],
            ['code'=>'BI','name'=>'Burundi'],
            ['code'=>'CD','name'=>'Kongo DC'],
            ['code'=>'CG','name'=>'Kongo Cum.'],
            ['code'=>'CM','name'=>'Kamerun'],
            ['code'=>'NG','name'=>'Nijerya'],
            ['code'=>'GH','name'=>'Gana'],
            ['code'=>'CI','name'=>'Fildişi Sahili'],
            ['code'=>'SN','name'=>'Senegal'],
            ['code'=>'ML','name'=>'Mali'],
            ['code'=>'NE','name'=>'Nijer'],
            ['code'=>'BF','name'=>'Burkina Faso'],
            ['code'=>'TG','name'=>'Togo'],
            ['code'=>'BJ','name'=>'Benin'],
            ['code'=>'SL','name'=>'Sierra Leone'],
            ['code'=>'LR','name'=>'Liberya'],
            ['code'=>'GM','name'=>'Gambiya'],
            ['code'=>'MR','name'=>'Moritanya'],
            ['code'=>'GN','name'=>'Gine'],
            ['code'=>'GW','name'=>'Gine-Bissau'],
            ['code'=>'ZA','name'=>'Güney Afrika'],
            ['code'=>'NA','name'=>'Namibya'],
            ['code'=>'BW','name'=>'Botsvana'],
            ['code'=>'ZW','name'=>'Zimbabve'],
            ['code'=>'ZM','name'=>'Zambiya'],
            ['code'=>'MZ','name'=>'Mozambik'],
            ['code'=>'AO','name'=>'Angola'],
            ['code'=>'GA','name'=>'Gabon'],
            ['code'=>'GQ','name'=>'Ekvator Ginesi'],
            ['code'=>'ST','name'=>'São Tomé ve Príncipe'],
            ['code'=>'CV','name'=>'Yeşil Burun Adaları'],
            ['code'=>'SC','name'=>'Seyşeller'],
            ['code'=>'MU','name'=>'Mauritius'],
            ['code'=>'MG','name'=>'Madagaskar'],
            ['code'=>'KM','name'=>'Komorlar'],
            ['code'=>'SZ','name'=>'Esvatini'],
            ['code'=>'LS','name'=>'Lesotho'],

            // Okyanusya
            ['code'=>'AU','name'=>'Avustralya'],
            ['code'=>'NZ','name'=>'Yeni Zelanda'],
            ['code'=>'PG','name'=>'Papua Yeni Gine'],
            ['code'=>'FJ','name'=>'Fiji'],
            ['code'=>'SB','name'=>'Solomon Adaları'],
            ['code'=>'VU','name'=>'Vanuatu'],
            ['code'=>'TO','name'=>'Tonga'],
            ['code'=>'WS','name'=>'Samoa'],
            ['code'=>'KI','name'=>'Kiribati'],
            ['code'=>'TV','name'=>'Tuvalu'],
            ['code'=>'FM','name'=>'Mikronezya'],
            ['code'=>'MH','name'=>'Marshall Adaları'],
            ['code'=>'PW','name'=>'Palau'],

            // Orta Doğu & çevre tamamlayıcılar (tekrar olmayanlar)
            ['code'=>'BH','name'=>'Bahreyn'],
        ];

        // 3) Kayıtları güvenli şekilde (100'lük bloklarla) ekle
        if (! empty($rows)) {
            $chunks = array_chunk($rows, 100);
            foreach ($chunks as $chunk) {
                $this->db->table('countries')->ignore(true)->insertBatch($chunk);
            }
        }
    }

    public function down()
    {
        $this->forge->dropTable('countries', true);
    }
}
