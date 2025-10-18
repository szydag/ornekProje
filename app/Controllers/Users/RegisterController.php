<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\RegisterDTO;
use App\Services\Users\RegisterService;

class RegisterController extends BaseController
{
    public function __construct(private RegisterService $service = new RegisterService()) {}

    public function register()
    {
        // Form gönderimlerinden sadece POST verisini al
        $data = $this->request->getPost();
        $dto  = RegisterDTO::fromArray($data);
        
        // Email doğrulama olmadan direkt kullanıcı oluştur
        $res = $this->service->createUserDirectly($dto);

        if ($res['success']) {
            // Kullanıcıyı login yap
            session()->set([
                'user_id' => $res['user_id'],
                'user_name' => $res['user_name'],
                'user_email' => $dto->email,
                'is_logged_in' => true
            ]);

            return redirect()
                ->to('/')
                ->with('success', 'Kayıt başarılı! Hoş geldiniz.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $res['message'] ?? 'Form hatalı')
            ->with('errors', $res['errors'] ?? []);
    }
}
