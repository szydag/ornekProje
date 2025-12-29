<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

class InstitutionModel extends Model
{
    protected $table = 'institutions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'name',
        'type_id', // bazen 'institution_type_id' olarak da geçebilir, db şemasına göre 'type_id'
        'country_id',
        'city',
        'created_at',
        'updated_at',
        'status',
    ];

    public function asMap(): array
    {
        $builder = $this->builder()->select('id, name');

        if ($this->db->fieldExists('status', $this->table)) {
            $builder->where('status', 1);
        }

        $builder->orderBy('name', 'ASC');

        $rows = $builder->get()->getResultArray();
        $map = [];

        foreach ($rows as $row) {
            if (!isset($row['id'])) {
                continue;
            }
            $map[(int) $row['id']] = $row['name'] ?? '';
        }

        return $map;
    }

    public function nameById(int $id): ?string
    {
        if ($id <= 0) {
            return null;
        }

        $row = $this->select('name')->find($id);
        return $row['name'] ?? null;
    }
}




