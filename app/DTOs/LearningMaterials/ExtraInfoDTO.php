<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class ExtraInfoDTO
{
    public function __construct(
        public string $lang,
        public ?string $project_number,
        public ?string $ethics_declaration,
        public ?string $supporting_institution,
        public ?string $thanks_description,
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            lang: (string) ($row['lang'] ?? ''),
            project_number: $row['project_number'] ?? null,
            ethics_declaration: $row['ethics_declaration'] ?? null,
            supporting_institution: $row['supporting_institution'] ?? null,
            thanks_description: $row['thanks_description'] ?? null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'lang' => $this->lang,
            'project_number' => $this->project_number,
            'ethics_declaration' => $this->ethics_declaration,
            'supporting_institution' => $this->supporting_institution,
            'thanks_description' => $this->thanks_description,
        ];
    }
}
