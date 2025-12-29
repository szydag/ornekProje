<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class AuthorDTO
{
    public function __construct(
        public int $id,
        public int $learning_material_id,
        public ?int $user_id,
        public ?string $type,
        public ?int $order_number,
        public ?string $orcid,
        public ?string $name,
        public ?string $surname,
        public ?string $mail,
        public ?string $phone,
        public ?int $country_id,
        public ?string $city,
        public ?int $title_id,
        public ?string $affiliation,
        public ?int $institution_id,
        public ?bool $is_corresponding,
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            learning_material_id: (int) $row['learning_material_id'],
            user_id: isset($row['user_id']) ? (int) $row['user_id'] : null,
            type: $row['type'] ?? null,
            order_number: isset($row['order_number']) ? (int) $row['order_number'] : null,
            orcid: $row['orcid'] ?? null,
            name: $row['name'] ?? null,
            surname: $row['surname'] ?? null,
            mail: $row['mail'] ?? null,
            phone: $row['phone'] ?? null,
            country_id: isset($row['country_id']) ? (int) $row['country_id'] : null,
            city: $row['city'] ?? null,
            title_id: isset($row['title_id']) ? (int) $row['title_id'] : null,
            affiliation: $row['affiliation'] ?? null,
            institution_id: isset($row['institution_id']) ? (int) $row['institution_id'] : null,
            is_corresponding: isset($row['is_corresponding']) ? (bool) $row['is_corresponding'] : null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        $fullName = trim(($this->name ?? '') . ' ' . ($this->surname ?? '')) ?: null;
        return [
            'id' => $this->id,
            'learning_material_id' => $this->learning_material_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'order_number' => $this->order_number,
            'orcid' => $this->orcid,
            'name' => $this->name,
            'surname' => $this->surname,
            'full_name' => $fullName,
            'mail' => $this->mail,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'city' => $this->city,
            'title_id' => $this->title_id,
            'affiliation' => $this->affiliation,
            'institution_id' => $this->institution_id,
            'is_corresponding' => $this->is_corresponding,
        ];
    }
}
