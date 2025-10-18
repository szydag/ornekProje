<?php
// app/Controllers/Users/RoleController.php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\AssignRoleDTO;
use App\Services\Users\UserRoleService;

class RoleController extends BaseController
{
    public function assign()
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        $dto     = AssignRoleDTO::fromArray($payload ?? []);
        $service = new UserRoleService();

        $result = $service->assign($dto);

        if (!($result['success'] ?? false)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors'  => $result['errors'] ?? ['unknown' => 'Bilinmeyen hata'],
            ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => $result['message'] ?? 'OK',
            'role'      => $result['role'] ?? null,
            'duplicate' => $result['duplicate'] ?? false,
        ]);
    }
}
