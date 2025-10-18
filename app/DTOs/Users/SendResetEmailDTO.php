<?php
// app/DTOs/Auth/SendResetEmailDTO.php
declare(strict_types=1);

namespace App\DTOs\Users;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class SendResetEmailDTO
{
    public function __construct(
        public readonly string $email
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $email = trim((string)($r->getPost('email') ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new DtoValidationException('Geçerli bir e-posta girin.');
        }
        return new self($email);
    }
}
