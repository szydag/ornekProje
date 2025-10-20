<?php
// app/DTOs/Users/UserDetailDTO.php
declare(strict_types=1);

namespace App\DTOs\Users;

final class UserDetailDTO
{
    public function __construct(
        public readonly array $user,
        public readonly array $roleNames,
        public readonly array $userContents,
        public readonly array $userCourses,
    ) {}

    public function toArray(): array
    {
        return [
            'user'              => $this->user,
            'roleNames'         => $this->roleNames,
            'userContents'      => $this->userContents,
            'userCourses' => $this->userCourses,
        ];
    }
}
