<?php
// app/Controllers/Users/UsersController.php
declare(strict_types=1);

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\Roles\RolesModel;
use App\Models\Roles\UserRoleModel;
use App\Models\Users\UserModel;

final class UsersController extends BaseController
{
    public function homeAdmin(): string
    {
        return view('app/home');
    }
    public function homeUser(): string
    {
        return view('app/homeUser');
    }

    public function index()
    {
        $roleParam = (string) ($this->request->getGet('role') ?? '');
        $selectedRole = ctype_digit($roleParam) ? $roleParam : ''; // güvenli sayısal kontrol

        // Kullanıcılar
        $userM = new UserModel();
        $userM->select('users.id, users.name, users.surname, users.mail, users.created_at')
            ->orderBy('users.id', 'DESC');

        if ($selectedRole !== '') {
            $userM->join('user_roles ur', 'ur.user_id = users.id', 'inner')
                ->where('ur.role_id', (int) $selectedRole)
                ->groupBy('users.id'); // aynı kullanıcıya birden fazla rol varsa duplicates engelle
        }

        $users = $userM->findAll();

        // Tüm roller (tablar + modal)
        $roleM = new RolesModel();
        $roles = $roleM->select('id, role_name')
            ->orderBy('role_name', 'ASC')
            ->findAll();

        // Ekranda görünen kullanıcılar için roller (daha az veri)
        $userIds = array_column($users, 'id');
        $userRoles = $this->getRolesGroupedByUser($userIds);

        return view('app/users', [
            'users' => $users,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'selectedRole' => $selectedRole,
        ]);
    }

    /**
     * @param int[] $userIds Sadece bu kullanıcıların rollerini getir (boşsa hepsi)
     */
    private function getRolesGroupedByUser(array $userIds = []): array
    {
        $pivot = new UserRoleModel();

        $builder = $pivot->select('user_roles.user_id, roles.id as role_id, roles.role_name')
            ->join('roles', 'roles.id = user_roles.role_id', 'left')
            ->orderBy('user_roles.user_id', 'ASC');

        if (!empty($userIds)) {
            $builder->whereIn('user_roles.user_id', $userIds);
        }

        $rows = $builder->findAll();

        $map = [];
        foreach ($rows as $row) {
            if (empty($row['user_id']) || empty($row['role_id']) || empty($row['role_name'])) {
                continue;
            }
            $map[(int) $row['user_id']][] = [
                'id' => (int) $row['role_id'],
                'name' => $row['role_name'],
            ];
        }
        return $map;
    }
    // app/Controllers/Users/UsersController.php

    public function optionsAll() // GET /api/users/options
    {
        $userM = new UserModel();
        $rows = $userM->select('id, name, surname, mail')
            ->orderBy('name', 'ASC')
            ->findAll();

        // Select2/Choices için basit format
        $data = array_map(fn($r) => [
            'id' => (int) $r['id'],
            'text' => trim(($r['name'] ?? '') . ' ' . ($r['surname'] ?? '')),
            'email' => $r['mail'] ?? '',
        ], $rows);

        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }

    public function listByRole()
    {
        $roleId = (int) $this->request->getGet('role_id');
        $query = trim((string) $this->request->getGet('q'));

        $userModel = new UserModel();
        $builder = $userModel->select('users.id, users.name, users.surname, users.mail')
            ->join('user_roles ur', 'ur.user_id = users.id', 'inner')
            ->groupBy('users.id')
            ->orderBy('users.name', 'ASC');

        if ($roleId > 0) {
            $builder->where('ur.role_id', $roleId);
        }

        if ($query !== '') {
            $builder->groupStart()
                ->like('users.name', $query)
                ->orLike('users.surname', $query)
                ->orLike('users.mail', $query)
                ->groupEnd();
        }

        $rows = $builder->findAll();

        $users = array_map(fn($row) => [
            'id' => (int) $row['id'],
            'name' => trim(($row['name'] ?? '') . ' ' . ($row['surname'] ?? '')),
            'email' => $row['mail'] ?? '',
        ], $rows);

        return $this->response->setJSON([
            'success' => true,
            'data' => ['users' => $users],
        ]);
    }

}
