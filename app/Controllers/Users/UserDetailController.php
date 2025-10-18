<?php
// app/Controllers/Users/UserDetailController.php
declare(strict_types=1);

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Services\Users\UserDetailService;
use App\Helpers\EncryptHelper;

final class UserDetailController extends BaseController
{
    public function __construct(
        private UserDetailService $service = new UserDetailService()
    ) {}

    public function show(string $encryptedId)
    {
        $id = EncryptHelper::decrypt($encryptedId);

        if ($id === false || filter_var($id, FILTER_VALIDATE_INT) === false) {
            log_message('error', 'User detail failed: invalid identifier {id}', ['id' => $encryptedId]);

            if ($this->expectsJson()) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'success' => false,
                        'error'   => 'Geçersiz kullanıcı kimliği',
                    ]);
            }

            return redirect()
                ->to('/app/users')
                ->with('error', 'Kullanıcı bulunamadı veya yüklenemedi.');
        }

        $userId = (int) $id;

        try {
            $dto = $this->service->build($userId);
            $payload = $dto->toArray();

            if ($this->expectsJson()) {
                return $this->response->setJSON([
                    'success' => true,
                    'data'    => $payload,
                ]);
            }

            return view('app/user-detail', $payload);
        } catch (\Throwable $e) {
            log_message('error', 'User detail failed: {msg}', ['msg' => $e->getMessage()]);

            if ($this->expectsJson()) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'success' => false,
                        'error'   => 'Kullanıcı bulunamadı veya yüklenemedi.',
                    ]);
            }

            return redirect()
                ->to('/app/users')
                ->with('error', 'Kullanıcı bulunamadı veya yüklenemedi.');
        }
    }

    private function expectsJson(): bool
    {
        if ($this->request->isAJAX()) {
            return true;
        }

        $accept = $this->request->getHeaderLine('Accept');
        return stripos($accept, 'application/json') !== false;
    }
}
