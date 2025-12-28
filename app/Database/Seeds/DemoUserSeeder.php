<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run()
    {
        // Önce roles tablosunun dolu olduğundan emin ol
        $rolesCount = $this->db->table('roles')->countAllResults();
        if ($rolesCount === 0) {
            echo "⚠️  Roles tablosu boş! Önce AddDefaultRoles migration'ını çalıştırın.\n";
            return;
        }

        $users = [
            [
                'name' => 'Admin',
                'surname' => 'User',
                'mail' => 'admin@educontent.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'phone' => '05551234567',
                'country_id' => 1,
                'title_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Editör',
                'surname' => 'User',
                'mail' => 'editor@educontent.com',
                'password' => password_hash('editor123', PASSWORD_DEFAULT),
                'phone' => '05551234568',
                'country_id' => 1,
                'title_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Hakem',
                'surname' => 'User',
                'mail' => 'reviewer@educontent.com',
                'password' => password_hash('reviewer123', PASSWORD_DEFAULT),
                'phone' => '05551234569',
                'country_id' => 1,
                'title_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Yazar',
                'surname' => 'User',
                'mail' => 'author@educontent.com',
                'password' => password_hash('author123', PASSWORD_DEFAULT),
                'phone' => '05551234570',
                'country_id' => 1,
                'title_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Demo',
                'surname' => 'Kullanıcı',
                'mail' => 'demo@educontent.com',
                'password' => password_hash('demo123', PASSWORD_DEFAULT),
                'phone' => '05551234571',
                'country_id' => 1,
                'title_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $userIds = [];
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
            $userIds[] = $this->db->insertID();
        }

        // Rolleri ata (user_roles tablosunda is_primary yok, sadece user_id, role_id, created_at var)
        $roles = [
            ['user_id' => $userIds[0], 'role_id' => 2, 'created_at' => date('Y-m-d H:i:s')], // Admin
            ['user_id' => $userIds[1], 'role_id' => 5, 'created_at' => date('Y-m-d H:i:s')], // Editor
            ['user_id' => $userIds[2], 'role_id' => 4, 'created_at' => date('Y-m-d H:i:s')], // Reviewer
            ['user_id' => $userIds[3], 'role_id' => 1, 'created_at' => date('Y-m-d H:i:s')], // Author
            ['user_id' => $userIds[4], 'role_id' => 1, 'created_at' => date('Y-m-d H:i:s')], // Demo (Author)
        ];

        foreach ($roles as $role) {
            $this->db->table('user_roles')->insert($role);
        }

        echo "Demo kullanıcılar oluşturuldu!\n";
        echo "Admin: admin@educontent.com / admin123\n";
        echo "Editör: editor@educontent.com / editor123\n";
        echo "Hakem: reviewer@educontent.com / reviewer123\n";
        echo "Yazar: author@educontent.com / author123\n";
        echo "Demo: demo@educontent.com / demo123\n";
    }
}

