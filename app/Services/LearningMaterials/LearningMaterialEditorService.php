<?php
declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\LearningMaterials\MyLearningMaterialsQueryDTO;
use App\Models\LearningMaterials\LearningMaterialTranslationsModel;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\ContentWorkflow\LearningMaterialEditorModel;
use App\Models\Users\UserModel;
use App\Support\LearningMaterialStatusFormatter;

final class LearningMaterialEditorService
{
    public function __construct(
        private LearningMaterialEditorModel $editors = new LearningMaterialEditorModel(),
        private LearningMaterialsModel $learningMaterials = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translations = new LearningMaterialTranslationsModel(),
        private UserModel $users = new UserModel(),
    ) {
    }

    /**
     * @return array{message:string, alreadyAssigned:bool}
     */
    public function assignByEmail(int $learningMaterialId, string $email, int $assignedBy): array
    {
        if ($learningMaterialId <= 0) {
            throw new \InvalidArgumentException('Geçersiz içerik kimliği.');
        }

        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Geçerli bir e-posta adresi giriniz.');
        }

        $content = $this->learningMaterials->select('id')->find($learningMaterialId);
        if (!$content) {
            throw new \RuntimeException('İçerik bulunamadı.');
        }

        $now = date('Y-m-d H:i:s');
        $user = $this->users
            ->select('id')
            ->where('LOWER(mail)', $email)
            ->first();

        $editorId = $user ? (int) $user['id'] : null;

        $existing = $this->editors
            ->where('learning_material_id', $learningMaterialId)
            ->where('LOWER(editor_email)', $email)
            ->first();

        if ($existing) {
            $updateData = [];
            if (!empty($editorId) && (int) ($existing['editor_id'] ?? 0) !== $editorId) {
                $updateData['editor_id'] = $editorId;
            }
            if (!empty($updateData)) {
                $this->editors->update((int) $existing['id'], $updateData);
            }

            return [
                'message' => 'Bu e-posta adresi zaten içeriğe alan editörü olarak atanmış.',
                'alreadyAssigned' => true,
            ];
        }

        $this->editors->insert([
            'learning_material_id'   => $learningMaterialId,
            'editor_email' => $email,
            'editor_id'    => $editorId,
            'assigned_by'  => $assignedBy > 0 ? $assignedBy : null,
            'assigned_at'  => $now,
        ]);

        return [
            'message' => 'Alan editörü ataması başarıyla kaydedildi.',
            'alreadyAssigned' => false,
        ];
    }

    public function attachUserToAssignments(int $userId, string $email): void
    {
        $email = strtolower(trim($email));
        if ($userId <= 0 || $email === '') {
            return;
        }

        $builder = $this->editors->builder();
        $builder->where('editor_id', null);
        $builder->where('LOWER(editor_email)', $email);
        $builder->set('editor_id', $userId);
        $builder->update();
    }

    public function userHasAssignments(int $userId, string $email): bool
    {
        $email = strtolower(trim($email));
        if ($userId <= 0 && $email === '') {
            return false;
        }

        $builder = $this->editors->builder('learning_material_editors');
        $builder->select('id');
        $builder->limit(1);

        if ($userId > 0 && $email !== '') {
            $builder->groupStart()
                ->where('editor_id', $userId)
                ->orWhere('LOWER(editor_email)', $email)
                ->groupEnd();
        } elseif ($userId > 0) {
            $builder->where('editor_id', $userId);
        } else {
            $builder->where('LOWER(editor_email)', $email);
        }

        $row = $builder->get()->getFirstRow();
        return $row !== null;
    }

    /**
     * @return array{
     *   items: array<int, array<string,mixed>>,
     *   meta: array{total:int,page:int,per_page:int,total_pages:int}
     * }
     */
    public function listAssignedContents(int $userId, string $email, MyLearningMaterialsQueryDTO $dto): array
    {
        if ($userId <= 0 && $email === '') {
            return ['items' => [], 'meta' => $this->buildMeta(0, $dto)];
        }

        $email = strtolower(trim($email));

        $baseBuilder = $this->editors->builder('learning_material_editors ae');
        $baseBuilder->groupStart();
        $hasCondition = false;
        if ($userId > 0) {
            $baseBuilder->where('ae.editor_id', $userId);
            $hasCondition = true;
        }
        if ($email !== '') {
            $method = $hasCondition ? 'orWhere' : 'where';
            $baseBuilder->{$method}('LOWER(ae.editor_email)', $email);
            $hasCondition = true;
        }
        $baseBuilder->groupEnd();

        $countBuilder = clone $baseBuilder;
        $totalRow = $countBuilder
            ->select('COUNT(DISTINCT ae.content_id) AS aggregate', false)
            ->get()
            ->getRowArray();

        $total = (int) ($totalRow['aggregate'] ?? 0);
        if ($total === 0) {
            return ['items' => [], 'meta' => $this->buildMeta(0, $dto)];
        }

        $offset = ($dto->page - 1) * $dto->per_page;
        $itemsBuilder = clone $baseBuilder;
        $itemsBuilder->join('contents a', 'a.id = ae.content_id');
        $itemsBuilder->select([
            'a.id',
            'a.course_id',
            'a.content_type_id',
            'a.first_language',
            'a.topics',
            'a.status',
            'a.created_at',
            'MAX(ae.assigned_at) AS last_assigned_at',
            'MAX(CONCAT(ae.assigned_at, "|#|", IFNULL(ae.editor_email, ""))) AS last_assignment_email',
            'MAX(CONCAT(ae.assigned_at, "|#|", IFNULL(ae.editor_id, ""))) AS last_assignment_editor',
        ]);
        $itemsBuilder->groupBy('a.id');
        $itemsBuilder->orderBy('last_assigned_at', 'DESC');
        $itemsBuilder->limit($dto->per_page, $offset);

        $rows = $itemsBuilder
            ->get()
            ->getResultArray();

        if (empty($rows)) {
            return ['items' => [], 'meta' => $this->buildMeta($total, $dto)];
        }

        $items = $this->hydrateArticles($rows);

        return [
            'items' => $items,
            'meta'  => $this->buildMeta($total, $dto),
        ];
    }

    /**
     * @param array<int,array<string,mixed>> $contentRows
     * @return array<int,array<string,mixed>>
     */
    private function hydrateArticles(array $contentRows): array
    {
        $learningMaterialIds = array_map(static fn(array $row) => (int) $row['id'], $contentRows);

        $translationRows = $this->translations
            ->whereIn('learning_material_id', $learningMaterialIds)
            ->select('content_id, lang, title, short_title, self_description')
            ->findAll();

        $translationsByArticle = [];
        foreach ($translationRows as $row) {
            $aid  = (int) $row['learning_material_id'];
            $lang = (string) $row['lang'];
            $translationsByArticle[$aid][$lang] = $row;
        }

        $items = [];
        foreach ($contentRows as $row) {
            $row = $this->normalizeAssignmentMeta($row);
            $items[] = $this->formatArticleRow($row, $translationsByArticle);
        }

        return $items;
    }

    /**
     * @param array<string,mixed> $row
     * @param array<int,array<string,mixed>> $translationsByArticle
     * @return array<string,mixed>
     */
    private function formatArticleRow(array $row, array $translationsByArticle): array
    {
        $id    = (int) $row['id'];
        $langs = $translationsByArticle[$id] ?? [];

        $preferredLang = (string) ($row['first_language'] ?? '');
        $translation   = $langs[$preferredLang]
            ?? ($langs['tr'] ?? ($langs['en'] ?? $this->firstTranslation($langs)));

        $title       = $translation['title'] ?? $translation['short_title'] ?? ('Başlıksız Eğitim İçeriği #' . $id);
        $description = $translation['self_description'] ?? ($row['topics'] ?? null);

        $status      = (string) ($row['status'] ?? '');
        $statusLabel = LearningMaterialStatusFormatter::label($status);
        $statusColor = LearningMaterialStatusFormatter::color($status);

        $createdAt   = $row['created_at'] ?? null;
        $assignedAt  = $row['assigned_at'] ?? $createdAt;
        $assignmentEmail = $row['assignment_email'] ?? null;

        return [
            'id'                  => $id,
            'title'               => $title,
            'description'         => $description,
            'topics'              => $row['topics'] ?? null,
            'status'              => $status,
            'status_text'         => $statusLabel,
            'status_label'        => $statusLabel,
            'status_color'        => $statusColor,
            'content_type_id' => $row['content_type_id'] ?? null,
            'course_id'     => $row['course_id'] ?? null,
            'created_at'          => $createdAt,
            'updated_at'          => $assignedAt,
            'assigned_at'         => $assignedAt,
            'assignment_email'    => $assignmentEmail,
        ];
    }

    /**
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    private function normalizeAssignmentMeta(array $row): array
    {
        $row['assigned_at'] = $row['last_assigned_at'] ?? $row['assigned_at'] ?? null;

        $assignmentEmail = $row['last_assignment_email'] ?? null;
        if ($assignmentEmail) {
            $parts = explode('|#|', $assignmentEmail, 2);
            $emailPart = $parts[1] ?? null;
            $row['assignment_email'] = $emailPart !== '' ? $emailPart : null;
        } elseif (!array_key_exists('assignment_email', $row)) {
            $row['assignment_email'] = $row['editor_email'] ?? null;
        }

        $assignmentEditor = $row['last_assignment_editor'] ?? null;
        if ($assignmentEditor) {
            $parts = explode('|#|', $assignmentEditor, 2);
            $editorPart = $parts[1] ?? null;
            $row['assignment_editor_id'] = $editorPart !== null && $editorPart !== '' ? (int) $editorPart : null;
        } elseif (!array_key_exists('assignment_editor_id', $row) && isset($row['editor_id'])) {
            $row['assignment_editor_id'] = $row['editor_id'] !== null ? (int) $row['editor_id'] : null;
        }

        unset($row['last_assigned_at'], $row['last_assignment_email'], $row['last_assignment_editor']);

        return $row;
    }

    /**
     * @param array<string,mixed> $translations
     * @return array<string,mixed>
     */
    private function firstTranslation(array $translations): array
    {
        if (empty($translations)) {
            return [];
        }

        $first = reset($translations);

        return is_array($first) ? $first : [];
    }

    /**
     * @return array{total:int,page:int,per_page:int,total_pages:int}
     */
    private function buildMeta(int $total, MyLearningMaterialsQueryDTO $dto): array
    {
        $totalPages = (int) max(1, (int) ceil($total / $dto->per_page));

        return [
            'total'       => $total,
            'page'        => $dto->page,
            'per_page'    => $dto->per_page,
            'total_pages' => $totalPages,
        ];
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function listEditorsByContent(int $learningMaterialId): array
    {
        if ($learningMaterialId <= 0) {
            return [];
        }

        $builder = $this->editors->builder('learning_material_editors ae');
        $builder->select([
            'ae.id',
            'ae.content_id',
            'ae.editor_email',
            'ae.editor_id',
            'ae.assigned_at',
            'u.name AS user_name',
            'u.surname AS user_surname',
        ]);
        $builder->join('users u', 'u.id = ae.editor_id', 'left');
        $builder->where('ae.content_id', $learningMaterialId);
        $builder->orderBy('ae.assigned_at', 'DESC');

        $rows = $builder->get()->getResultArray();
        if (empty($rows)) {
            return [];
        }

        return array_map(static function (array $row): array {
            $fullName = trim(($row['user_name'] ?? '') . ' ' . ($row['user_surname'] ?? ''));
            return [
                'id' => (int) ($row['id'] ?? 0),
                'learning_material_id' => (int) ($row['learning_material_id'] ?? 0),
                'email' => (string) ($row['editor_email'] ?? ''),
                'editor_id' => isset($row['editor_id']) ? (int) $row['editor_id'] : null,
                'assigned_at' => $row['assigned_at'] ?? null,
                'is_registered' => !empty($row['editor_id']),
                'registered_name' => $fullName !== '' ? $fullName : null,
            ];
        }, $rows);
    }
}
