<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class LearningMaterialTopDTO
{
    /** @param array<string,LearningMaterialTranslationDTO> $translations */
    public function __construct(
        public int $id,
        public int $content_type_id,
        public ?string $content_type_name,
        public ?string $first_language,
        public ?string $topics,
        public ?string $status,
        public array $translations, // ['tr'=>DTO, 'en'=>DTO, ...]
    ) {
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content_type_id' => $this->content_type_id,
            'content_type_name' => $this->content_type_name,
            'first_language' => $this->first_language,
            'topics' => $this->topics,
            'status' => $this->status,
            'translations' => array_map(fn($t) => $t->toArray(), $this->translations),
        ];
    }
}
