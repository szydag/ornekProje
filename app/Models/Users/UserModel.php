<?php

namespace App\Models\Users;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'surname',
        'mail',
        'password',
        'title_id',
        'country_id',
        'phone',
        'kvkk_illumination_approval',
        'kvkk_consent_approval',
        'institution_id',
        'wants_institution',
        'created_at',
        'updated_at',
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = null;

    // Validation kuralları (opsiyonel)
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'surname' => 'required|min_length[2]|max_length[100]',
        'mail' => 'required|valid_email|is_unique[users.mail,id,{id}]',
        'password' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'mail' => [
            'is_unique' => 'Bu e-posta adresi zaten kayıtlı.',
        ],
        'password' => [
            'min_length' => 'Şifre en az 6 karakter olmalı.',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    public function getUserRoleIn(int $userId): array
    {
        return $this->db->table('user_roles ur')
            ->select('ur.role_id, r.role_name')
            ->join('roles r', 'r.id = ur.role_id')
            ->where('ur.user_id', $userId)
            ->get()
            ->getResultArray();
    }



}
