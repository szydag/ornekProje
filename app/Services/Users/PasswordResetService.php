<?php
// app/Services/Auth/PasswordResetService.php
declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Users\SendResetEmailDTO;
use App\DTOs\Users\ResetPasswordDTO;
use App\Models\Users\UserModel;
use App\Models\Users\PasswordResetModel;
use Config\EmailService;

final class PasswordResetService
{
    public const TOKEN_BYTES = 32; // 256-bit
    public const TTL_MIN     = 60; // dakika

    public function __construct(
        private UserModel $users = new UserModel(),
        private PasswordResetModel $resets = new PasswordResetModel(),
        private EmailService $mailer = new EmailService()
    ) {}

    /**
     * Her zaman aynı mesaj politikasıyla çalışır.
     */
    public function sendResetEmail(SendResetEmailDTO $dto): void
    {
        // email alanı senin tabloda 'mail'
        $user = $this->users->where('mail', $dto->email)->first();

        if (!$user) {
            // kullanıcı yoksa sessizce çık; controller aynı mesajı gösterecek
            return;
        }

        // İsteğe bağlı: eski aktif tokenleri iptal et
        $this->resets->invalidateAllForUser((int)$user['id']);

        // token üret
        $rawToken  = bin2hex(random_bytes(self::TOKEN_BYTES));
        $tokenHash = hash('sha256', $rawToken);
        $expires   = date('Y-m-d H:i:s', time() + self::TTL_MIN * 60);

        $this->resets->insert([
            'user_id'    => (int)$user['id'],
            'token_hash' => $tokenHash,
            'expires_at' => $expires,
        ]);

        // e-posta
        $resetUrl = base_url('/auth/reset/' . $rawToken);
        $subject  = 'Şifre Sıfırlama';
        $message  = "Merhaba,\n\nAşağıdaki düğmeye tıklayarak yeni şifrenizi belirleyebilirsiniz.\nBu bağlantı sınırlı süre geçerlidir.";
        $button   = ['url'=>$resetUrl, 'text'=>'Şifremi Sıfırla'];

        try {
            $this->mailer->mailGonder($dto->email, $subject, $message, $button);
        } catch (\Throwable $e) {
            log_message('error', 'Reset mail error: {msg}', ['msg' => $e->getMessage()]);
        }
    }

    /**
     * Token doğrula, users.password güncelle, tokeni kullanılmış işaretle.
     */
    public function resetPassword(ResetPasswordDTO $dto): void
    {
        $tokenHash = hash('sha256', $dto->token);
        $now       = date('Y-m-d H:i:s');

        $row = $this->resets->where('token_hash', $tokenHash)
                            ->where('expires_at >=', $now)
                            ->where('used_at', null)
                            ->first();

        if (!$row) {
            throw new \RuntimeException('Geçersiz veya süresi dolmuş bağlantı.');
        }

        $user = $this->users->find((int)$row['user_id']);
        if (!$user) {
            throw new \RuntimeException('Kullanıcı bulunamadı.');
        }

        $this->users->update((int)$user['id'], [
            'password' => password_hash($dto->password, PASSWORD_DEFAULT),
        ]);

        // tek kullanımlık
        $this->resets->markUsed((int)$row['id']);
        // (opsiyonel) başka aktif token varsa hepsini iptal et
        $this->resets->invalidateAllForUser((int)$user['id']);
    }
}
