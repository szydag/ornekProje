<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

/**
 * Tüm edit payload'unu tek yerde toplar.
 * Parçalar (step1..step5) opsiyoneldir — kısmi güncelleme destekler.
 */
final class LearningMaterialUpdateDTO
{
    /** @param array<int,array<string,mixed>> $authors */
    /** @param array<int,array<string,mixed>> $extraRows */
    /** @param array<int,int> $delete_file_ids */
    /** @param array<int,array<string,mixed>> $add_files */
    public function __construct(
        public readonly ?array $step1,
        public readonly ?array $authors,
        public readonly ?array $add_files,
        public readonly ?array $delete_file_ids,
        public readonly ?array $extraRows,
        public readonly ?string $project_number,
        public readonly ?array $approvals
    ) {
    }

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();

        // step1: Step1DTO ile tam paket gelebilir
        $step1 = (isset($p['step1']) && is_array($p['step1']))
            ? Step1DTO::fromRequest(new class ($p['step1']) extends IncomingRequest {
            public function __construct(private array $arr)
            {
            }
            public function getJSON(bool $assoc = false, int $depth = 512, int $options = 0)
            {
                return $this->arr;
            }

            public function getPost($index = null, $filter = null, $flags = null)
            {
                return $this->arr;
            }
            })->toArray()
            : null;

        // step2: authors[] upsert / delete destekli
        $authors = null;
        if (isset($p['step2']['authors']) && is_array($p['step2']['authors'])) {
            $authors = [];
            foreach ($p['step2']['authors'] as $row) {
                $row = is_array($row) ? $row : [];
                $dto = Step2AuthorDTO::fromArray($row);
                $clean = $dto->validate();
                if (isset($row['id'])) {
                    $clean['id'] = (int) $row['id'];
                }
                if (!empty($row['delete'])) {
                    $clean['_delete'] = (bool) $row['delete'];
                }
                $authors[] = $clean;
            }
        }

        // step3: dosyalar — yeni eklenenler + silinecek ID listesi
        $addFiles = null;
        if (isset($p['step3']['add_files']) && is_array($p['step3']['add_files'])) {
            $addFiles = [];
            foreach ($p['step3']['add_files'] as $row) {
                $row = is_array($row) ? $row : [];
                $clean = (new Step3FileDTO(
                    role: $row['role'] ?? null,
                    name: trim((string) ($row['name'] ?? '')),
                    stored_path: trim((string) ($row['stored_path'] ?? '')),
                    mime: $row['mime'] ?? null,
                    size: (int) ($row['size'] ?? 0),
                    is_primary: (bool) ($row['is_primary'] ?? false),
                    language: $row['language'] ?? null,
                    notes: $row['notes'] ?? ($row['description'] ?? null),
                    temp_id: $row['temp_id'] ?? null,
                    file_type: $row['file_type'] ?? null
                ))->validateRow();
                $addFiles[] = $clean;
            }
        }

        $deleteFileIds = null;
        if (isset($p['step3']['delete_file_ids']) && is_array($p['step3']['delete_file_ids'])) {
            $deleteFileIds = array_values(array_map('intval', $p['step3']['delete_file_ids']));
        }

        // step4: ekstra bilgiler (TR/EN satırları)
        $extraRows = null;
        $projectNumber = null;
        if (isset($p['step4']) && is_array($p['step4'])) {
            $projectNumber = $p['step4']['project_number'] ?? null;
            if (isset($p['step4']['rows']) && is_array($p['step4']['rows'])) {
                $extraRows = [];
                foreach ($p['step4']['rows'] as $row) {
                    $row = is_array($row) ? $row : [];
                    $clean = [
                        'lang' => isset($row['lang']) ? (string) $row['lang'] : 'tr',
                        'ethics_declaration' => $row['ethics_declaration'] ?? null,
                        'supporting_institution' => $row['supporting_institution'] ?? null,
                        'thanks_description' => $row['thanks_description'] ?? null,
                        'project_number' => $row['project_number'] ?? null,
                    ];
                    if (isset($row['id'])) {
                        $clean['id'] = (int) $row['id'];
                    }
                    if (!empty($row['_delete'])) {
                        $clean['_delete'] = (bool) $row['_delete'];
                    }
                    $extraRows[] = $clean;
                }
            }
        }

        // step5: approvals
        $approvals = null;
        if (isset($p['step5']) && is_array($p['step5'])) {
            $tmpReq = new class ($p['step5']) extends IncomingRequest {
                public function __construct(private array $arr)
                {
                }
                public function getJSON(?bool $assoc = null, int $depth = 512, int $options = 0)
                {
                    return $this->arr;
                }
                public function getPost($index = null, $filter = null, $flags = null)
                {
                    return $this->arr;
                }
            };
            $approvals = Step5DTO::fromRequest($tmpReq)->toArray();
        }

        return new self(
            step1: $step1,
            authors: $authors,
            add_files: $addFiles,
            delete_file_ids: $deleteFileIds,
            extraRows: $extraRows,
            project_number: $projectNumber,
            approvals: $approvals
        );
    }

    /**
     * Temel doğrulama: en az bir alan gelmeli.
     */
    public function assertNotEmpty(): void
    {
        if (
            $this->step1 === null
            && $this->authors === null
            && $this->add_files === null
            && $this->delete_file_ids === null
            && $this->extraRows === null
            && $this->project_number === null
            && $this->approvals === null
        ) {
            throw new DtoValidationException('Güncelleme için en az bir alan göndermelisiniz.');
        }
    }
}
