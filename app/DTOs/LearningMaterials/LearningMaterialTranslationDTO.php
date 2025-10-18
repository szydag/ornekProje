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
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            lang: (string)($row['lang'] ?? ''),
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
            'lang'             => $this->lang,
            'title'            => $this->title,
            'short_title'      => $this->short_title,
            'keywords'         => $this->keywords,
            'self_description' => $this->self_description,
        ];
    }
}

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
    ) {}

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'id'                  => $this->id,
            'content_type_id'     => $this->content_type_id,
            'content_type_name'   => $this->content_type_name,
            'first_language'      => $this->first_language,
            'topics'              => $this->topics,
            'status'              => $this->status,
            'translations'        => array_map(fn($t) => $t->toArray(), $this->translations),
        ];
    }
}

final class ContributorDTO
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
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int)$row['id'],
            learning_material_id: (int)$row['learning_material_id'],
            user_id: isset($row['user_id']) ? (int)$row['user_id'] : null,
            type: $row['type'] ?? null,
            order_number: isset($row['order_number']) ? (int)$row['order_number'] : null,
            orcid: $row['orcid'] ?? null,
            name: $row['name'] ?? null,
            surname: $row['surname'] ?? null,
            mail: $row['mail'] ?? null,
            phone: $row['phone'] ?? null,
            country_id: isset($row['country_id']) ? (int)$row['country_id'] : null,
            city: $row['city'] ?? null,
            title_id: isset($row['title_id']) ? (int)$row['title_id'] : null,
            affiliation: $row['affiliation'] ?? null,
            institution_id: isset($row['institution_id']) ? (int)$row['institution_id'] : null,
            is_corresponding: isset($row['is_corresponding']) ? (bool)$row['is_corresponding'] : null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        $fullName = trim(($this->name ?? '') . ' ' . ($this->surname ?? '')) ?: null;
        return [
            'id'                 => $this->id,
            'learning_material_id' => $this->learning_material_id,
            'user_id'            => $this->user_id,
            'type'        => $this->type,
            'order_number'=> $this->order_number,
            'orcid'       => $this->orcid,
            'name'        => $this->name,
            'surname'     => $this->surname,
            'full_name'   => $fullName,
            'mail'        => $this->mail,
            'phone'       => $this->phone,
            'country_id'  => $this->country_id,
            'city'        => $this->city,
            'title_id'    => $this->title_id,
            'affiliation' => $this->affiliation,
            'institution_id' => $this->institution_id,
            'is_corresponding' => $this->is_corresponding,
        ];
    }
}

final class FileDTO
{
    public function __construct(
        public int $id,
        public int $learning_material_id,
        public ?string $file_type,
        public ?string $name,
        public ?string $description,
        public ?string $created_at,
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int)$row['id'],
            learning_material_id: (int)$row['learning_material_id'],
            file_type: isset($row['file_type']) ? (string)$row['file_type'] : null,
            name: $row['name'] ?? null,
            description: $row['description'] ?? null,
            created_at: $row['created_at'] ?? null,
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'id'                   => $this->id,
            'learning_material_id' => $this->learning_material_id,
            'file_type'            => $this->file_type,
            'name'        => $this->name,
            'description' => $this->description,
            'created_at'  => $this->created_at,
        ];
    }
}

final class ExtraInfoDTO
{
    public function __construct(
        public string $lang,
        public ?string $project_number,
        public ?string $ethics_declaration,
        public ?string $supporting_institution,
        public ?string $thanks_description,
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            lang: (string)($row['lang'] ?? ''),
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
            'lang'                   => $this->lang,
            'project_number'         => $this->project_number,
            'ethics_declaration'     => $this->ethics_declaration,
            'supporting_institution' => $this->supporting_institution,
            'thanks_description'     => $this->thanks_description,
        ];
    }
}

final class LearningMaterialDetailDTO
{
    /** @param ContributorDTO[] $contributors
     *  @param FileDTO[]   $files
     *  @param array<string,ExtraInfoDTO> $extraInfoByLang
     */
    public function __construct(
        public LearningMaterialTopDTO $top,
        public array $contributors,
        public array $files,
        public array $extraInfoByLang,
    ) {}

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'top'          => $this->top->toArray(),
            'contributors' => array_map(fn($a) => $a->toArray(), $this->contributors),
            'files'        => array_map(fn($f) => $f->toArray(), $this->files),
            'extra'    => array_map(fn($e) => $e->toArray(), $this->extraInfoByLang),
        ];
    }
}
