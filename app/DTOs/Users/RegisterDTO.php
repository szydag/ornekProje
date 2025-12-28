<?php
namespace App\DTOs\Users;

class RegisterDTO
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $password_repeat;
    public ?int $kvkk_consent;
    public ?int $kvkk_explicit_consent;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->first_name            = trim((string)($data['first_name'] ?? ''));
        $dto->last_name             = trim((string)($data['last_name'] ?? ''));
        $dto->email                 = trim((string)($data['email'] ?? ''));
        $dto->password              = (string)($data['password'] ?? '');
        $dto->password_repeat       = (string)($data['password_repeat'] ?? '');
        $dto->kvkk_consent          = isset($data['kvkk_consent']) ? (int)(bool)$data['kvkk_consent'] : null;
        $dto->kvkk_explicit_consent = isset($data['kvkk_explicit_consent']) ? (int)(bool)$data['kvkk_explicit_consent'] : null;
        return $dto;
    }

    public static function rules(): array
    {
        return [
            'first_name'            => ['label' => 'Ad',                 'rules' => 'required|min_length[2]|max_length[100]'],
            'last_name'             => ['label' => 'Soyad',              'rules' => 'required|min_length[2]|max_length[100]'],
            'email'                 => ['label' => 'E-posta',            'rules' => 'required|valid_email|is_unique[users.mail]'],
            'password'              => ['label' => 'Şifre',              'rules' => 'required|min_length[6]|max_length[255]'],
            'password_repeat'       => ['label' => 'Şifre (tekrar)',     'rules' => 'required|matches[password]'],
            'kvkk_consent'          => ['label' => 'KVKK Onayı',         'rules' => 'permit_empty|in_list[1]'],
            'kvkk_explicit_consent' => ['label' => 'Açık Rıza',          'rules' => 'permit_empty|in_list[1]'],
        ];
    }

    public function toArray(): array
    {
        return [
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'email'                 => $this->email,
            'password'              => $this->password,
            'password_repeat'       => $this->password_repeat,
            'kvkk_consent'          => $this->kvkk_consent,
            'kvkk_explicit_consent' => $this->kvkk_explicit_consent,
        ];
    }
}
