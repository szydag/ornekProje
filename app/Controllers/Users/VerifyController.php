<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\VerifyDTO;
use App\Services\Users\RegisterService;

class VerifyController extends BaseController
{
    public function __construct(private RegisterService $service = new RegisterService()) {}

    public function form()
    {
        $email = $this->request->getGet('email') ?? (session('pending_register.email') ?? '');
        return view('/auth/twoFactor', ['email' => $email]);
    }

    public function verify2fa()
    {
        $data = $this->request->getPost();
        $dto  = VerifyDTO::fromArray($data);
        $res  = $this->service->verifyAndCreate($dto);

        if ($res['success']) {
            return redirect()
                ->to('auth/profileCompletion')
                ->with('success', $res['message'] ?? 'Kayıt başarılı! Profil bilgilerinizi tamamlayın.');
        }

        return redirect()->back()->with('error', $res['message'] ?? 'Hata oluştu');
    }
}
