<?php
declare(strict_types=1);

namespace App\DTOs\Courses;

final class CreateCourseDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public string $startDate,           // 'YYYY-MM-DD'
        public ?string $endDate,            // 'YYYY-MM-DD' | null
        public bool $indefinite,            // true => end_date null
        /** @var int[] */
        public array $managerIds            // role_id=1 olmalı
    ) {}
}


