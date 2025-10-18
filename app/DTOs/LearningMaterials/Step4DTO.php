<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class Step4DTO
{
    public function __construct(
        public readonly ?string $project_number,
        /** @var array<int,array<string,mixed>> */
        public readonly array $rows
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();
        return new self(
            $p['project_number'] ?? null,
            (array)($p['rows'] ?? [])
        );
    }

    /** @return array<string,mixed> */
    public function validate(): array
    {
        if (empty($this->rows)) {
            throw new DtoValidationException('Step4 doğrulama hatası', [
                'languages' => 'En az bir dil seçiniz (tr veya en).'
            ]);
        }

        return [
            'project_number' => $this->project_number,
            'rows'           => $this->rows,
        ];
    }
}
