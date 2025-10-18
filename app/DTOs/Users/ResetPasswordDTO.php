<?php
// app/DTOs/Auth/ResetPasswordDTO.php
declare(strict_types=1);

namespace App\DTOs\Users;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class ResetPasswordDTO
{
    public function __construct(
        public readonly string $token,
        public readonly string $password,
        public readonly string $passwordConfirm
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $token = (string)($r->getPost('token') ?? '');
        $pass  = (string)($r->getPost('password') ?? '');
        $conf  = (string)($r->getPost('password_confirm') ?? '');

        if ($token === '') {
            throw new DtoValidationException('Geçersiz bağlantı.');
        }
        if ($pass === '' || strlen($pass) < 8) {
            throw new DtoValidationException('Şifre en az 8 karakter olmalı.');
        }
        if ($pass !== $conf) {
            throw new DtoValidationException('Şifreler eşleşmiyor.');
        }

        return new self($token, $pass, $conf);
    }
}
