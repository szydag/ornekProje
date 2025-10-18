<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table      = 'countries';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'code'];

    public function asRichMap(): array
    {
        $rows = $this->builder()
            ->select('code, name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($rows as $row) {
            $code = $row['code'] ?? null;
            if (!$code) {
                continue;
            }

            $map[$code] = [
                'name' => $row['name'] ?? '',
                'flag' => '',
            ];
        }

        return $map;
    }

    public function nameByCode(?string $code): ?string
    {
        if (!$code) {
            return null;
        }

        $row = $this->builder()
            ->select('name')
            ->where('code', $code)
            ->get()
            ->getRowArray();

        return $row['name'] ?? null;
    }
}
