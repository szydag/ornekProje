<?php
namespace App\DTOs\Users;

class VerifyDTO
{
    public string $email;
    public string $code; // 6 haneli veya token

    public static function fromArray(array $data): self
    {
        $dto = new self();
       $dto->email = trim((string)($data['email'] ?? ''));
        // View’dan 6 kutucuk geliyorsa birleştir:
        if (isset($data['code'])) {
            $dto->code = trim((string)$data['code']);
        } else {
            $parts = [];
            for ($i=0; $i<=5; $i++) {
                if (isset($data["code_$i"])) $parts[] = (string)$data["code_$i"];
            }
            $dto->code = implode('', $parts);
        }
        return $dto;
    }

    public static function rules(): array
    {
        return [
            'email' => ['label' => 'E-posta', 'rules' => 'required|valid_email'],
            'code'  => ['label' => 'Kod',     'rules' => 'required|min_length[4]|max_length[64]'],
        ];
    }

    public function toArray(): array
    {
        return ['email' => $this->email, 'code' => $this->code];
    }
}
