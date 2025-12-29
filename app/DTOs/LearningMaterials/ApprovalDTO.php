<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class ApprovalDTO
{
    public function __construct(
        public ?string $rules_ok = null,
        public ?string $all_authors_ok = null,
        public ?string $description = null,
    ) {
    }

    /** @return array<string,string|null> */
    public function toArray(): array
    {
        return [
            'rules_ok' => $this->rules_ok,
            'all_authors_ok' => $this->all_authors_ok,
            'description' => $this->description,
        ];
    }
}
