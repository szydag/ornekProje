<?php
declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\LearningMaterials\LearningMaterialUpdateDTO;
use App\Exceptions\DtoValidationException;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\LearningMaterials\LearningMaterialTranslationsModel;
use App\Models\LearningMaterials\LearningMaterialContributorsModel;
use App\Models\LearningMaterials\LearningMaterialFilesModel;
use App\Models\LearningMaterials\LearningMaterialExtraInfoModel;
use App\Models\LearningMaterials\LearningMaterialApprovalsModel;
use CodeIgniter\HTTP\IncomingRequest;

final class LearningMaterialUpdateService
{
    public function __construct(
        private LearningMaterialsModel $learningMaterials = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translations = new LearningMaterialTranslationsModel(),
        private LearningMaterialContributorsModel $contributors = new LearningMaterialContributorsModel(),
        private LearningMaterialFilesModel $files = new LearningMaterialFilesModel(),
        private LearningMaterialExtraInfoModel $extra = new LearningMaterialExtraInfoModel(),
        private LearningMaterialApprovalsModel $approvals = new LearningMaterialApprovalsModel(),
    ) {}

    /** Edit ekranı için tüm verileri getirir. */
    public function getEditData(int $learningMaterialId): array
    {
        $content = $this->contents->find($learningMaterialId);
        if (!$content) {
            throw new \RuntimeException('İçerik bulunamadı.');
        }

        $trans = $this->translations->where('learning_material_id', $learningMaterialId)->findAll();
        $contributors = $this->authors->where('learning_material_id', $learningMaterialId)->orderBy('order_number')->findAll();
        $files = $this->files->where('learning_material_id', $learningMaterialId)->orderBy('id')->findAll();
        $extra = $this->extra->where('learning_material_id', $learningMaterialId)->findAll();
        $appr  = $this->approvals->where('learning_material_id', $learningMaterialId)->first();

        return [
            'content'      => $content,
            'translations' => $trans,
            'authors'      => $contributors,
            'files'        => $files,
            'extra'        => $extra,
            'approvals'    => $appr,
        ];
    }

    /** JSON payload ile tek transaction’da güncelle. */
    public function update(int $learningMaterialId, IncomingRequest $request): int
    {
        $dto = LearningMaterialUpdateDTO::fromRequest($request);
        $dto->assertNotEmpty();

        $db = db_connect();
        $db->transException(true)->transStart();

        try {
            // STEP1 — contents + translations (TR/EN)
            if ($dto->step1 !== null) {
                $s1 = $dto->step1;

                // contents
                $topics = $s1['topics'] ?? [];
                if (!is_array($topics)) $topics = (array)$topics;
                $topicsValue = json_encode(array_values($topics), JSON_UNESCAPED_UNICODE);

                $payload = [
                    'content_type_id' => (int)($s1['content_type_id'] ?? 0),
                    'first_language'      => (string)($s1['primary_language'] ?? $s1['first_language'] ?? 'tr'),
                    'topics'              => $topicsValue,
                    'status' => (string)($s1['status'] ?? ((new \Config\Processes)->firstProcesses() ?? 'on_inceleme')),
                ];
                // `created_at`’ı değiştirmiyoruz
                $ok = $this->contents->update($learningMaterialId, $payload);
                if ($ok === false) {
                    $errors = $this->contents->errors() ?: ['db' => 'Content update failed'];
                    throw new \RuntimeException(json_encode($errors, JSON_UNESCAPED_UNICODE));
                }

                // translations upsert (TR & EN)
                $map = [
                    'tr' => [
                        'title'            => $s1['title_tr']       ?? null,
                        'short_title'      => $s1['short_title_tr'] ?? null,
                        'keywords'         => $s1['keywords_tr']    ?? null,
                        'self_description' => $s1['abstract_tr']    ?? null,
                    ],
                    'en' => [
                        'title'            => $s1['title_en']       ?? null,
                        'short_title'      => $s1['short_title_en'] ?? null,
                        'keywords'         => $s1['keywords_en']    ?? null,
                        'self_description' => $s1['abstract_en']    ?? null,
                    ],
                ];
                foreach ($map as $lang => $vals) {
                    $exists = $this->translations
                        ->where(['learning_material_id' => $learningMaterialId, 'lang' => $lang])
                        ->first();

                    // Tümü boşsa kaydı silmek isteyebilirsiniz; burada boşsa skip ediyoruz
                    $allEmpty = array_reduce($vals, fn($c,$v)=>$c && ($v===null || $v===''), true);
                    if ($allEmpty) {
                        if ($exists) {
                            $this->translations->delete((int)$exists['id']);
                        }
                        continue;
                    }

                    $row = [
                        'learning_material_id'       => $learningMaterialId,
                        'lang'             => $lang,
                        'title'            => $vals['title']            ?: null,
                        'short_title'      => $vals['short_title']      ?: null,
                        'keywords'         => $vals['keywords']         ?: null,
                        'self_description' => $vals['self_description'] ?: null,
                    ];

                    if ($exists) {
                        $this->translations->update((int)$exists['id'], $row);
                    } else {
                        $this->translations->insert($row);
                    }
                }
            }

            // STEP2 — authors sync (upsert + delete)
            $db = db_connect();
            $contributorsTable = 'learning_material_contributors';
            $hasAffiliationColumn = $db->fieldExists('affiliation', $contributorsTable);
            $hasInstitutionColumn = $db->fieldExists('institution_id', $contributorsTable);

            if ($dto->authors !== null) {
                foreach ($dto->authors as $a) {
                    if (!empty($a['_delete']) && !empty($a['id'])) {
                        $this->authors->delete((int)$a['id']);
                        continue;
                    }

                    $row = [
                        'learning_material_id'   => $learningMaterialId,
                        'type'         => $a['type'] ?? 'author',
                        'order_number' => (int)($a['order'] ?? 0),
                        'orcid'        => $a['orcid'] ?? null,
                        'name'         => $a['first_name'] ?? null,
                        'surname'      => $a['last_name'] ?? null,
                        'mail'         => $a['email'] ?? null,
                        'phone'        => $a['phone'] ?? null,
                        'country_id'   => $a['country_id'] ?? null,
                        'city'         => $a['city'] ?? null,
                        'title_id'     => $this->normalizeNullableInt($a['title_id'] ?? null),
                        'user_id'      => $a['user_id'] ?? null,
                        'is_corresponding' => !empty($a['is_corresponding']) ? 1 : 0,
                    ];

                    if ($hasAffiliationColumn) {
                        $row['affiliation'] = $a['affiliation'] ?? null;
                    }

                    if ($hasInstitutionColumn) {
                        $row['institution_id'] = $this->normalizeNullableInt($a['affiliation_id'] ?? $a['institution_id'] ?? null);
                    }

                    if (!empty($a['id'])) {
                        $this->authors->update((int)$a['id'], $row);
                    } else {
                        $this->authors->insert($row);
                    }
                }
            }

            // STEP3 — files: add + delete
            if ($dto->delete_file_ids !== null && !empty($dto->delete_file_ids)) {
                $current = $this->files
                    ->where('learning_material_id', $learningMaterialId)
                    ->whereIn('id', $dto->delete_file_ids)
                    ->findAll();

                // DB’den sil + (varsa) diskteki dosyayı temizlemeye çalış (isim üzerinden)
                foreach ($current as $f) {
                    $this->files->delete((int)$f['id']);

                    // Dosya yolu DB’de yok; isminden tahmin ile kaldırmayı DENE
                    $guessPath = WRITEPATH . 'uploads/contents/' . $learningMaterialId . '/' . $f['name'];
                    if (is_file($guessPath)) {
                        @unlink($guessPath);
                    }
                }
            }

            if ($dto->add_files !== null && !empty($dto->add_files)) {
                $ins = [];
                $now = date('Y-m-d H:i:s');

                foreach ($dto->add_files as $f) {
                    // kalıcıya taşı
                    $relative = $this->moveToPermanent(
                        $f['stored_path'],
                        $learningMaterialId,
                        $f['name'] ?? null
                    );

                    $savedName = trim((string)($f['name'] ?? ''));
                    if ($savedName === '' && $relative) {
                        $savedName = basename($relative);
                    }

                    $desc = $f['description'] ?? $f['notes'] ?? null;

                    $ins[] = [
                        'learning_material_id'  => $learningMaterialId,
                        'file_type'   => $this->normalizeFileType($f['file_type'] ?? null, $f['role'] ?? null),
                        'name'        => $savedName,
                        'description' => $desc,
                        'created_at'  => $now,
                    ];
                }

                if (!empty($ins)) {
                    $this->files->insertBatch($ins);
                }
            }

            // STEP4 — extra info (rows upsert + delete), project_number opsiyonel
            if ($dto->extraRows !== null) {
                foreach ($dto->extraRows as $r) {
                    if (!empty($r['_delete']) && !empty($r['id'])) {
                        $this->extra->delete((int)$r['id']);
                        continue;
                    }

                    $row = [
                        'learning_material_id'             => $learningMaterialId,
                        'lang'                   => (string)($r['lang'] ?? 'tr'),
                        'ethics_declaration'     => $r['ethics_declaration']     ?? null,
                        'supporting_institution' => $r['supporting_institution'] ?? null,
                        'thanks_description'     => $r['thanks_description']     ?? null,
                        'project_number'         => $r['project_number']         ?? ($dto->project_number ?? null),
                    ];

                    if (!empty($r['id'])) {
                        $this->extra->update((int)$r['id'], $row);
                    } else {
                        $this->extra->insert($row);
                    }
                }
            }

            // STEP5 — approvals upsert (UNIQUE content_id varsayımı)
            if ($dto->approvals !== null) {
                $existing = $this->approvals->where('learning_material_id', $learningMaterialId)->first();
                $payload = [
                    'learning_material_id'     => $learningMaterialId,
                    'rules_ok'       => $dto->approvals['rules_ok'] ?? 'hayir',
                    'all_authors_ok' => $dto->approvals['all_authors_ok'] ?? 'hayir',
                    'description'    => $dto->approvals['description'] ?? null,
                ];

                if ($existing) {
                    $this->approvals->update((int)$existing['id'], $payload);
                } else {
                    $payload['created_at'] = date('Y-m-d H:i:s');
                    $this->approvals->insert($payload);
                }
            }

            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed.');
            }

            return $learningMaterialId;

        } catch (\Throwable $e) {
            // $db->transRollback(); // transException(true) olduğundan otomatik
            throw $e;
        }
    }

    /**
     * Wizard’dakiyle aynı mantık — geçici dosyayı kalıcı klasöre taşır ve relative path döner.
     */
    private function moveToPermanent(string $storedPath, int $learningMaterialId, ?string $clientName = null): string
    {
        $permanentRoot = WRITEPATH . 'uploads/contents/' . $learningMaterialId;
        if (!is_dir($permanentRoot) && !@mkdir($permanentRoot, 0775, true) && !is_dir($permanentRoot)) {
            throw new \RuntimeException('Kalıcı klasör oluşturulamadı: ' . $permanentRoot);
        }
        if (!is_file($storedPath)) {
            throw new \RuntimeException('Temp dosya bulunamadı: ' . $storedPath);
        }

        $ext  = pathinfo($storedPath, PATHINFO_EXTENSION) ?: 'bin';
        $base = $clientName ? preg_replace('/[^\p{L}\p{N}\._-]+/u', '-', pathinfo($clientName, PATHINFO_FILENAME)) : basename($storedPath, '.' . $ext);
        $final = $base . '.' . $ext;

        $i = 1;
        while (is_file($permanentRoot . '/' . $final)) {
            $final = $base . '-' . $i++ . '.' . $ext;
        }

        $dest = $permanentRoot . '/' . $final;
        if (!@rename($storedPath, $dest)) {
            if (!@copy($storedPath, $dest) || !@unlink($storedPath)) {
                throw new \RuntimeException('Dosya kalıcı klasöre taşınamadı: ' . $storedPath);
            }
        }
        return 'uploads/contents/' . $learningMaterialId . '/' . $final;
    }

    private function normalizeFileType($fileType, $role): string
    {
        $type = is_string($fileType) ? trim($fileType) : '';
        if ($type !== '') {
            return $type;
        }

        $normalizedRole = is_string($role) ? trim($role) : '';
        return match ($normalizedRole) {
            'full_text' => 'tam_metin',
            'copyright_form' => 'telif_hakki',
            default => 'ek_dosya',
        };
    }

    private function normalizeNullableInt($value): ?int
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return null;
            }
        }

        if (!is_numeric($value)) {
            return null;
        }

        $int = (int) $value;
        return $int > 0 ? $int : null;
    }
}
