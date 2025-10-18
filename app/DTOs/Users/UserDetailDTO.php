<?php
// app/DTOs/Users/UserDetailDTO.php
declare(strict_types=1);

namespace App\DTOs\Users;

final class UserDetailDTO
{
    public function __construct(
        public readonly array $user,
        public readonly array $roleNames,
        public readonly array $userArticles,
        public readonly array $userEncyclopedias,
    ) {}

    public function toArray(): array
    {
        return [
            'user'              => $this->user,
            'roleNames'         => $this->roleNames,
            'userArticles'      => $this->userArticles,
            'userEncyclopedias' => $this->userEncyclopedias,
        ];
    }
}
