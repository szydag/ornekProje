<?php
namespace App\Services\Users;

use App\DTOs\Users\LoginDTO;
use App\Models\Users\UserModel;
use App\Services\LearningMaterials\ContentEditorService;

class LoginService
{
    public function __construct(private UserModel $users = new UserModel())
    {
    }

    /**
     * @return array{success:bool, message?:string, data?:array, errors?:array}
     */
    public function login(LoginDTO $dto): array
    {
        $validation = service('validation');
        $validation->setRules(LoginDTO::rules());
        if (!$validation->run($dto->toArray())) {
            return ['success' => false, 'message' => 'Doğrulama hatası', 'errors' => $validation->getErrors()];
        }

        $user = $this->users->where('mail', $dto->email)->first();
        if (!$user) {
            return ['success' => false, 'message' => 'E-posta veya şifre hatalı.'];
        }

        if (!password_verify($dto->password, $user['password'] ?? '')) {
            return ['success' => false, 'message' => 'E-posta veya şifre hatalı.'];
        }

        $profileCompleted = $this->isProfileComplete($user);

        $roles = $this->users->db->table('user_roles')
            ->select('role_id')
            ->where('user_id', $user['id'])
            ->get()
            ->getResultArray();

        $roleId = 0;
        if ($roles) {
            foreach ($roles as $r) {
                if ((int) ($r['is_primary'] ?? 0) === 1) {
                    $roleId = (int) $r['role_id'];
                    break;
                }
            }
            if ($roleId === 0) {
                $priority = [2, 5, 4, 1]; // admin, editor, reviewer, author
                $owned = array_map(static fn(array $r) => (int) $r['role_id'], $roles);
                foreach ($priority as $p) {
                    if (in_array($p, $owned, true)) {
                        $roleId = $p;
                        break;
                    }
                }
                if ($roleId === 0 && !empty($owned)) {
                    $roleId = $owned[0];
                }
            }
        }

        $editorService = new ContentEditorService();
        $editorService->attachUserToAssignments((int) $user['id'], (string) $user['mail']);
        $hasEditorAssignments = $editorService->userHasAssignments((int) $user['id'], (string) $user['mail']);
        
        // Session ayarları
        session()->regenerate(); // Güvenlik için session'ı yenile
        session()->set([
            'user_id' => (int) $user['id'],
            'user_email' => $user['mail'],
            'user_name' => ($user['name'] ?? '') . ' ' . ($user['surname'] ?? ''),
            'role_id' => $roleId,
            'profile_completed' => $profileCompleted,
            'has_editor_assignments' => $hasEditorAssignments,
            'is_logged_in' => true,
            'login' => true,
        ]);

        return [
            'success' => true,
            'message' => 'Giriş başarılı.',
            'data' => [
                'id' => (int) $user['id'],
                'name' => $user['name'] ?? '',
                'surname' => $user['surname'] ?? '',
                'email' => $user['mail'],
                'role_id' => $roleId,
                'profile_completed' => $profileCompleted,
            ],
        ];
    }

    private function isProfileComplete(array $user): bool
    {
        return !empty($user['phone'])
            && !empty($user['country_id'])
            && !empty($user['title_id']);
    }
}
