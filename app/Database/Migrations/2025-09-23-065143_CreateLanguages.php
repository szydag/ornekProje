<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLanguages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'code' => [
                'type'       => 'CHAR',
                'constraint' => 2, // ISO 639-1
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('name');
        $this->forge->createTable('languages');

        $data = [
            // Avrupa
            ['name' => 'Türkçe', 'code' => 'tr'],
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Deutsch', 'code' => 'de'],
            ['name' => 'Français', 'code' => 'fr'],
            ['name' => 'Español', 'code' => 'es'],
            ['name' => 'Italiano', 'code' => 'it'],
            ['name' => 'Português', 'code' => 'pt'],
            ['name' => 'Nederlands', 'code' => 'nl'],
            ['name' => 'Polski', 'code' => 'pl'],
            ['name' => 'Čeština', 'code' => 'cs'],
            ['name' => 'Slovenský', 'code' => 'sk'],
            ['name' => 'Magyar', 'code' => 'hu'],
            ['name' => 'Ελληνικά', 'code' => 'el'],
            ['name' => 'Русский', 'code' => 'ru'],
            ['name' => 'Українська', 'code' => 'uk'],
            ['name' => 'Srpski', 'code' => 'sr'],
            ['name' => 'Hrvatski', 'code' => 'hr'],
            ['name' => 'Bosanski', 'code' => 'bs'],
            ['name' => 'Slovene', 'code' => 'sl'],
            ['name' => 'Română', 'code' => 'ro'],

            // Asya
            ['name' => 'العربية', 'code' => 'ar'],
            ['name' => 'فارسی', 'code' => 'fa'],
            ['name' => 'हिन्दी', 'code' => 'hi'],
            ['name' => 'বাংলা', 'code' => 'bn'],
            ['name' => '中文', 'code' => 'zh'],
            ['name' => '日本語', 'code' => 'ja'],
            ['name' => '한국어', 'code' => 'ko'],
            ['name' => 'ไทย', 'code' => 'th'],
            ['name' => 'Tiếng Việt', 'code' => 'vi'],
            ['name' => 'עברית', 'code' => 'he'],

            // Afrika
            ['name' => 'Afrikaans', 'code' => 'af'],
            ['name' => 'Swahili', 'code' => 'sw'],
            ['name' => 'Amharic', 'code' => 'am'],
            ['name' => 'Zulu', 'code' => 'zu'],
            ['name' => 'Xhosa', 'code' => 'xh'],

            // Amerika & Okyanusya
            ['name' => 'Quechua', 'code' => 'qu'],
            ['name' => 'Guarani', 'code' => 'gn'],
            ['name' => 'Haitian Creole', 'code' => 'ht'],
            ['name' => 'Māori', 'code' => 'mi'],
            ['name' => 'Samoan', 'code' => 'sm'],
            ['name' => 'Tongan', 'code' => 'to'],
        ];

        // büyük listeyi küçük parçalara bölerek ekle
        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            $this->db->table('languages')->insertBatch($chunk);
        }
    }

    public function down()
    {
        $this->forge->dropTable('languages');
    }
}
