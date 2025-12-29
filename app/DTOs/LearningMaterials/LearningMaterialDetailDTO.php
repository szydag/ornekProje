<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

final class LearningMaterialDetailDTO
{
    /** @param AuthorDTO[] $authors
     *  @param FileDTO[]   $files
     *  @param array<string,ExtraInfoDTO> $extraInfoByLang
     */
    public function __construct(
        public LearningMaterialTopDTO $top,
        public array $authors,
        public array $files,
        public array $extraInfoByLang,
        public ?ApprovalDTO $approvals = null,
    ) {
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'top' => $this->top->toArray(),
            'authors' => array_map(fn($a) => $a->toArray(), $this->authors),
            'files' => array_map(fn($f) => $f->toArray(), $this->files),
            'extra' => array_map(fn($e) => $e->toArray(), $this->extraInfoByLang),
        ];
    }
}
