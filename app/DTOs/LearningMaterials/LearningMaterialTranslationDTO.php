<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class LearningMaterialTranslationDTO
{
    public function __construct(
        public string $lang,
        public ?string $title,
        public ?string $short_title,
        public ?string $keywords,
        public ?string $self_description,
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            lang: (string) ($row['lang'] ?? ''),
            title: $row['title'] ?? null,
            short_title: $row['short_title'] ?? null,
            keywords: $row['keywords'] ?? null,
            self_description: $row['self_description'] ?? null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'lang' => $this->lang,
            'title' => $this->title,
            'short_title' => $this->short_title,
            'keywords' => $this->keywords,
            'self_description' => $this->self_description,
        ];
    }
}
