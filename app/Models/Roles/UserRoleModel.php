<?php
declare(strict_types=1);

namespace App\Models\Roles;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table            = 'user_roles';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'role_id'];

    public function getManagers(int $roleId = 1, ?string $q = null, int $limit = 50, int $offset = 0): array
    {
        $builder = $this->db->table('user_roles ur')
            ->select('u.id, u.name, u.surname, u.mail')
            ->join('users u', 'u.id = ur.user_id', 'inner')
            ->where('ur.role_id', $roleId);

        if ($q) {
            $builder->groupStart()
                ->like('u.name', $q)
                ->orLike('u.surname', $q)
                ->orLike('u.mail', $q)
            ->groupEnd();
        }

        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    /** Verilen user_id’lerin role_id=1 olup olmadığını topluca doğrular */
    public function filterOnlyManagers(array $userIds, int $roleId = 1): array
    {
        if (empty($userIds)) return [];

        $rows = $this->db->table('user_roles')
            ->select('user_id')
            ->where('role_id', $roleId)
            ->whereIn('user_id', $userIds)
            ->get()->getResultArray();

        return array_values(array_unique(array_column($rows, 'user_id')));
    }
}
