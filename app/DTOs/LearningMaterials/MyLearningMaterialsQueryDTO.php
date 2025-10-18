<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;

final class MyLearningMaterialsQueryDTO
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $per_page = 20
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getGet();
        $page = max(1, (int)($p['page'] ?? 1));
        $per  = (int)($p['per_page'] ?? 20);
        // Güvenli sınırlar
        if ($per < 1 || $per > 100) { $per = 20; }

        return new self($page, $per);
    }
}
