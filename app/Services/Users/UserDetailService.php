<?php
// app/Services/Users/UserDetailService.php
declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Users\UserDetailDTO;
use App\Helpers\EncryptHelper;
use CodeIgniter\Database\BaseConnection;
use function db_connect;

final class UserDetailService
{
    private BaseConnection $db;

    public function __construct(?BaseConnection $db = null)
    {
        $this->db = $db ?? db_connect();
    }

    public function build(int $userId): UserDetailDTO
    {
        $user      = $this->fetchUserSummary($userId);
        $roleNames = $this->fetchRoleMap();
        $roles     = $this->fetchUserRoles($userId);

        // View “$roleNames[$user['role']]” çağırdığı için güvenli fallback ekleyelim.
        $roleNames[0] ??= 'Rol Tanımsız';
        $user['role'] = $roles[0]['id'] ?? 0;

        return new UserDetailDTO(
            user: $user,
            roleNames: $roleNames,
            userContents: $this->fetchContents($userId),
            userCourses: $this->fetchCourses($userId),
        );
    }

    private function fetchUserSummary(int $userId): array
    {
        $row = $this->db->table('users u')
            ->select([
                'u.id',
                'u.name',
                'u.surname',
                'u.mail',
                'u.phone',
                'u.created_at',
                't.name AS title_name',
                'c.name AS country_name',
                'i.name AS institution_name',
                'i.city AS institution_city',
            ])
            ->join('titles t', 't.id = u.title_id', 'left')
            ->join('countries c', 'c.id = u.country_id', 'left')
            ->join('institutions i', 'i.id = u.institution_id', 'left')
            ->where('u.id', $userId)
            ->get()
            ->getRowArray();

        if (!$row) {
            throw new \RuntimeException('User not found');
        }

        $fullName = trim(($row['name'] ?? '') . ' ' . ($row['surname'] ?? ''));

        return [
            'id'         => (int) $row['id'],
            'name'       => $fullName !== '' ? $fullName : ($row['name'] ?? ''),
            'email'      => $row['mail'] ?? null,
            'phone'      => $row['phone'] ?? null,
            'title'      => $row['title_name'] ?? null,
            'institution'=> $row['institution_name'] ?? null,
            'country'    => $row['country_name'] ?? null,
            'city'       => $row['institution_city'] ?? null,
            'created_at' => $row['created_at'] ?? null,
        ];
    }

    private function fetchRoleMap(): array
    {
        $rows = $this->db->table('roles')
            ->select('id, role_name')
            ->orderBy('role_name', 'ASC')
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($rows as $row) {
            if (!isset($row['id'])) {
                continue;
            }
            $map[(int) $row['id']] = $row['role_name'] ?? '';
        }

        return $map;
    }

    private function fetchUserRoles(int $userId): array
    {
        $rows = $this->db->table('user_roles ur')
            ->select('r.id, r.role_name')
            ->join('roles r', 'r.id = ur.role_id', 'left')
            ->where('ur.user_id', $userId)
            ->orderBy('r.role_name', 'ASC')
            ->get()
            ->getResultArray();

        $out = [];
        foreach ($rows as $row) {
            if (!isset($row['id'])) {
                continue;
            }
            $out[] = [
                'id'   => (int) $row['id'],
                'name' => $row['role_name'] ?? '',
            ];
        }

        return $out;
    }

    private function fetchContents(int $userId): array
    {
        $rows = $this->db->table('contents a')
            ->select('a.id, a.created_at, a.status, a.first_language')
            ->where('a.user_id', $userId)
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();

        if (!$rows) {
            return [];
        }

        $contentIds = array_map(
            static fn (array $row): int => (int) $row['id'],
            $rows
        );

        $translations = $this->db->table('learning_material_translations')
            ->select('content_id, lang, title, short_title')
            ->whereIn('content_id', $contentIds)
            ->get()
            ->getResultArray();

        $byContent = [];
        foreach ($translations as $trans) {
            $aid  = (int) $trans['content_id'];
            $lang = (string) $trans['lang'];
            $byContent[$aid][$lang] = $trans;
        }

        $items = [];
        foreach ($rows as $row) {
            $aid   = (int) $row['id'];
            $langs = $byContent[$aid] ?? [];

            $preferredLang = $row['first_language'] ?? '';
            $trans         = $preferredLang && isset($langs[$preferredLang])
                ? $langs[$preferredLang]
                : ($langs['tr'] ?? ($langs['en'] ?? (reset($langs) ?: [])));

            $title = $trans['title'] ?? $trans['short_title'] ?? ('Başlıksız Eğitim İçeriği #' . $aid);

            $items[] = [
                'id'             => $aid,
                'encrypted_id'   => EncryptHelper::encrypt((string) $aid),
                'title'          => $title,
                'created_at'     => $row['created_at'] ?? null,
                'status'         => $row['status'] ?? null,
                'status_color'   => $this->statusToBadge((string) ($row['status'] ?? '')),
            ];
        }

        return $items;
    }

    private function fetchCourses(int $userId): array
    {
        $rows = $this->db->table('course_authorities ea')
            ->select('e.id, e.title, e.status, e.created_at')
            ->join('courses e', 'e.id = ea.course_id', 'inner')
            ->where('ea.user_id', $userId)
            ->orderBy('e.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $items = [];
        foreach ($rows as $row) {
            $eid = isset($row['id']) ? (int) $row['id'] : 0;
            if ($eid <= 0) {
                continue;
            }

            $items[] = [
                'id'             => $eid,
                'encrypted_id'   => EncryptHelper::encrypt((string) $eid),
                'name'           => $row['title'] ?? '',
                'created_at'     => $row['created_at'] ?? null,
                'status'         => $row['status'] ?? null,
                'status_color'   => $this->statusToBadge((string) ($row['status'] ?? '')),
            ];
        }

        return $items;
    }

    private function statusToBadge(string $status): string
    {
        $normalized = mb_strtolower(trim($status));
        $map = [
            '1'         => 'success',
            '0'         => 'secondary',
            'aktif'     => 'success',
            'active'    => 'success',
            'yayınlandı'=> 'success',
            'yayinda'   => 'success',
            'yayında'   => 'success',
            'taslak'    => 'muted',
            'draft'     => 'muted',
            'inceleme'  => 'warning',
            'review'    => 'warning',
            'beklemede' => 'warning',
            'archived'  => 'secondary',
        ];

        return $map[$normalized] ?? 'primary';
    }
}
