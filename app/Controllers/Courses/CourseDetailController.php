<?php
declare(strict_types=1);

namespace App\Controllers\Courses;

use App\Controllers\BaseController;
use App\Services\Courses\CourseDetailService;

class CourseDetailController extends BaseController
{
    private CourseDetailService $service;

    public function __construct()
    {
        $this->service = new CourseDetailService();
    }

    public function detail($courseId)
    {
        // Hem numerik hem de şifrelenmiş ID desteği
        if (!is_numeric($courseId)) {
            $decrypted = \App\Helpers\EncryptHelper::decrypt((string) $courseId);
            if ($decrypted !== false && is_numeric($decrypted)) {
                $courseId = (int) $decrypted;
            } else {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Geçersiz kurs kimliği.');
            }
        } else {
            $courseId = (int) $courseId;
        }

        $data = $this->service->getDetail($courseId);

        if (!$data) {
            if ($this->request->isAJAX() || str_contains($this->request->getHeaderLine('Accept'), 'json')) {
                return $this->response->setJSON(['success' => false, 'message' => 'Kurs bulunamadı.'])->setStatusCode(404);
            }
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kurs bulunamadı.');
        }

        if ($this->request->isAJAX() || str_contains($this->request->getHeaderLine('Accept'), 'json')) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
        }

        return view('app/course-detail', [
            'course' => $data
        ]);
    }
}
