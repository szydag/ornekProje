<?php
declare(strict_types=1);

namespace App\Services\Courses;

use App\DTOs\Courses\UpdateCourseDTO;
use App\Models\Courses\CourseModel;
use App\Models\Courses\CourseAuthorityModel;
use App\Models\Roles\UserRoleModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;
use DateTime;

class CourseUpdateService
{
    public function __construct(
        private CourseModel $courseModel = new CourseModel(),
        private CourseAuthorityModel $authModel = new CourseAuthorityModel(),
        private UserRoleModel $userRoleModel = new UserRoleModel()
    ) {}

    /** Detay çek (güncelleme sonrası geri döndürmek için faydalı) */
    public function getById(int $id): ?array
    {
        $ency = $this->courseModel->find($id);
        if (!$ency) {
            return null;
        }

        $managerRows = $this->authModel->select('user_id')
            ->where('course_id', $id)
            ->findAll();
        $managerIds = array_map('intval', array_column($managerRows, 'user_id'));

        // Tipleri normalize ederek döndür
        return [
            'id'          => (int) $ency['id'],
            'title'       => (string) $ency['title'],
            'description' => (string) $ency['description'],
            'status'      => (int) $ency['status'],
            'start_date'  => (string) $ency['start_date'],
            'end_date'    => $ency['end_date'] !== null ? (string) $ency['end_date'] : null,
            'indefinite'  => (int) $ency['indefinite'],
            'managers'    => $managerIds,
        ];
    }

    /**
     * Kısmi güncelleme.
     * - Boş bırakılan alanlar aynen kalır.
     * - Tarih ve "indefinite" mantığı korunur.
     * - Yöneticiler: replaceManagers (tam eşitleme) veya add/remove artımlı.
     * 
     * @return array Güncellenmiş kayıt (getById formatında)
     */
    public function update(UpdateCourseDTO $dto): array
    {
        $current = $this->courseModel->find($dto->id);
        if (!$current) {
            throw new DatabaseException('Kurs bulunamadı.');
        }

        $db = Database::connect();
        $db->transStart();

        // --- Alanlar ---
        $dataToUpdate = [];

        if ($dto->title !== null) {
            $dataToUpdate['title'] = $dto->title;
        }
        if ($dto->description !== null) {
            $dataToUpdate['description'] = $dto->description;
        }

        // Tarihler
        $startDate = $current['start_date'];
        $endDate   = $current['end_date'];
        $indef     = (int) $current['indefinite'] === 1;

        if ($dto->startDate !== null) {
            $startDate = (new DateTime($dto->startDate))->format('Y-m-d');
            $dataToUpdate['start_date'] = $startDate;
        }

        if ($dto->indefinite !== null) {
            $indef = (bool) $dto->indefinite;
            $dataToUpdate['indefinite'] = $indef ? 1 : 0;
            if ($indef) {
                $endDate = null;
                $dataToUpdate['end_date'] = null;
            }
        }

        // end_date alanı spesifik yönetim:
        // - indefinite true ise null'lanmış olmalı
        // - indefinite false ve dto->endDate verilmişse set et
        if (!$indef) {
            if ($dto->endDate !== null) {
                // "endDate gönderildi ve indefinite=false" → set et (explicit null göndermek end_date'i null'lar)
                $endDate = $dto->endDate !== '' ? (new DateTime($dto->endDate))->format('Y-m-d') : null;
                $dataToUpdate['end_date'] = $endDate;
            }
        }

        // Tutarlılık: end_date < start_date olamaz
        if ($endDate !== null && $startDate !== null) {
            if ($endDate < $startDate) {
                $db->transRollback();
                throw new DatabaseException('end_date cannot be earlier than start_date.');
            }
        }

        // DB update (varsa)
        if (!empty($dataToUpdate)) {
            $ok = $this->courseModel->update($dto->id, $dataToUpdate);
            if (!$ok) {
                $db->transRollback();
                throw new DatabaseException('Kurs güncellenemedi.');
            }
        }

        // --- Yöneticiler ---
        // replaceManagers: tam eşitleme
        if ($dto->replaceManagers === true) {
            if (!is_array($dto->managerIds)) {
                $db->transRollback();
                throw new DatabaseException('managerIds is required when replaceManagers=true.');
            }
            $newManagerIds = array_map('intval', $dto->managerIds);
            // role_id=1 filtresi
            $validNew = $this->userRoleModel->filterOnlyManagers($newManagerIds, 1);

            // Mevcutları çek
            $existingRows = $this->authModel
                ->select('user_id')
                ->where('course_id', $dto->id)
                ->findAll();
            $existing = array_map('intval', array_column($existingRows, 'user_id'));

            // Ekle / Sil farkı
            $toAdd = array_values(array_diff($validNew, $existing));
            $toDel = array_values(array_diff($existing, $validNew));

            // Sil
            if (!empty($toDel)) {
                $this->authModel->where('course_id', $dto->id)
                    ->whereIn('user_id', $toDel)
                    ->delete();
            }
            // Ekle
            if (!empty($toAdd)) {
                $bulk = [];
                foreach ($toAdd as $uid) {
                    $bulk[] = [
                        'course_id' => $dto->id,
                        'user_id'         => $uid,
                    ];
                }
                $this->authModel->insertBatch($bulk);
            }
        } else {
            // Artımlı ekleme/çıkarma opsiyonu
            if (is_array($dto->addManagerIds) && !empty($dto->addManagerIds)) {
                $add = $this->userRoleModel->filterOnlyManagers(array_map('intval', $dto->addManagerIds), 2);

                if (!empty($add)) {
                    // Mevcutta var olanları ayıkla
                    $existingRows = $this->authModel->select('user_id')
                        ->where('course_id', $dto->id)
                        ->whereIn('user_id', $add)
                        ->findAll();
                    $already = array_map('intval', array_column($existingRows, 'user_id'));

                    $toInsert = array_values(array_diff($add, $already));
                    if (!empty($toInsert)) {
                        $rows = [];
                        foreach ($toInsert as $uid) {
                            $rows[] = [
                                'course_id' => $dto->id,
                                'user_id'         => $uid,
                            ];
                        }
                        $this->authModel->insertBatch($rows);
                    }
                }
            }

            if (is_array($dto->removeManagerIds) && !empty($dto->removeManagerIds)) {
                $remove = array_map('intval', $dto->removeManagerIds);
                if (!empty($remove)) {
                    $this->authModel->where('course_id', $dto->id)
                        ->whereIn('user_id', $remove)
                        ->delete();
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new DatabaseException('Kurs güncellenirken işlem başarısız oldu.');
        }

        $updated = $this->getById($dto->id);
        if (!$updated) {
            throw new DatabaseException('Güncellenmiş kurs yüklenemedi.');
        }

        return $updated;
    }
}
