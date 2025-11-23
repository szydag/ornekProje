<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final readonly class LearningMaterialDetailDTO
{
    public function __construct(
        public LearningMaterialTopDTO $top,
        public array $authors = [],
        public array $files = [],
        public array $extraInfo = [],
    ) {}
}



