<?php declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Users\ProfileCompleteDTO;
use App\Models\Users\UserModel;
use App\Models\Users\InstitutionModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

final class ProfileCompletionService
{
    public function __construct(
        private UserModel $users = new UserModel(),
        private InstitutionModel $institutions = new InstitutionModel(),
    ) {
    }

    /** @return array{success:bool, message?:string} */
    public function complete(int $userId, ProfileCompleteDTO $dto): array
    {
        if ($userId <= 0) {
            return ['success' => false, 'message' => 'Kullanıcı oturumu bulunamadı.'];
        }

        $db = db_connect();
        $db->transBegin();

        try {
            // Helper: country code -> id
            $resolveCountryId = static function (?string $code) use ($db): ?int {
                if (!$code)
                    return null;
                $row = $db->table('countries')
                    ->select('id')
                    ->where('code', strtoupper(trim($code)))
                    ->get()
                    ->getFirstRow('array');
                return isset($row['id']) ? (int) $row['id'] : null;
            };

            $institutionId = null;

            if ($dto->add_institution) {
                // institution_type_id: mümkünse sayısal ID beklenir
                $typeId = is_numeric($dto->inst_type ?? null) ? (int) $dto->inst_type : null;

                $countryIdForInstitution = $resolveCountryId($dto->inst_country);

                // Boş/invalid ad için temel kontrol
                $name = trim((string) ($dto->inst_name ?? ''));
                if ($name === '') {
                    throw new DatabaseException('Kurum adı boş olamaz.');
                }

                // City boş stringse null yap
                $city = ($dto->inst_city !== null && trim((string) $dto->inst_city) !== '')
                    ? trim((string) $dto->inst_city)
                    : null;

                $newId = $this->institutions->insert([
                    'name' => $name,
                    'institution_type_id' => $typeId,
                    'country_id' => $countryIdForInstitution,
                    'city' => $city,
                ], true);

                if (!$newId) {
                    throw new DatabaseException('Kurum kaydı oluşturulamadı.');
                }
                $institutionId = (int) $newId;

            } elseif ($dto->no_institution) {
                $institutionId = null;

            } else {
                $institutionId = $dto->institution_id !== null
                    ? (int) $dto->institution_id
                    : null;
            }

            // User country: kod -> id
            $userCountryId = $resolveCountryId($dto->country_id);

            // Nullable title_id: boş ise null, değilse int
            $titleId = isset($dto->title_id) && $dto->title_id !== ''
                ? (int) $dto->title_id
                : null;

            $ok = $this->users->update($userId, [
                'phone' => $dto->phone !== null ? trim((string) $dto->phone) : null,
                'title_id' => $titleId,
                'country_id' => $userCountryId,
                'institution_id' => $institutionId,
                'wants_institution' => $dto->add_institution ? 1 : 0,
            ]);
            /* log_message('debug', 'User update SQL: ' . (string) $this->users->db->getLastQuery());
             log_message('debug', 'User update errors: ' . json_encode($this->users->errors(), JSON_UNESCAPED_UNICODE));*/
            if (!$ok) {
                $err = $this->users->errors();
                throw new DatabaseException(
                    'Kullanıcı güncellenemedi: ' . json_encode($err, JSON_UNESCAPED_UNICODE)
                );
            }

            $db->transCommit();
            return ['success' => true, 'message' => 'Profiliniz başarıyla güncellendi.'];

        } catch (\Throwable $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }
            log_message('error', 'Profile complete failed: {msg}', ['msg' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Kayıt sırasında hata oluştu: ' . $e->getMessage()];
        }
    }
}
