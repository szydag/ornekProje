<?php

declare(strict_types=1);

namespace App\Services\LearningMaterials;

use App\DTOs\Articles\Step1DTO;
use App\DTOs\Articles\Step2DTO;
use App\DTOs\Articles\Step3DTO;
use App\Exceptions\DtoValidationException;
use App\Models\Users\TitleModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Files\File;
use App\Models\Articles\ContentTypeModel;
use App\Models\Articles\TopicModel;
use App\Models\Articles\LearningMaterialsModel;
use App\Models\Users\UserModel;
use App\Models\Articles\LearningMaterialTranslationsModel;
use App\Models\Articles\LearningMaterialContributorsModel;
use App\Models\Articles\LearningMaterialFilesModel;
use App\Models\Articles\LearningMaterialExtraInfoModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\DTOs\Articles\Step5DTO;
use App\Models\Articles\LearningMaterialApprovalsModel;
use CodeIgniter\HTTP\IncomingRequest;
use RuntimeException;
use App\Models\Users\İnstitutionModel;
use App\Models\Users\CountryModel;
final class LearningMaterialWizardService
{
    private const SKEY = 'wizard_learning_material';

    private ContentTypeModel $contentTypes;
    private TopicModel $topicsModel;
    private CountryModel $countryModel;
    private TitleModel $titleModel;
    private İnstitutionModel $institutionModel;
    private LearningMaterialsModel $learningMaterials;
    private LearningMaterialTranslationsModel $translations;
    private LearningMaterialContributorsModel $contributors;
    private LearningMaterialFilesModel $files;
    private LearningMaterialExtraInfoModel $extraInfo;
    private LearningMaterialApprovalsModel $approvals;

    public function __construct(
        ?ContentTypeModel $contentTypes = null,
        ?TopicModel $topicsModel = null,
        ?CountryModel $countryModel = null,
        ?TitleModel $titleModel = null,
        ?İnstitutionModel $institutionModel = null,
    ) {
        $this->pubTypes = $contentTypes ?? new ContentTypeModel();
        $this->topicsModel = $topicsModel ?? new TopicModel();
        $this->countryModel = $countryModel ?? new CountryModel();
        $this->titleModel = $titleModel ?? new TitleModel();
        $this->institutionModel = $institutionModel ?? new İnstitutionModel();

        // Tüm bağlı modelleri doğrudan örnekle
        $this->contents = new LearningMaterialsModel();
        $this->translations = new LearningMaterialTranslationsModel();
        $this->authors = new LearningMaterialContributorsModel();
        $this->files = new LearningMaterialFilesModel();
        $this->extraInfo = new LearningMaterialExtraInfoModel();
        $this->approvals = new LearningMaterialApprovalsModel();

        // (İsteğe bağlı güvence kontrolleri)
        if (!$this->pubTypes instanceof ContentTypeModel) {
            throw new RuntimeException('ContentTypeModel bulunamadı.');
        }
        if (!$this->topicsModel instanceof TopicModel) {
            throw new RuntimeException('TopicModel bulunamadı.');
        }
    }


    /** @return array<int,string> id=>name */
    public function getPublicationTypes(): array
    {
        return $this->pubTypes->listForSelect();
    }

    /** @return array<int,string> id=>name */
    public function getTopics(): array
    {
        return $this->topicsModel->listForSelect();
    }
    /** @return array<string,array> code=>['name'=>string,'flag'=>string] */
    public function getCountries(): array
    {
        return $this->countryModel->asRichMap();
    }

    /** @return array<int,string> id=>name */
    public function getTitles(): array
    {
        return $this->titleModel->asMap();
    }

    /** @return array<int,string> id=>name */
    public function getInstitutions(): array
    {
        return $this->institutionModel->asMap();
    }

    /** @return array<int,string> id=>name */
    public function getInstitutionTypes(): array
    {
        // InstitutionTypes için basit bir model kullanacağız
        $db = db_connect();
        $rows = $db->table('institution_types')
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['id']] = $row['name'] ?? '';
        }

        return $map;
    }

    /** @return mixed */
    /*private function sessionSet(string $key, array $data): void
    {
        $bag = session(self::SKEY) ?? [];
        $bag[$key] = $data;
        session()->set(self::SKEY, $bag);
    }

    public function sessionGet(string $key, $default = null)
    {
        $bag = session(self::SKEY) ?? [];
        return $bag[$key] ?? $default;
    }

    public function sessionAll(): array
    {
        return (array) (session(self::SKEY) ?? []);
    }*/

    /**
     * @throws DtoValidationException
     * @return array temiz veri
     */
    public function handleStep1(IncomingRequest $request): array
    {
        $dto = Step1DTO::fromRequest($request);

        $errors = $dto->errors();
        if (!empty($errors)) {
            throw new DtoValidationException('Step1 validation failed', $errors);
        }

        // (İsteğe bağlı ek DB doğrulamaları)

        return $dto->toArray();
    }

    public function getStep1Defaults(): array
    {
        return [
            'course_id' => null,
            'content_type_id' => null,
            'topics' => [],
            'primary_language' => null,
            'title_tr' => null,
            'short_title_tr' => null,
            'keywords_tr' => [],
            'abstract_tr' => null,
            'title_en' => null,
            'short_title_en' => null,
            'keywords_en' => [],
            'abstract_en' => null,
            'status' => null,
        ];
    }

    // app/Services/Articles/LearningMaterialWizardService.php:150 civarı
    public function getStep2Data(): array
    {
        return $this->getStep2Defaults();
    }

    public function getStep2Defaults(): array
    {
        $defaults = ['authors' => []];

        if ($author = $this->buildDefaultAuthorFromSessionUser()) {
            $defaults['authors'][] = $author;
        }

        return $defaults;
    }

    private function buildDefaultAuthorFromSessionUser(): ?array
    {
        $userId = (int) (session('user_id') ?? 0);
        if ($userId <= 0) {
            return null;
        }

        $users = model(UserModel::class);
        $institutions = model(İnstitutionModel::class);
        $titles = model(TitleModel::class);
        $countries = model(CountryModel::class);

        $user = $users->find($userId);
        if (!$user) {
            return null;
        }

        $institution = $user['institution_id'] ? $institutions->find($user['institution_id']) : null;
        $title = $user['title_id'] ? $titles->find($user['title_id']) : null;
        $country = $user['country_id'] ? $countries->find($user['country_id']) : null;

        return [
            'type' => 'author',
            'user_id' => $userId,
            'first_name' => $user['name'] ?? '',
            'last_name' => $user['surname'] ?? '',
            'email' => $user['mail'] ?? '',
            'phone' => $user['phone'] ?? null,
            'affiliation' => $institution['name'] ?? null,
            'title' => $title['name'] ?? null,
            'country' => $country['name'] ?? null,
            'is_corresponding' => true,
            'order' => 1,
        ];
    }



    /** POST step2: validate + session yaz */
    public function handleStep2(IncomingRequest $request): array
    {
        $dto = Step2DTO::fromRequest($request);
        $clean = $dto->validate();

        // İstersen burada user_id doğrulaması (kullanıcı var mı) ekleyebilirsin.
        // Örn: UsersModel ile is_exist check

        //$this->sessionSet('step2', $clean);
        return $clean;
    }

    public function getStep3Data(): array
    {
        return $this->getStep3Defaults();
    }

    public function getStep3Defaults(): array
    {
        return ['files' => []];
    }


    /** POST step3: metadata doğrula + session yaz */
    public function handleStep3(IncomingRequest $request): array
    {
        $dto = Step3DTO::fromRequest($request);
        $clean = $dto->validate();

        // Not: Burada temp dosyaları kalıcı klasöre taşımak istersen
        // $clean['files'] içindeki temp_id/stored_path’tan karar verip move edebilirsin.
        // Şimdilik sadece session'a yazıyoruz.

        //$this->sessionSet('step3', $clean);
        return $clean;
    }

    /**
     * Dosya upload endpoint’i: çoklu dosya alır, geçici klasöre taşır,
     * her dosya için temp_id ve meta döndürür.
     *
     * @return array<string,mixed> {files:[...]}
     * @throws \RuntimeException
     */
    public function handleStep3Upload(IncomingRequest $request): array
    {
        // 1) Önce 'files' alanı için doğrudan topla
        /** @var UploadedFile[] $uploaded */
        $uploaded = $request->getFileMultiple('files') ?? [];

        // 2) Yedek: farklı anahtarlarla geldiyse getFiles() içinden süpür
        if (empty($uploaded)) {
            $all = $request->getFiles(); // ['files'=>[UploadedFile,...]] veya başka anahtarlar
            foreach ($all as $group) {
                if ($group instanceof UploadedFile) {
                    $uploaded[] = $group;
                } elseif (is_array($group)) {
                    foreach ($group as $f) {
                        if ($f instanceof UploadedFile) {
                            $uploaded[] = $f;
                        }
                    }
                }
            }
        }

        if (empty($uploaded)) {
            throw new \RuntimeException('Yüklenecek dosya bulunamadı.');
        }

        $uploadRoot = WRITEPATH . 'uploads/contents/tmp';
        if (!is_dir($uploadRoot) && !@mkdir($uploadRoot, 0775, true) && !is_dir($uploadRoot)) {
            throw new \RuntimeException('Geçici upload klasörü oluşturulamadı: ' . $uploadRoot);
        }

        $allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/png',
            'image/jpeg',
            'application/zip',
            'text/csv'
        ];
        $maxSize = 100 * 1024 * 1024; // 100MB

        $out = [];
        foreach ($uploaded as $file) {
            if (!$file->isValid()) {
                throw new \RuntimeException('Dosya geçersiz: ' . $file->getErrorString());
            }
            if ($file->getSize() > $maxSize) {
                throw new \RuntimeException('Dosya 100MB sınırını aşıyor: ' . $file->getName());
            }
            $mime = $file->getMimeType();
            if ($mime && !in_array($mime, $allowed, true)) {
                // istersen burada reddedebilirsin
                // throw new \RuntimeException('İzin verilmeyen MIME: ' . $mime);
            }

            $ext = $file->getExtension() ?: 'bin';
            $tempId = bin2hex(random_bytes(8));
            $stored = $uploadRoot . '/' . $tempId . '.' . $ext;

            // CI4 move: hedef dizin + dosya adı
            $file->move($uploadRoot, basename($stored), true);

            $out[] = [
                'temp_id' => $tempId,
                'name' => $file->getClientName(),
                'stored_path' => $stored, // geçici tam yol
                'mime' => $mime,
                'size' => $file->getSize(),
            ];
        }

        return ['files' => $out];
    }

    public function getStep4Data(): array
    {
        return $this->getStep4Defaults();
    }

    public function getStep4Defaults(): array
    {
        return [
            'project_number' => null,
            'rows' => [],
        ];
    }


    // Step 4 POST: doğrula + session'a yaz
    public function handleStep4(\CodeIgniter\HTTP\IncomingRequest $request): array
    {
        $dto = \App\DTOs\Articles\Step4DTO::fromRequest($request);
        $clean = $dto->validate();

        //$this->sessionSet('step4', $clean);
        return $clean;
    }

    private function moveToPermanent(string $storedPath, int $learningMaterialId, ?string $clientName = null): string
    {
        $permanentRoot = WRITEPATH . 'uploads/contents/' . $learningMaterialId; // writable/uploads/contents/{id}
        if (!is_dir($permanentRoot) && !@mkdir($permanentRoot, 0775, true) && !is_dir($permanentRoot)) {
            throw new \RuntimeException('Kalıcı klasör oluşturulamadı: ' . $permanentRoot);
        }

        if (!is_file($storedPath)) {
            // Temp dosyası yoksa, clientName üzerinden boş bir placeholder üretmeyelim:
            throw new \RuntimeException('Temp dosya bulunamadı: ' . $storedPath);
        }

        $ext = pathinfo($storedPath, PATHINFO_EXTENSION) ?: 'bin';
        // Orijinal ad varsa onu temizleyelim, yoksa temp adı kullan
        $base = $clientName ? preg_replace('/[^\p{L}\p{N}\._-]+/u', '-', pathinfo($clientName, PATHINFO_FILENAME)) : basename($storedPath, '.' . $ext);
        $final = $base . '.' . $ext;

        // Aynı isim varsa benzersizleştir
        $i = 1;
        while (is_file($permanentRoot . '/' . $final)) {
            $final = $base . '-' . $i++ . '.' . $ext;
        }

        $dest = $permanentRoot . '/' . $final;
        if (!@rename($storedPath, $dest)) {
            // rename olmazsa kopyala+sil
            if (!@copy($storedPath, $dest) || !@unlink($storedPath)) {
                throw new \RuntimeException('Dosya kalıcı klasöre taşınamadı: ' . $storedPath);
            }
        }

        // DB’ye yazarken relative path kullanmak istersen:
        $relative = 'uploads/contents/' . $learningMaterialId . '/' . $final; // WRITEPATH’siz
        return $relative;
    }

    private function normalizeFileTypeValue(?string $fileType, ?string $role): string
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

    /**
     * Session’daki Step1–Step4 verilerini DB’ye yazar.
     * Başarılıysa yeni content_id döner.
     */



    public function getStep5Data(): array
    {
        return $this->getStep5Defaults();
    }

    public function getStep5Defaults(): array
    {
        return [
            'checklist' => [
                'required_info' => false,
                'author_approval' => false,
                'writing_rules' => false,
            ],
            'rules_ok' => 'hayir',
            'all_authors_ok' => 'hayir',
            'description' => null,
        ];
    }

    // POST step5: doğrula + session'a yaz
    // LearningMaterialWizardService
    public function handleStep5(IncomingRequest $r): array
    {
        $dto = \App\DTOs\Articles\Step5DTO::fromRequest($r);
        $clean = $dto->toArray();

        //$this->sessionSet('step5', $clean);
        log_message('debug', '[Step5] ' . json_encode($clean, JSON_UNESCAPED_UNICODE));

        return $clean;
    }


    /**
     * Sadece Step-5 verisini DB'ye yazar (learning_material_approvals).
     * @return int inserted_or_updated_id
     */
    public function saveStep5ForArticle(int $learningMaterialId, array $step5): int
    {
        if ($step5 === []) {
            throw new \RuntimeException('Step 5 verisi sağlanmadı.');
        }

        $payload = [
            'learning_material_id' => $learningMaterialId,
            'rules_ok' => $step5['rules_ok'] ?? 'hayir',
            'all_authors_ok' => $step5['all_authors_ok'] ?? 'hayir',
            'description' => $step5['description'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $row = $this->approvals
            ->where('learning_material_id', $learningMaterialId)
            ->first();

        if ($row) {
            unset($payload['created_at']);
            $this->approvals->update($row['id'], $payload);
            return (int) $row['id'];
        }

        return (int) $this->approvals->insert($payload, true);
    }


    public function getLastQuery(): ?string
    {
        try {
            return (string) ($this->contents->db->getLastQuery() ?? '');
        } catch (\Throwable $e) {
            return null;
        }
    }



    // app/Services/Articles/LearningMaterialWizardService.php
    private function requireStep(array $wizardData, string $key): array
    {
        $data = $wizardData[$key] ?? null;
        if (!is_array($data) || $data === []) {
            throw new \RuntimeException(sprintf('Step "%s" verisi bulunamadı ya da boş.', $key));
        }

        return $data;
    }

    public function finalize(array $wizardData): int
    {
        $db = db_connect();
        $db->transException(true)->transStart();

        $contributorsTable = 'learning_material_contributors';
        $hasAffiliationColumn = $db->fieldExists('affiliation', $contributorsTable);
        $hasInstitutionColumn = $db->fieldExists('institution_id', $contributorsTable);

        $userId = (int) ($wizardData['meta']['user_id'] ?? session('user_id') ?? 0);
        if ($userId <= 0) {
            throw new \RuntimeException('Kullanıcı oturumu yok (user_id).');
        }

        try {
            $s1 = $this->requireStep($wizardData, 'step1');
            $contributors = $wizardData['step2']['authors'] ?? [];
            $files = $wizardData['step3']['files'] ?? [];
            $uploads = $wizardData['step3_uploads'] ?? [];
            $extraInfo = $wizardData['step4']['rows'] ?? [];
            $projectNo = $wizardData['step4']['project_number'] ?? null;
            $approvals = $wizardData['step5'] ?? [];

            $topics = $s1['topics'] ?? [];
            if (!is_array($topics)) {
                $topics = (array) $topics;
            }
            $topicsValue = json_encode(array_values($topics), JSON_UNESCAPED_UNICODE);

            $contentPayload = [
                'user_id' => $userId,
                'course_id' => (int) ($s1['course_id'] ?? 0),
                'content_type_id' => (int) ($s1['content_type_id'] ?? $s1['publication_type'] ?? 0),
                'first_language' => (string) ($s1['primary_language'] ?? $s1['first_language'] ?? ''),
                'topics' => $topicsValue,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => (string) ($s1['status'] ?? ((new \Config\Processes)->firstProcesses() ?? 'on_inceleme')),
            ];

            $learningMaterialId = $this->contents->insert($contentPayload, true);
            if ($learningMaterialId === false) {
                $errors = $this->contents->errors() ?: ['db' => 'Bilinmeyen hata'];
                $lastQuery = (string) $this->contents->db->getLastQuery();
                throw new \RuntimeException('Content insert failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery);
            }
            $learningMaterialId = (int) $learningMaterialId;

            $trans = [];
            if (!empty($s1['title_tr']) || !empty($s1['abstract_tr']) || !empty($s1['short_title_tr']) || !empty($s1['keywords_tr'])) {
                $trans[] = [
                    'learning_material_id' => $learningMaterialId,
                    'lang' => 'tr',
                    'title' => $s1['title_tr'] ?? null,
                    'short_title' => $s1['short_title_tr'] ?? null,
                    'keywords' => $s1['keywords_tr'] ?? null,
                    'self_description' => $s1['abstract_tr'] ?? null,
                ];
            }
            if (!empty($s1['title_en']) || !empty($s1['abstract_en']) || !empty($s1['short_title_en']) || !empty($s1['keywords_en'])) {
                $trans[] = [
                    'learning_material_id' => $learningMaterialId,
                    'lang' => 'en',
                    'title' => $s1['title_en'] ?? null,
                    'short_title' => $s1['short_title_en'] ?? null,
                    'keywords' => $s1['keywords_en'] ?? null,
                    'self_description' => $s1['abstract_en'] ?? null,
                ];
            }
            if (!empty($trans)) {
                $this->translations->insertBatch($trans);
            }

            if (!empty($contributors)) {
                $authorRows = [];
                foreach ($contributors as $author) {
                    $row = [
                        'learning_material_id' => $learningMaterialId,
                        'user_id' => $author['user_id'] ?? null,
                        'type' => $author['type'] ?? 'author',
                        'order_number' => (int) ($author['order'] ?? 0) ?: null,
                        'orcid' => $author['orcid'] ?? null,
                        'name' => $author['first_name'] ?? ($author['name'] ?? null),
                        'surname' => $author['last_name'] ?? ($author['surname'] ?? null),
                        'mail' => $author['email'] ?? ($author['mail'] ?? null),
                        'phone' => $author['phone'] ?? null,
                        'country_id' => isset($author['country_id']) ? (int) $author['country_id'] : null,
                        'city' => $author['city'] ?? null,
                        'title_id' => $this->normalizeNullableInt($author['title_id'] ?? null),
                        'is_corresponding' => !empty($author['is_corresponding']) ? 1 : 0,
                    ];

                    if ($hasAffiliationColumn) {
                        $row['affiliation'] = $author['affiliation'] ?? null;
                    }

                    if ($hasInstitutionColumn) {
                        $row['institution_id'] = $this->normalizeNullableInt($author['affiliation_id'] ?? $author['institution_id'] ?? null);
                    }

                    $authorRows[] = $row;
                }

                if ($authorRows && $this->authors->insertBatch($authorRows) === false) {
                    $errors = $this->authors->errors() ?: ['db' => 'Bilinmeyen hata'];
                    $lastQuery = (string) $this->authors->db->getLastQuery();
                    throw new \RuntimeException('Authors insert failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery);
                }
            }

            if (!empty($files)) {
                $fileRows = [];
                $now = date('Y-m-d H:i:s');
                foreach ($files as $file) {
                    $storedPath = $file['stored_path'] ?? null;
                    if (!$storedPath) {
                        continue;
                    }

                    $relative = $this->moveToPermanent($storedPath, $learningMaterialId, $file['name'] ?? null);
                    $savedName = basename($relative);
                    $fileRows[] = [
                        'learning_material_id' => $learningMaterialId,
                        'file_type' => $this->normalizeFileTypeValue($file['file_type'] ?? null, $file['role'] ?? null),
                        'name' => $savedName,
                        'description' => $file['notes'] ?? null,
                        'created_at' => $now,
                    ];
                }

                if ($fileRows && $this->files->insertBatch($fileRows) === false) {
                    $errors = $this->files->errors() ?: ['db' => 'Bilinmeyen hata'];
                    $lastQuery = (string) $this->files->db->getLastQuery();
                    throw new \RuntimeException('Files insert failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery);
                }
            }

            if (!empty($extraInfo)) {
                $ins = [];
                foreach ($extraInfo as $row) {
                    $ins[] = [
                        'learning_material_id' => $learningMaterialId,
                        'lang' => $row['lang'] ?? $row['language'] ?? null,
                        'ethics_declaration' => $row['ethics_declaration'] ?? $row['ethics_statement'] ?? null,
                        'supporting_institution' => $row['supporting_institution'] ?? null,
                        'thanks_description' => $row['thanks_description'] ?? $row['acknowledgments'] ?? null,
                        'project_number' => $row['project_number'] ?? $projectNo ?? null,
                    ];
                }

                if ($ins && $this->extraInfo->insertBatch($ins) === false) {
                    $errors = $this->extraInfo->errors() ?: ['db' => 'Bilinmeyen hata'];
                    $lastQuery = (string) $this->extraInfo->db->getLastQuery();
                    throw new \RuntimeException(
                        'ExtraInfo insert failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery
                    );
                }
            }


            if (!empty($approvals)) {
                $normalizeYesNo = static function ($value): string {
                    $truthy = ['1', 1, true, 'true', 'evet', 'yes', 'on'];
                    $falsy = ['0', 0, false, 'false', 'hayir', 'hayır', 'no', null, 'off', ''];
                    $value = is_string($value) ? mb_strtolower(trim($value), 'UTF-8') : $value;

                    if (in_array($value, $truthy, true)) {
                        return 'evet';
                    }
                    if (in_array($value, $falsy, true)) {
                        return 'hayir';
                    }
                    return 'hayir';
                };

                $payload = [
                    'learning_material_id' => $learningMaterialId,
                    'rules_ok' => $normalizeYesNo($approvals['rules_ok'] ?? null),
                    'all_authors_ok' => $normalizeYesNo($approvals['all_authors_ok'] ?? null),
                    'description' => $approvals['description'] ?? null,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $existing = $this->approvals->where('learning_material_id', $learningMaterialId)->first();
                if ($existing) {
                    unset($payload['created_at']);
                    if ($this->approvals->update((int) $existing['id'], $payload) === false) {
                        $errors = $this->approvals->errors() ?: ['db' => 'Bilinmeyen hata'];
                        $lastQuery = (string) $this->approvals->db->getLastQuery();
                        throw new \RuntimeException('Approvals update failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery);
                    }
                } else {
                    if ($this->approvals->insert($payload, true) === false) {
                        $errors = $this->approvals->errors() ?: ['db' => 'Bilinmeyen hata'];
                        $lastQuery = (string) $this->approvals->db->getLastQuery();
                        throw new \RuntimeException('Approvals insert failed: ' . json_encode($errors, JSON_UNESCAPED_UNICODE) . ' | SQL: ' . $lastQuery);
                    }
                }
            }

            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new DatabaseException('Transaction failed.');
            }

            return $learningMaterialId;
        } catch (\Throwable $e) {
            $err = $db->error();
            log_message('error', '[Finalize] DB ERROR: ' . json_encode($err, JSON_UNESCAPED_UNICODE));
            throw $e;
        }
    }


}
