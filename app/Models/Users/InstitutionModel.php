<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

class InstitutionModel extends Model
{
    protected $table         = 'institutions';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'name',
        'type_id',
        'country_id',
        'city',
        'created_at',
        'updated_at',
    ];

    public function asMap(): array
    {
        $rows = $this->select('id, name')->findAll();
        $map = [];
        foreach ($rows as $row) {
            $map[$row['id']] = $row['name'];
        }
        return $map;
    }
}



