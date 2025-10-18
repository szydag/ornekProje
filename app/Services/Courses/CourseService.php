<?php
declare(strict_types=1);

namespace App\Services\Courses;

use App\DTOs\Courses\CreateCourseDTO;
use App\DTOs\Courses\AssignManagersDTO;
use App\Models\Courses\CourseModel;
use App\Models\Courses\CourseAuthorityModel;
use App\Models\Roles\UserRoleModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;
use DateTime;

class CourseService
{
    public function __construct(
        private CourseModel $courseModel = new CourseModel(),
        private CourseAuthorityModel $authModel = new CourseAuthorityModel(),
        private UserRoleModel $userRoleModel = new UserRoleModel()
    ) {}

    /**
     * @return array{id:int,title:string,description:string,status:int,start_date:string,end_date:?string,indefinite:int,managers:int[]}
     * @throws DatabaseException
     */
    public function create(CreateCourseDTO $dto): array
    {
        // managerIds doğrula (role_id=1 filtrele)
        $validManagerIds = $this->userRoleModel->filterOnlyManagers($dto->managerIds, 2);
        if (empty($validManagerIds)) {
            throw new DatabaseException('No valid managers found with role_id=2.');
        }

        // tarih normalizasyonu
        $startDate = (new DateTime($dto->startDate))->format('Y-m-d');
        $endDate   = null;

        if (!$dto->indefinite && $dto->endDate) {
            $endDate = (new DateTime($dto->endDate))->format('Y-m-d');
            if ($endDate < $startDate) {
                throw new DatabaseException('end_date cannot be earlier than start_date.');
            }
        }

        $db = Database::connect();
        $db->transStart();

        // timestamps otomatik değilse elle set edelim (migration durumuna göre)
        $now = (new DateTime())->format('Y-m-d H:i:s');

        // Kurs insert
        $encyId = $this->courseModel->insert([
            'title'       => $dto->title,
            'description' => $dto->description,
            'status'      => 1,
            'start_date'  => $startDate,
            'end_date'    => $dto->indefinite ? null : $endDate,
            'indefinite'  => $dto->indefinite ? 1 : 0,
            // eğer useTimestamps=false ise:
            // 'created_at'  => $now,
        ], true);

        if (!$encyId) {
            $db->transRollback();
            throw new DatabaseException('Failed to insert course record.');
        }

        // Yetkiler insert (bulk)
        $bulk = [];
        foreach ($validManagerIds as $uid) {
            $row = [
                'course_id' => $encyId,
                'user_id'         => $uid,
            ];
            // eğer model useTimestamps=true değilse:
            // $row['created_at'] = $now;

            $bulk[] = $row;
        }

        if (!empty($bulk)) {
            $this->authModel->insertBatch($bulk);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new DatabaseException('Transaction failed while creating course.');
        }

        return [
            'id'          => (int) $encyId,
            'title'       => $dto->title,
            'description' => $dto->description,
            'status'      => 1,
            'start_date'  => $startDate,
            'end_date'    => $dto->indefinite ? null : $endDate,
            'indefinite'  => $dto->indefinite ? 1 : 0,
            'managers'    => $validManagerIds,
        ];
    }

    /**
     * Var olan bir kursa yöneticiler ekler (duplicate engeller).
     * @return array{course_id:int, added:int[], skipped:int[]}
     */
    public function assignManagers(AssignManagersDTO $dto): array
    {
        // kurs var mı?
        $course = $this->courseModel->find($dto->courseId);
        if (!$course) {
            throw new DatabaseException('Kurs bulunamadı.');
        }

        $validManagerIds = $this->userRoleModel->filterOnlyManagers($dto->managerIds, 2);
        if (empty($validManagerIds)) {
            throw new DatabaseException('No valid managers found with role_id=2.');
        }

        // zaten atanmışları ayıkla
        $existing = $this->authModel->where('course_id', $dto->courseId)
            ->whereIn('user_id', $validManagerIds)
            ->findAll();

        $existingIds = array_column($existing, 'user_id');
        $toInsert    = array_values(array_diff($validManagerIds, $existingIds));

        $added = [];
        if (!empty($toInsert)) {
            $rows = [];
            foreach ($toInsert as $uid) {
                $rows[] = [
                    'course_id' => $dto->courseId,
                    'user_id'         => $uid,
                ];
            }
            $this->authModel->insertBatch($rows);
            $added = $toInsert;
        }

        return [
            'course_id' => (int) $dto->courseId,
            'added'           => $added,
            'skipped'         => $existingIds,
        ];
    }
}
