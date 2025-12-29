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
        public array $managerIds            // role_id=2 olmalı (Service'de role_id=2 denmiş)
    ) {
    }

    public static function fromRequest(\CodeIgniter\HTTP\IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();

        return new self(
            (string) ($p['title'] ?? ''),
            (string) ($p['description'] ?? ''),
            (string) ($p['start_date'] ?? ''),
            $p['end_date'] ?? null,
            (bool) ($p['unlimited'] ?? false),
            (array) ($p['manager_ids'] ?? [])
        );
    }
}


