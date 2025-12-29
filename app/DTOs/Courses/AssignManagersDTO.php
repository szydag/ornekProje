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
    ) {
    }

    public static function fromRequest(\CodeIgniter\HTTP\IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();

        return new self(
            (int) ($p['course_id'] ?? 0),
            (array) ($p['manager_ids'] ?? [])
        );
    }
}
