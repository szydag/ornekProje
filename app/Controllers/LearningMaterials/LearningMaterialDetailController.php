<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\DTOs\LearningMaterials\LearningMaterialDetailDTO;
use App\DTOs\LearningMaterials\LearningMaterialTranslationDTO;
use App\DTOs\LearningMaterials\AuthorDTO;
use App\DTOs\LearningMaterials\ApprovalDTO;
use App\DTOs\LearningMaterials\FileDTO;
use App\DTOs\LearningMaterials\ExtraInfoDTO;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Services\LearningMaterials\LearningMaterialDetailService;
use App\Services\LearningMaterials\LearningMaterialEditorService;
use App\Models\Users\InstitutionModel;
use App\Models\Users\TitleModel;
use App\Models\Users\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ContentWorkflow\LearningMaterialReviewerModel;
use App\Helpers\EncryptHelper;
use App\Services\ContentWorkflow\LearningMaterialWorkflowService;
use App\Services\ContentWorkflow\TransactionHistoryService;
use App\Support\LearningMaterialStatusFormatter;

final class LearningMaterialDetailController extends BaseController
{
    public function __construct(
        private LearningMaterialDetailService $service = new LearningMaterialDetailService(),
        private LearningMaterialsModel $materials = new LearningMaterialsModel(),
        private LearningMaterialReviewerModel $reviewers = new LearningMaterialReviewerModel(),
        private LearningMaterialWorkflowService $workflow = new LearningMaterialWorkflowService(),
        private TransactionHistoryService $transactionHistory = new TransactionHistoryService(),
        private LearningMaterialEditorService $editorService = new LearningMaterialEditorService(),
        private UserModel $userModel = new UserModel(),
        private TitleModel $titleModel = new TitleModel(),
        private InstitutionModel $institutionModel = new InstitutionModel(),

    ) {
    }


    public function detail(string $encryptedId)
    {
        $id = EncryptHelper::decrypt($encryptedId);

        if ($id === false || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw PageNotFoundException::forPageNotFound('Geçersiz içerik kimliği');
        }

        $learningMaterialId = (int) $id;

        try {
            $dto = $this->service->getDetail($learningMaterialId);
            $meta = $this->getContentMeta($learningMaterialId);

            if ($this->expectsJson()) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $dto->toArray(),
                ]);
            }

            $reviewerStats = $this->getReviewerStats($learningMaterialId);
            $assignedEditors = $this->editorService->listEditorsByContent($learningMaterialId);

            $roleIds = session()->get('role_ids') ?? [];
            $headerRoleId = (int) ($this->request->getHeaderLine('X-Role-Id') ?: 0);
            if ($headerRoleId > 0) {
                $roleIds[] = $headerRoleId;
            }
            $roleIds = array_unique(array_map('intval', $roleIds));

            $timeline = $this->transactionHistory->getTimeline($learningMaterialId, $roleIds);
            return view('app/material-detail', [
                'content' => $this->formatForView($dto, $meta, $reviewerStats, $timeline, $assignedEditors),
            ]);
        } catch (\Throwable $e) {
            if ($this->expectsJson()) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'error' => $e->getMessage(),
                ]);
            }

            throw PageNotFoundException::forPageNotFound($e->getMessage());
        }
    }

    private function expectsJson(): bool
    {
        if ($this->request->isAJAX()) {
            return true;
        }

        $accept = $this->request->getHeaderLine('Accept');
        return stripos($accept, 'application/json') !== false;
    }

    /**
     * @param array<string,mixed> $meta
     * @return array<string,mixed>
     */
    private function formatForView(LearningMaterialDetailDTO $dto, array $meta, array $reviewerStats = [], array $history = [], array $editors = []): array
    {
        $translations = $dto->top->translations;
        $primaryLang = $dto->top->first_language ?: 'tr';

        /** @var LearningMaterialTranslationDTO|null $primary */
        $primary = $translations[$primaryLang] ?? ($translations['tr'] ?? (reset($translations) ?: null));
        /** @var LearningMaterialTranslationDTO|null $tr */
        $tr = $translations['tr'] ?? null;
        /** @var LearningMaterialTranslationDTO|null $en */
        $en = $translations['en'] ?? null;

        $titleTr = $tr?->title;
        $titleEn = $en?->title;
        $fallbackTitle = $primary?->title ?? ('Başlıksız İçerik #' . $dto->top->id);
        $courseId = isset($meta['course_id']) ? (int) $meta['course_id'] : null;
        $courseTitle = $meta['course_title'] ?? null;

        [$userMeta, $titleMap, $institutionMap] = $this->prepareAuthorMetadata($dto->authors);

        $statusCode = (string) ($meta['status'] ?? $dto->top->status ?? '');

        return [
            'id' => $dto->top->id,
            'title' => $titleTr ?? $fallbackTitle,
            'title_tr' => $titleTr ?? $fallbackTitle,
            'title_en' => $titleEn,
            'status' => $statusCode,
            'status_label' => LearningMaterialStatusFormatter::label($statusCode),
            'status_color' => LearningMaterialStatusFormatter::color($statusCode),
            'publication_type' => $dto->top->content_type_name,
            'primary_language' => $dto->top->first_language,
            'course' => [
                'id' => $courseId,
                'title' => $courseTitle,
            ],
            'topics' => $dto->top->topics,
            'keywords_tr' => $tr?->keywords,
            'keywords_en' => $en?->keywords,
            'abstract_tr' => $tr?->self_description,
            'abstract_en' => $en?->self_description,
            'created_at' => $meta['created_at'] ?? null,
            'authors' => array_map(
                fn(AuthorDTO $author) => $this->formatAuthor($author, $userMeta, $titleMap, $institutionMap),
                $dto->authors
            ),
            'files' => array_map([$this, 'formatFile'], $dto->files),
            'additional_info' => $this->formatExtra($dto->extraInfoByLang, $dto->approvals),
            'reviewers' => $reviewerStats,
            'history' => $history,
            'editors' => $this->formatEditors($editors),

        ];
    }

    /**
     * @param array<int,AuthorDTO> $authors
     * @return array{array<int,array<string,int|null>>, array<int,string>, array<int,string>}
     */
    private function prepareAuthorMetadata(array $authors): array
    {
        $userIds = [];
        $titleIds = [];
        $institutionIds = [];

        foreach ($authors as $author) {
            if ($author->user_id) {
                $userIds[] = (int) $author->user_id;
            }

            if ($author->title_id) {
                $titleIds[] = (int) $author->title_id;
            }

            if ($author->institution_id) {
                $institutionIds[] = (int) $author->institution_id;
            }
        }

        if (empty($authors)) {
            return [[], [], []];
        }

        $userMeta = [];

        $userIds = array_values(array_unique(array_filter($userIds)));
        if (!empty($userIds)) {
            $rows = $this->userModel
                ->select('id, title_id, institution_id')
                ->whereIn('id', $userIds)
                ->findAll();

            foreach ($rows as $row) {
                $userId = isset($row['id']) ? (int) $row['id'] : 0;
                if ($userId <= 0) {
                    continue;
                }

                $titleId = isset($row['title_id']) ? (int) $row['title_id'] : null;
                $institutionId = isset($row['institution_id']) ? (int) $row['institution_id'] : null;

                $userMeta[$userId] = [
                    'title_id' => $titleId,
                    'institution_id' => $institutionId,
                ];

                if ($titleId) {
                    $titleIds[] = $titleId;
                }

                if ($institutionId) {
                    $institutionIds[] = $institutionId;
                }
            }
        }

        $titleMap = [];
        $titleIds = array_values(array_unique(array_filter($titleIds)));
        if (!empty($titleIds)) {
            $titleRows = $this->titleModel
                ->select('id, name')
                ->whereIn('id', $titleIds)
                ->findAll();

            foreach ($titleRows as $row) {
                $id = isset($row['id']) ? (int) $row['id'] : 0;
                if ($id <= 0) {
                    continue;
                }
                $titleMap[$id] = $row['name'] ?? '';
            }
        }

        $institutionMap = [];
        $institutionIds = array_values(array_unique(array_filter($institutionIds)));
        if (!empty($institutionIds)) {
            $institutionRows = $this->institutionModel
                ->select('id, name')
                ->whereIn('id', $institutionIds)
                ->findAll();

            foreach ($institutionRows as $row) {
                $id = isset($row['id']) ? (int) $row['id'] : 0;
                if ($id <= 0) {
                    continue;
                }
                $institutionMap[$id] = $row['name'] ?? '';
            }
        }

        return [$userMeta, $titleMap, $institutionMap];
    }

    private function formatAuthor(AuthorDTO $author, array $userMeta, array $titleMap, array $institutionMap): array
    {
        $fullName = trim(($author->name ?? '') . ' ' . ($author->surname ?? ''));
        $user = null;

        if ($author->user_id && isset($userMeta[$author->user_id])) {
            $user = $userMeta[$author->user_id];
        }

        $institutionId = $author->institution_id ?? ($user['institution_id'] ?? null);
        $institutionName = null;

        if (is_string($author->affiliation) && trim($author->affiliation) !== '') {
            $institutionName = trim($author->affiliation);
        } elseif ($institutionId && isset($institutionMap[$institutionId])) {
            $institutionName = trim((string) $institutionMap[$institutionId]);
        }

        if ($institutionName === null || $institutionName === '') {
            $institutionName = 'Belirtilmedi';
        }

        return [
            'id' => $author->id,
            'name' => $fullName !== '' ? $fullName : ($author->name ?? 'Bilinmiyor'),
            'title' => $this->resolveAuthorTitle($author, $user, $titleMap),
            'institution' => $institutionName,
            'affiliation' => $institutionName,
            'is_corresponding' => $this->isCorrespondingAuthor($author),
        ];
    }

    private function resolveAuthorTitle(AuthorDTO $author, ?array $user, array $titleMap): string
    {
        $titleId = $author->title_id ?? ($user['title_id'] ?? null);

        if ($titleId && isset($titleMap[$titleId])) {
            $resolved = trim((string) $titleMap[$titleId]);
            if ($resolved !== '') {
                return $resolved;
            }
        }

        if (!empty($author->type)) {
            return ucfirst((string) $author->type);
        }

        return 'Belirtilmedi';
    }

    private function isCorrespondingAuthor(AuthorDTO $author): bool
    {
        if ($author->is_corresponding !== null) {
            return (bool) $author->is_corresponding;
        }

        $type = strtolower((string) ($author->type ?? ''));
        return in_array($type, ['corresponding', 'responsible', 'sorumlu'], true);
    }

    private function formatFile(FileDTO $file): array
    {
        $info = $this->resolveFileInfo($file);

        return [
            'id' => $file->id,
            'content_id' => $file->learning_material_id,
            'name' => $info['display_name'],
            'type' => $this->fileTypeLabel($file->file_type),
            'mime' => $info['mime'],
            'extension' => $info['extension'],
            'size' => $info['size_human'] ?? ($file->description ?? 'Belirtilmedi'),
            'size_bytes' => $info['size_bytes'],
            'created_at' => $file->created_at,
            'download_url' => base_url('download/' . $file->id),
            'preview_url' => base_url('preview/' . $file->id),
        ];
    }

    private function fileTypeLabel($type): string
    {
        $map = [
            'tam_metin' => 'Tam Metin',
            'telif_hakki' => 'Telif Hakkı',
            'ek_dosya' => 'Ek Dosya',
        ];

        $legacy = [
            '1' => 'PDF',
            '2' => 'Word',
            '3' => 'Excel',
            '4' => 'PowerPoint',
        ];

        if ($type === null) {
            return 'Belirtilmedi';
        }

        $key = is_string($type) ? trim($type) : (string) $type;
        if ($key === '') {
            return 'Belirtilmedi';
        }

        if (isset($map[$key])) {
            return $map[$key];
        }

        return $legacy[$key] ?? 'Belirtilmedi';
    }

    /**
     * @return array{
     *     display_name:string,
     *     mime:?string,
     *     extension:?string,
     *     size_bytes:?int,
     *     size_human:?string,
     *     absolute_path:?string
     * }
     */
    private function resolveFileInfo(FileDTO $file): array
    {
        $displayName = $file->name ?? ('Dosya #' . $file->id);
        $extension = strtolower((string) pathinfo($displayName, PATHINFO_EXTENSION));

        $baseDir = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'contents' . DIRECTORY_SEPARATOR . $file->learning_material_id . DIRECTORY_SEPARATOR;
        if (!is_dir($baseDir)) {
            return [
                'display_name' => $displayName,
                'mime' => $this->guessMimeFromExtension($extension) ?? null,
                'extension' => $extension ?: null,
                'size_bytes' => null,
                'size_human' => null,
                'absolute_path' => null,
            ];
        }
        $absolute = null;

        if (is_file($baseDir . $displayName)) {
            $absolute = $baseDir . $displayName;
        } else {
            $candidates = [];
            if ($displayName !== '') {
                $candidates = glob($baseDir . '*' . $displayName);
                if (empty($candidates)) {
                    $filenameNoExt = (string) pathinfo($displayName, PATHINFO_FILENAME);
                    if ($filenameNoExt !== '') {
                        $candidates = glob($baseDir . $filenameNoExt . '.*') ?: [];
                    }
                }
                if (empty($candidates)) {
                    $candidates = glob($baseDir . '*' . $file->id . '*') ?: [];
                }
            }

            if (!empty($candidates)) {
                $absolute = $candidates[0];
                $displayName = basename($absolute);
                $extension = strtolower((string) pathinfo($absolute, PATHINFO_EXTENSION));
            }
        }

        $mime = null;
        $size = null;

        if ($absolute && is_file($absolute)) {
            $size = filesize($absolute) ?: null;
            $mime = @mime_content_type($absolute) ?: null;
        }

        if (!$mime && $extension) {
            $mime = $this->guessMimeFromExtension($extension);
        }

        return [
            'display_name' => $displayName,
            'mime' => $mime,
            'extension' => $extension ?: null,
            'size_bytes' => $size,
            'size_human' => $size !== null ? $this->formatBytes($size) : null,
            'absolute_path' => $absolute,
        ];
    }

    private function guessMimeFromExtension(string $extension): ?string
    {
        $map = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'csv' => 'text/csv',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        $key = strtolower($extension);
        return $map[$key] ?? null;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $power = floor(($bytes ? log($bytes) : 0) / log(1024));
        $power = min($power, count($units) - 1);

        $bytes /= (1024 ** $power);
        return round($bytes, $precision) . ' ' . $units[$power];
    }

    /**
     * @param array<int,array<string,mixed>> $editors
     * @return array<int,array<string,mixed>>
     */
    private function formatEditors(array $editors): array
    {
        if (empty($editors)) {
            return [];
        }

        return array_map(static function (array $row): array {
            $email = (string) ($row['email'] ?? '');
            $assignedAt = $row['assigned_at'] ?? null;
            $isRegistered = !empty($row['is_registered']);
            $displayName = $row['registered_name'] ?? null;

            return [
                'email' => $email,
                'assigned_at' => $assignedAt,
                'is_registered' => $isRegistered,
                'display_name' => $displayName,
            ];
        }, $editors);
    }

    /**
     * @param array<string,ExtraInfoDTO> $extraByLang
     * @param ApprovalDTO|null $approvals
     * @return array<string,mixed>
     */
    private function formatExtra(array $extraByLang, ?ApprovalDTO $approvals = null): array
    {
        /** @var ExtraInfoDTO|null $tr */
        $tr = $extraByLang['tr'] ?? null;
        /** @var ExtraInfoDTO|null $en */
        $en = $extraByLang['en'] ?? null;

        return [
            'project_number' => $tr?->project_number,
            'ethics_statement_tr' => $tr?->ethics_declaration,
            'supporting_institution_tr' => $tr?->supporting_institution,
            'acknowledgments_tr' => $tr?->thanks_description,
            'ethics_statement_en' => $en?->ethics_declaration,
            'supporting_institution_en' => $en?->supporting_institution,
            'acknowledgments_en' => $en?->thanks_description,
            'editor_notes' => $approvals?->description,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function getContentMeta(int $id): array
    {
        return $this->materials
            ->select('learning_materials.status, learning_materials.created_at, learning_materials.course_id, e.title AS course_title')
            ->join('courses e', 'e.id = learning_materials.course_id', 'left')
            ->where('learning_materials.id', $id)
            ->first() ?: [];
    }

    /**
     * @return array{total:int,pending:int}
     */
    private function getReviewerStats(int $learningMaterialId): array
    {
        $total = (clone $this->reviewers)
            ->where('learning_material_id', $learningMaterialId)
            ->countAllResults();

        $pending = (clone $this->reviewers)
            ->where('learning_material_id', $learningMaterialId)
            ->where('decision_code', null)
            ->countAllResults();

        return [
            'total' => $total,
            'pending' => $pending,
        ];
    }
}
