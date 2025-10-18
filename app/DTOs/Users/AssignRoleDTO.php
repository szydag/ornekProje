<?php
// app/DTOs/Users/AssignRoleDTO.php
namespace App\DTOs\Users;

final class AssignRoleDTO
{
    public int $user_id;
    public int $role_id;

    public static function fromArray(array $data): self
    {
        $d = new self();
        $d->user_id = (int) ($data['user_id'] ?? 0);
        $d->role_id = (int) ($data['role_id'] ?? 0);
        return $d;
    }

    public function validate(): array
    {
        $errors = [];
        if ($this->user_id <= 0) $errors['user_id'] = 'Geçersiz kullanıcı.';
        if ($this->role_id <= 0) $errors['role_id'] = 'Geçersiz rol.';
        return $errors;
    }
}
