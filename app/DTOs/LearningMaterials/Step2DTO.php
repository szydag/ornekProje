<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class Step2DTO
{
    /** @param array<int,Step2AuthorDTO> $authors */
    public function __construct(
        public readonly array $authors
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();
        $authors = [];
        foreach ((array)($p['authors'] ?? []) as $row) {
            $authors[] = Step2AuthorDTO::fromArray($row);
        }
        return new self($authors);
    }

    /** @return array<string,mixed> */
    public function validate(): array
    {
        if (empty($this->authors)) {
            throw new DtoValidationException('Step2 doğrulama hatası', [
                'authors' => 'En az bir yazar girilmelidir.'
            ]);
        }
        return [
            'authors' => array_map(fn($a) => $a->validate(), $this->authors),
        ];
    }
}
