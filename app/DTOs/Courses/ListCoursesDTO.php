<?php
declare(strict_types=1);

namespace App\DTOs\Courses;

use CodeIgniter\HTTP\IncomingRequest;

final class ListCoursesDTO
{
    public function __construct(
        public readonly ?int $limit = null,      // null => limitsiz
        public readonly ?int $offset = null,     // null => 0
        public readonly string $orderBy = 'created_at',
        public readonly string $orderDir = 'DESC' // ASC|DESC
    ) {
    }

    public static function fromRequest(IncomingRequest $r): self
    {
        // GET veya JSON gövdesinden oku
        $p = $r->getGet();

        if (empty($p)) {
            $p = $r->getJSON(true) ?: $r->getPost();
        }

        if (!is_array($p)) {
            $p = [];
        }


        $limit = isset($p['limit']) ? max(1, (int) $p['limit']) : null;
        $offset = isset($p['offset']) ? max(0, (int) $p['offset']) : null;

        $orderBy = (string) ($p['order_by'] ?? 'created_at');
        $orderDir = strtoupper((string) ($p['order_dir'] ?? 'DESC'));
        if (!in_array($orderDir, ['ASC', 'DESC'], true)) {
            $orderDir = 'DESC';
        }

        // Güvenli kolon listesi (gerekirse genişlet)
        $whitelist = ['id', 'title', 'status', 'start_date', 'end_date', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $whitelist, true)) {
            $orderBy = 'created_at';
        }

        return new self($limit, $offset, $orderBy, $orderDir);
    }
}


