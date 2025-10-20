<?php
declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Courses\CourseModel;
use App\Models\Courses\CourseAuthorityModel;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\LearningMaterials\LearningMaterialTranslationsModel;
use CodeIgniter\Database\BaseConnection;

final class CourseDetailService
{
    public function __construct(
        private CourseModel $courseModel = new CourseModel(),
        private CourseAuthorityModel $authorityModel = new CourseAuthorityModel(),
        private LearningMaterialsModel $materialsModel = new LearningMaterialsModel(),
        private LearningMaterialTranslationsModel $translationsModel = new LearningMaterialTranslationsModel(),
        private ?BaseConnection $db = null,
    ) {
        $this->db ??= db_connect();
    }

    /**
     * Kurs detayını view'ın beklediği formatta döndürür.
     */
    public function getDetail(int $id): array
    {
        $dbName = $this->db->getDatabase();
        $raw = $this->db->table('courses')->where('id', $id)->get()->getRowArray();

        $viaModel = $this->courseModel->find($id);

        $ency = $raw ?: $viaModel;
        if (!$ency) {
            throw new \RuntimeException('Kurs bulunamadı. (db=' . $dbName . ', id=' . $id . ')');
        }

        $editors = $this->fetchManagers($id);

        $contents = $this->fetchContentsWithTranslationsAndAuthors($id);

        $statusColor = $this->statusToColor((string) ($ency['status'] ?? 'unknown'));

        return [
            'id' => (int) $ency['id'],
            'title' => (string) $ency['title'],
            'description' => $ency['description'] ?? null,
            'status' => $ency['status'] ?? null,
            'status_color' => $statusColor,
            'start_date' => $ency['start_date'] ?? null,
            'end_date' => $ency['end_date'] ?? null,
            'indefinite' => isset($ency['indefinite']) ? (int) $ency['indefinite'] : null,
            'editors' => $editors,
            'contents' => $contents,
        ];
    }



    private function statusToColor(string $status): string
    {
        // Hem metin hem de sayısal durumlar için basit map
        $map = [
            '1' => 'success',
            '0' => 'secondary',
            'aktif' => 'success',
            'pasif' => 'secondary',
            'taslak' => 'warning',
            'yayında' => 'primary',
            'archived' => 'secondary',
            'unknown' => 'primary',
        ];
        $key = mb_strtolower($status);
        return $map[$key] ?? 'primary';
    }

    /**
     * Yöneticileri users tablosundan çeker.
     * - name: name + surname
     * - email: users.mail
     * - *_id alanları ham id olarak döner (ileride lookup join ekleyebiliriz).
     */
    private function fetchManagers(int $encyId): array
    {
        $rows = $this->db->table('course_authorities ea')
            ->select([
                'u.id',
                'u.name',
                'u.surname',
                'u.mail',
                'u.title_id',
                'u.institution_id',
                'u.country_id',
                't.name AS title_name',
                'i.name AS institution_name',
                'c.name AS country_name',
            ])
            ->join('users u', 'u.id = ea.user_id', 'left')
            ->join('titles t', 't.id = u.title_id', 'left')
            ->join('institutions i', 'i.id = u.institution_id', 'left')
            ->join('countries c', 'c.id = u.country_id', 'left')
            ->where('ea.course_id', $encyId)
            ->get()
            ->getResultArray();

        $out = [];

        foreach ($rows as $r) {
            $fullName = trim(($r['name'] ?? '') . ' ' . ($r['surname'] ?? ''));

            $out[] = [
                'id' => (int) ($r['id'] ?? 0),
                'name' => $fullName !== '' ? $fullName : ($r['name'] ?? null),
                'email' => $r['mail'] ?? null,
                'role' => 'Yönetici',
                'title_id' => isset($r['title_id']) ? (int) $r['title_id'] : null,
                'institution_id' => isset($r['institution_id']) ? (int) $r['institution_id'] : null,
                'country_id' => isset($r['country_id']) ? (int) $r['country_id'] : null,
                'title' => $r['title_name'] ?? null,
                'institution' => $r['institution_name'] ?? null,
                'country' => $r['country_name'] ?? null,
            ];
        }

        return $out;
    }

    public function managerHasAuthority(int $encyId, int $userId): bool
    {
        if ($userId <= 0) {
            return false;
        }

        return (bool) $this->db->table('course_authorities')
            ->where('course_id', $encyId)
            ->where('user_id', $userId)
            ->countAllResults();
    }



    /**
     * Eğitim içeriklerini, first_language'a göre translations ile birleştirir ve yazarları ekler.
     */
    private function fetchContentsWithTranslationsAndAuthors(int $encyId): array
    {
        // 1) Contents
        $contents = $this->materialsModel
            ->select('id, created_at, status, user_id, first_language, course_id')
            ->where('course_id', $encyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$contents) {
            return [];
        }

        $contentIds = array_map(fn($a) => (int) $a['id'], $contents);

        // 2) Translations (first_language öncelikli)
        $transRows = $this->translationsModel
            ->whereIn('learning_material_id', $contentIds)
            ->whereIn('lang', ['tr', 'en'])
            ->select('id, learning_material_id, lang, title, short_title, self_description')
            ->findAll();

        $byContentLang = [];
        foreach ($transRows as $t) {
            $aid = (int) $t['learning_material_id'];
            $lang = (string) $t['lang'];
            $byContentLang[$aid][$lang] = $t;
        }

        // 3) Authors
        $authorRows = $this->db->table('learning_material_contributors')
            ->select('learning_material_id, name, surname,mail')
            ->whereIn('learning_material_id', $contentIds)
            ->get()->getResultArray();

        $authorsByContent = [];
        foreach ($authorRows as $ar) {
            $aid = (int) $ar['learning_material_id'];
            $authorsByContent[$aid][] = [
                'name' => $ar['name'] ?? '',
                'surname' => $ar['surname'] ?? null,
                'mail' => $ar['mail'] ?? null,
            ];
        }

        // 4) Birleştir
        $out = [];
        foreach ($contents as $a) {
            $aid = (int) $a['id'];
            $fl = (string) ($a['first_language'] ?? 'tr');

            $tran = $byContentLang[$aid][$fl]
                ?? ($byContentLang[$aid]['tr'] ?? (array) ($byContentLang[$aid]['en'] ?? []));

            $out[] = [
                'id' => $aid,
                'title' => $tran['title'] ?? null,
                'abstract' => $tran['self_description'] ?? null,
                'self_description' => $tran['self_description'] ?? null, // (opsiyonel, geriye dönük uyum)
                'created_at' => (string) $a['created_at'],
                'status' => $a['status'] ?? null,
                'status_color' => $this->statusToColor((string) ($a['status'] ?? 'unknown')),
                'authors' => $authorsByContent[$aid] ?? [],
            ];
        }

        return $out;
    }
}
