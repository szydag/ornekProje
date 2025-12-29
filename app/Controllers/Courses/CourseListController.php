<?php
declare(strict_types=1);

namespace App\Controllers\Courses;

use App\Controllers\BaseController;
use App\Services\Courses\CourseListService;
use App\DTOs\Courses\ListCoursesDTO;

class CourseListController extends BaseController
{
    private CourseListService $service;

    public function __construct()
    {
        $this->service = new CourseListService();
    }

    public function index()
    {
        $dto = ListCoursesDTO::fromRequest($this->request);

        $data = $this->service->listAll($dto);

        if ($this->request->isAJAX() || strpos($this->request->getHeaderLine('Accept'), 'application/json') !== false) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data['items']
            ]);
        }

        return view('app/course-list', [
            'courses' => $data['items'],
            'total' => $data['total']
        ]);
    }
}
