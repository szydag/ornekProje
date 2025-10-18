<?php
declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\LearningMaterials\LearningMaterialDetailDTO;
use App\DTOs\LearningMaterials\LearningMaterialTopDTO;
use App\DTOs\LearningMaterials\LearningMaterialTranslationDTO;
use App\DTOs\LearningMaterials\ContributorDTO;
use App\DTOs\LearningMaterials\FileDTO;
use App\DTOs\LearningMaterials\ExtraInfoDTO;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\LearningMaterials\LearningMaterialTranslationsModel;
use App\Models\LearningMaterials\LearningMaterialContributorsModel;
use App\Models\LearningMaterials\LearningMaterialFilesModel;
use App\Models\LearningMaterials\LearningMaterialExtraInfoModel;
use App\Models\LearningMaterials\ContentTypeModel; // sizde zaten mevcut

final class LearningMaterialDetailService
{
    public function __construct(
        private LearningMaterialsModel $learningMaterials = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translations = new LearningMaterialTranslationsModel(),
        private LearningMaterialContributorsModel $contributors = new LearningMaterialContributorsModel(),
        private LearningMaterialFilesModel $files = new LearningMaterialFilesModel(),
        private LearningMaterialExtraInfoModel $extra = new LearningMaterialExtraInfoModel(),
        private ContentTypeModel $contentTypes = new ContentTypeModel(),
    ) {}

    public function getDetail(int $learningMaterialId): LearningMaterialDetailDTO
    {
        $content = $this->contents->find($learningMaterialId);
        if (!$content) {
            throw new \RuntimeException('İçerik bulunamadı');
        }

        $ptName = null;
        if (!empty($content['content_type_id'])) {
            $pt = $this->pubTypes->select('name')->find((int) $content['content_type_id']);
            $ptName = $pt['name'] ?? null;
        }

        $trs = $this->translations
            ->where('learning_material_id', $learningMaterialId)
            ->orderBy('lang', 'ASC')
            ->findAll();

        $translationDTOs = [];
        foreach ($trs as $row) {
            $dto = LearningMaterialTranslationDTO::fromRow($row);
            $translationDTOs[$dto->lang] = $dto;
        }

        $top = new LearningMaterialTopDTO(
            id: (int) $content['id'],
            content_type_id: (int) $content['content_type_id'],
            content_type_name: $ptName,
            first_language: $content['first_language'] ?? null,
            topics: $content['topics'] ?? null,
            status: $content['status'] ?? null,
            translations: $translationDTOs,
        );

        $authorRows = $this->authors
            ->where('learning_material_id', $learningMaterialId)
            ->orderBy('order_number', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
        $authorDTOs = array_map(fn ($r) => AuthorDTO::fromRow($r), $authorRows);

        $fileRows = $this->files
            ->where('learning_material_id', $learningMaterialId)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll();
        $fileDTOs = array_map(fn ($r) => FileDTO::fromRow($r), $fileRows);

        $extraRows = $this->extra
            ->where('learning_material_id', $learningMaterialId)
            ->orderBy('lang', 'ASC')
            ->findAll();

        $extraByLang = [];
        foreach ($extraRows as $r) {
            $e = ExtraInfoDTO::fromRow($r);
            $extraByLang[$e->lang] = $e;
        }

        return new LearningMaterialDetailDTO($top, $authorDTOs, $fileDTOs, $extraByLang);
    }

}
