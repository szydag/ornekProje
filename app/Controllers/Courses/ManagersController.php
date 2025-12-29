<?php
declare(strict_types=1);

namespace App\Controllers\Courses;

use App\Controllers\BaseController;
use App\Models\Roles\UserRoleModel;
use CodeIgniter\HTTP\ResponseInterface;

class ManagersController extends BaseController
{
    public function __construct(
        private UserRoleModel $userRoleModel = new UserRoleModel()
    ) {
    }

    public function index(): ResponseInterface
    {
        try {
            // role_id = 2 is manager role according to CourseService
            $managers = $this->userRoleModel->getManagers(2);

            return $this->response->setJSON([
                'success' => true,
                'data' => $managers,
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ManagersController] Error fetching managers: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Yöneticiler yüklenirken bir hata oluştu.',
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
