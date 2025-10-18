<?php
declare(strict_types=1);

namespace App\Services\Courses;

use App\DTOs\Courses\ListCoursesDTO;
use App\Models\Courses\CourseModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

final class CourseListService
{
    public function __construct(
        private CourseModel $model = new CourseModel()
    ) {}

    /**
     * @return array{
     *   total:int,
     *   items:array<int, array{id:int,title:string,description:?string,status:?string,start_date:?string,end_date:?string,indefinite:?int,created_at:?string,updated_at:?string}>
     * }
     */
    public function listAll(ListCoursesDTO $dto, ?int $managerUserId = null): array
    {
        try {
            $builder = $this->model
                ->select([
                    'encyclopedias.id AS id',
                    'encyclopedias.title AS title',
                    'encyclopedias.description AS description',
                    'encyclopedias.status AS status',
                    'encyclopedias.start_date AS start_date',
                    'encyclopedias.end_date AS end_date',
                    'encyclopedias.indefinite AS indefinite',
                    'encyclopedias.created_at AS created_at',
                    'encyclopedias.updated_at AS updated_at'
                ]);

            if ($managerUserId !== null) {
                $builder
                    ->join('course_authorities ea', 'ea.course_id = encyclopedias.id', 'inner')
                    ->where('ea.user_id', $managerUserId)
                    ->distinct();
            }

            $builder->orderBy('encyclopedias.' . $dto->orderBy, $dto->orderDir);

            // Toplam kayıt
            $total = $builder->countAllResults(false);

            // Sayfalama uygula (opsiyonel)
            if ($dto->limit !== null) {
                $builder->limit($dto->limit, $dto->offset ?? 0);
            }

            $items = $builder->get()->getResultArray();

            return [
                'total' => $total,
                'items' => $items,
            ];
        } catch (DatabaseException $e) {
            // Controller yakalayıp JSON döndürecek
            throw $e;
        }
    }

}
