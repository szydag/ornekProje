<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users\UserModel;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            $session->remove('roles');
            return;
        }

        $userModel = new UserModel();
        $roles = $userModel->getUserRoleIn($userId);

        session()->set('role_ids', array_map('intval', array_column($roles, 'role_id')));
        session()->set('role_names', array_column($roles, 'role_name'));

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
