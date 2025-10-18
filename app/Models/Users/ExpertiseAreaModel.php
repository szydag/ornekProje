<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

class ExpertiseAreaModel extends Model
{
    protected $table      = 'expertise_areas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name_tr','name_en','status','sort'];

    public function asMap(): array
    {
        $rows = $this->where('status',1)->orderBy('sort','ASC')->findAll();
        $map = [];
        foreach ($rows as $r) {
            $label = $r['name_tr'] ?? $r['name_en'] ?? $r['id'];
            $map[(int)$r['id']] = $label;
        }
        return $map;
    }
}
