<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class FileDTO
{
    public function __construct(
        public int $id,
        public int $learning_material_id,
        public ?string $file_type,
        public ?string $name,
        public ?string $description,
        public ?string $created_at,
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            learning_material_id: (int) $row['learning_material_id'],
            file_type: isset($row['file_type']) ? (string) $row['file_type'] : null,
            name: $row['name'] ?? null,
            description: $row['description'] ?? null,
            created_at: $row['created_at'] ?? null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'learning_material_id' => $this->learning_material_id,
            'file_type' => $this->file_type,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
