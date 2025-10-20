<?php
declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\LearningMaterials\AllLearningMaterialsQueryDTO;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\LearningMaterials\LearningMaterialTranslationsModel;
use App\Models\Users\UserModel;
use App\Support\LearningMaterialStatusFormatter;

final class AllLearningMaterialsService
{
    public function __construct(
        private LearningMaterialsModel $learningMaterials = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translations = new LearningMaterialTranslationsModel(),
        private UserModel $users = new UserModel(),
    ) {}

    /**
     * @return array{
     *   items: array<int, array<string, mixed>>,
     *   meta: array{total:int,page:int,per_page:int,total_pages:int}
     * }
     */
    public function listAll(AllLearningMaterialsQueryDTO $dto): array
    {
        $total  = (clone $this->learningMaterials)->countAllResults();
        $offset = ($dto->page - 1) * $dto->per_page;

        $contentRows = (clone $this->learningMaterials)
            ->select('id, user_id, course_id, content_type_id, first_language, topics, status, created_at')
            ->orderBy('id', 'DESC')
            ->findAll($dto->per_page, $offset);

        if (empty($contentRows)) {
            return [
                'items' => [],
                'meta'  => $this->buildMeta($total, $dto),
            ];
        }

        $items = $this->hydrateContents($contentRows);

        return [
            'items' => $items,
            'meta'  => $this->buildMeta($total, $dto),
        ];
    }

    private function hydrateContents(array $contentRows): array
    {
        $learningMaterialIds = array_map(static fn(array $row) => (int) $row['id'], $contentRows);
        $userIds    = array_unique(array_map(static fn(array $row) => (int) ($row['user_id'] ?? 0), $contentRows));

        $translationRows = $this->translations
            ->whereIn('learning_material_id', $learningMaterialIds)
            ->select('learning_material_id, lang, title, short_title, self_description')
            ->findAll();

        $translationsByContent = [];
        foreach ($translationRows as $row) {
            $cid  = (int) $row['learning_material_id'];
            $lang = (string) $row['lang'];
            $translationsByContent[$cid][$lang] = $row;
        }

        $userMap = [];
        if (! empty($userIds)) {
            $userRows = $this->users
                ->select('id, name, surname')
                ->whereIn('id', $userIds)
                ->findAll();

            foreach ($userRows as $user) {
                $uid      = (int) $user['id'];
                $fullName = trim(sprintf('%s %s', $user['name'] ?? '', $user['surname'] ?? ''));
                $userMap[$uid] = $fullName !== '' ? $fullName : 'Bilinmiyor';
            }
        }

        $items = [];
        foreach ($contentRows as $row) {
            $items[] = $this->formatContentRow($row, $translationsByContent, $userMap);
        }

        return $items;
    }

    private function formatContentRow(array $row, array $translationsByContent, array $userMap): array
    {
        $id    = (int) $row['id'];
        $uid   = (int) ($row['user_id'] ?? 0);
        $langs = $translationsByContent[$id] ?? [];

        $preferredLang = (string) ($row['first_language'] ?? '');
        $translation   = $langs[$preferredLang]
            ?? ($langs['tr'] ?? ($langs['en'] ?? $this->firstTranslation($langs)));

        $title       = $translation['title'] ?? $translation['short_title'] ?? ('Başlıksız Eğitim İçeriği #' . $id);
        $description = $translation['self_description'] ?? ($row['topics'] ?? null);

        $status      = (string) ($row['status'] ?? '');
        $statusLabel = LearningMaterialStatusFormatter::label($status);
        $statusColor = LearningMaterialStatusFormatter::color($status);

        $createdAt   = $row['created_at'] ?? null;
        $updatedAt   = $row['updated_at'] ?? $createdAt;

        return [
            'id'                  => $id,
            'title'               => $title,
            'description'         => $description,
            'topics'              => $row['topics'] ?? null,
            'author_id'           => $uid,
            'author_name'         => $userMap[$uid] ?? 'Bilinmiyor',
            'status'              => $status,
            'status_text'         => $statusLabel,
            'status_label'        => $statusLabel,
            'status_color'        => $statusColor,
            'content_type_id' => $row['content_type_id'] ?? null,
            'course_id'     => $row['course_id'] ?? null,
            'created_at'          => $createdAt,
            'updated_at'          => $updatedAt,
        ];
    }

    private function firstTranslation(array $translations): array
    {
        if (empty($translations)) {
            return [];
        }

        $first = reset($translations);

        return is_array($first) ? $first : [];
    }

    private function buildMeta(int $total, AllLearningMaterialsQueryDTO $dto): array
    {
        $totalPages = (int) max(1, (int) ceil($total / $dto->per_page));

        return [
            'total'       => $total,
            'page'        => $dto->page,
            'per_page'    => $dto->per_page,
            'total_pages' => $totalPages,
        ];
    }
}
