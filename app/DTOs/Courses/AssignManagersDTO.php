<?php
declare(strict_types=1);

namespace App\DTOs\Courses;

final class AssignManagersDTO
{
    /**
     * @param int[] $managerIds
     */
    public function __construct(
        public int $courseId,
        public array $managerIds
    ) {}
}
