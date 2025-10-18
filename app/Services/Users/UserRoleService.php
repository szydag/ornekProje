<?php
// app/Services/Users/UserRoleService.php
namespace App\Services\Users;

use App\DTOs\Users\AssignRoleDTO;
use App\Models\Roles\UserRoleModel;
use App\Models\Roles\RolesModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UserRoleService
{
    public function assign(AssignRoleDTO $dto): array
    {
        if ($errs = $dto->validate()) {
            return ['success' => false, 'errors' => $errs];
        }

        $pivot = new UserRoleModel();
        $roleM = new RolesModel();

        $role = $roleM->find($dto->role_id);
        if (!$role) {
            return ['success' => false, 'errors' => ['role_id' => 'Rol bulunamadı']];
        }

        $exists = $pivot->where('user_id', $dto->user_id)->where('role_id', $dto->role_id)->first();
        if ($exists) {
            return ['success' => true, 'message' => 'Rol zaten atanmış.', 'role' => $role, 'duplicate' => true];
        }

        try {
            $pivot->insert([
                'user_id'     => $dto->user_id,
                'role_id'     => $dto->role_id,
                'assigned_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (DatabaseException $e) {
            return ['success' => false, 'errors' => ['db' => $e->getMessage()]];
        }

        return ['success' => true, 'message' => 'Rol atandı.', 'role' => $role];
    }
}
