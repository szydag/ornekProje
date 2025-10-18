<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

class TitleModel extends Model
{
    protected $table      = 'titles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'status', 'sort'];

    public function asMap(): array
    {
        $builder = $this->builder()->select('id, name');

        if ($this->db->fieldExists('status', $this->table)) {
            $builder->where('status', 1);
        }

        if ($this->db->fieldExists('sort', $this->table)) {
            $builder->orderBy('sort', 'ASC');
        } else {
            $builder->orderBy('name', 'ASC');
        }

        $rows = $builder->get()->getResultArray();
        $map  = [];

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
