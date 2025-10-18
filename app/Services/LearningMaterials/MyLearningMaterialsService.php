<?php
declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\Articles\MyLearningMaterialsQueryDTO;
use App\Models\Articles\LearningMaterialsModel;
use App\Models\Articles\LearningMaterialTranslationsModel;
use App\Support\LearningMaterialStatusFormatter;

final class MyLearningMaterialsService
{
    public function __construct(
        private LearningMaterialsModel $learningMaterials = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translations = new LearningMaterialTranslationsModel(),
    ) {}

    /**
     * @return array{
     *   items: array<int, array<string, mixed>>,
     *   meta: array{total:int,page:int,per_page:int,total_pages:int}
     * }
     */
    public function listMine(int $userId, MyLearningMaterialsQueryDTO $dto): array
    {
        $total = (clone $this->contents)
            ->where('user_id', $userId)
            ->countAllResults();

        $offset = ($dto->page - 1) * $dto->per_page;

        $contentRows = (clone $this->contents)
            ->select('id, course_id, content_type_id, first_language, topics, status, created_at')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll($dto->per_page, $offset);

        if (empty($contentRows)) {
            return [
                'items' => [],
                'meta'  => $this->buildMeta($total, $dto),
            ];
        }

        $items = $this->hydrateArticles($contentRows);

        return [
            'items' => $items,
            'meta'  => $this->buildMeta($total, $dto),
        ];
    }

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
            $items[] = $this->formatArticleRow($row, $translationsByArticle);
        }

        return $items;
    }

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

        if ($status !== '' && strtolower($status) === 'korhakemlik') {
            $statusLabel = 'Beklemede';
        }

        $createdAt   = $row['created_at'] ?? null;

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
            'updated_at'          => $createdAt,
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
}
