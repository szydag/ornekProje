<?php
namespace App\DTOs\Users;

class LoginDTO
{
    public string $email;
    public string $password;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->email    = trim((string)($data['email'] ?? ''));
        $dto->password = (string)($data['password'] ?? '');
        return $dto;
    }

    public static function rules(): array
    {
        return [
            'email'    => ['label' => 'E-posta', 'rules' => 'required|valid_email'],
            'password' => ['label' => 'Şifre',   'rules' => 'required|min_length[8]'],
        ];
    }

    public function toArray(): array
    {
        return ['email' => $this->email, 'password' => $this->password];
    }
}
