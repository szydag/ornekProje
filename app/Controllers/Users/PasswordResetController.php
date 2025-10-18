<?php

declare(strict_types=1);

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\SendResetEmailDTO;
use App\DTOs\Users\ResetPasswordDTO;
use App\Services\Users\PasswordResetService;
use App\Exceptions\DtoValidationException;

final class PasswordResetController extends BaseController
{
    public function __construct(
        private PasswordResetService $service = new PasswordResetService()
    ) {}

    public function sendResetEmail()
    {
        try {
            $dto = SendResetEmailDTO::fromRequest($this->request);
            $this->service->sendResetEmail($dto);
            return redirect()->back()->with('error', 'Eğer adres kayıtlıysa, sıfırlama bağlantısı gönderildi.');
        } catch (DtoValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        } catch (\Throwable $e) {
            log_message('error', 'sendResetEmail fatal: {msg}', ['msg'=>$e->getMessage()]);
            return redirect()->back()->with('error', 'Beklenmeyen bir hata oluştu.')->withInput();
        }
    }

    public function showResetForm(string $rawToken)
    {
        // Doğrulamayı POST’ta yapacağız; burada sadece token’ı view’a taşırız.
        return view('/auth/resetPassword/changePassword.php', ['token' => $rawToken]);
    }

    public function handleResetPost()
    {
        try {
            $dto = ResetPasswordDTO::fromRequest($this->request);
            $this->service->resetPassword($dto);
            return redirect()->to('/auth/login')->with('error', 'Şifreniz güncellendi. Giriş yapabilirsiniz.');
        } catch (DtoValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
