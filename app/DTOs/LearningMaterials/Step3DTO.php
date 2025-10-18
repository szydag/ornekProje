<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class Step3DTO
{
    /** @param Step3FileDTO[] $files */
    public function __construct(
        public readonly array $files
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();
        $files = [];
        foreach ((array)($p['files'] ?? []) as $row) {
            $files[] = Step3FileDTO::fromArray($row);
        }
        return new self($files);
    }

    /** @return array<string,mixed> */
    public function validate(): array
    {
        if (empty($this->files)) {
            throw new DtoValidationException('Step3 doğrulama hatası', [
                'files' => 'En az bir dosya yüklenmelidir.'
            ]);
        }
        return [
            'files' => array_map(fn($f) => $f->validateRow(), $this->files),
        ];
    }
}
