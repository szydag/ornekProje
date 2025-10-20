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

    public function detail(int $courseId)
    {
        // Use direct course ID
        
        $data = $this->service->getDetail($courseId);
        
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kurs bulunamadı.');
        }
        
        return view('app/course-detail', [
            'course' => $data
        ]);
    }
}
