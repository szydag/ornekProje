<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final readonly class LearningMaterialTopDTO
{
    public function __construct(
        public int $id,
        public int $contentTypeId,
        public ?string $contentTypeName,
        public string $firstLanguage,
        public ?string $topics,
        public string $status,
        public array $translations = [],
    ) {}
}
