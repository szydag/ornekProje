<?php
declare(strict_types=1);

namespace App\Controllers\Courses;

use App\Controllers\BaseController;
use App\DTOs\Courses\CreateCourseDTO;
use App\DTOs\Courses\AssignManagersDTO;
use App\Services\Courses\CourseService;
use CodeIgniter\HTTP\ResponseInterface;

class CoursesController extends BaseController
{
    public function __construct(
        private CourseService $service = new CourseService()
    ) {
    }

    public function create(): ResponseInterface
    {
        try {
            $dto = CreateCourseDTO::fromRequest($this->request);
            $result = $this->service->create($dto);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kurs başarıyla oluşturuldu.',
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[CoursesController] Error creating course: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kurs oluşturulurken bir hata oluştu: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function update(int $courseId): ResponseInterface
    {
        try {
            // Get data from JSON body
            $data = $this->request->getJSON(true);

            $result = $this->service->update($courseId, $data);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kurs başarıyla güncellendi.',
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kurs güncellenirken bir hata oluştu.',
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $e) {
            log_message('error', '[CoursesController] Error updating course: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kurs güncellenirken bir hata oluştu: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function assignManagers(int $courseId): ResponseInterface
    {
        try {
            $dto = AssignManagersDTO::fromRequest($this->request);
            // Ensure courseId from URL matches DTO if needed, or just use URL part
            $dto->courseId = $courseId;

            $result = $this->service->assignManagers($dto);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Yöneticiler başarıyla atandı.',
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[CoursesController] Error assigning managers: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Yöneticiler atanırken bir hata oluştu: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
