<?php
namespace App\Services\Users;

use App\DTOs\Users\RegisterDTO;
use App\DTOs\Users\VerifyDTO;
use App\Models\Users\UserModel;
use App\Models\Users\EmailVerificationModel;
use App\Services\Articles\ArticleEditorService;
use CodeIgniter\Database\Exceptions\DatabaseException;

class RegisterService
{
    public function __construct(
        private UserModel $users = new UserModel(),
        private EmailVerificationModel $verifs = new EmailVerificationModel(),
    ) {
    }

    /**
     * 1) Kayıt başlat: doğrula → 6 haneli kod üret → email_verifications(pending) → e-posta gönder
     */
    public function start(RegisterDTO $dto): array
    {
        $validation = service('validation');
        $validation->setRules(RegisterDTO::rules());
        if (!$validation->run($dto->toArray())) {
            return ['success' => false, 'errors' => $validation->getErrors(), 'message' => 'Doğrulama hatası'];
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->verifs->insert([
            'email' => $dto->email,
            'code' => $code,
            'date' => date('Y-m-d H:i:s'),
            'status' => 'pending',
        ]);

        $this->sendVerificationMail($dto->email, $code);

        return [
            'success' => true,
            'message' => 'Doğrulama kodu e-posta adresinize gönderildi.',
        ];
        // Not: RegisterController başarılı olunca pending_register'ı session'a yazar ve verify sayfasına yönlendirir.
    }

    /**
     * 2) Kod doğrula → kullanıcı oluştur → verif kaydını "verified" yap
     * Yalnızca web formu (POST) + session(pending_register) ile çalışır.
     */
    public function verifyAndCreate(VerifyDTO $dto): array
    {
        $validation = service('validation');
        $validation->setRules(VerifyDTO::rules());
        if (!$validation->run($dto->toArray())) {
            return ['success' => false, 'errors' => $validation->getErrors(), 'message' => 'Doğrulama hatası'];
        }

        // Son gönderilen pending kaydı ve kodu kontrol et
        $record = $this->verifs->getLatestPending($dto->email);
        if (!$record || $record['code'] !== $dto->code) {
            return ['success' => false, 'message' => 'Geçersiz kod veya kayıt bulunamadı.'];
        }

        // 10 dakika içinde olmalı
        $sentAt = strtotime($record['date']);
        $expired = $sentAt === false || (time() - $sentAt) > 600;
        if ($expired) {
            $this->verifs->update($record['id'], ['status' => 'expired']);
            return ['success' => false, 'message' => 'Kodun süresi dolmuş.'];
        }

        // Zaten kullanıcı var mı?
        $existing = $this->users->where('mail', $dto->email)->first();
        if ($existing) {
            $this->verifs->update($record['id'], ['status' => 'verified']);
            session()->remove('pending_register');

            session()->regenerate();
            $sessionUserEmail = $existing['mail'] ?? $dto->email;
            session()->set([
                'user_id' => (int) $existing['id'],
                'user_email' => $sessionUserEmail,
                'user_name' => trim(($existing['name'] ?? '') . ' ' . ($existing['surname'] ?? '')),
                'role_id' => 0,
                'profile_completed' => (bool) ($existing['phone'] ?? false),
                'login' => true,
            ]);

            $editorService = new ArticleEditorService();
            $editorService->attachUserToAssignments((int) $existing['id'], (string) $sessionUserEmail);
            $hasAssignments = $editorService->userHasAssignments((int) $existing['id'], (string) $sessionUserEmail);
            session()->set('has_editor_assignments', $hasAssignments);

            return ['success' => true, 'message' => 'E-posta zaten doğrulanmış / kullanıcı mevcut.'];
        }

        // Formdan gelen (olasılık düşük) alanlar:
        $req = service('request');
        $raw = $req->getPost(); // yalnızca form tabanlı

        // Parola/ad/soyadı session’dan (pending_register) al (kayıt formunda set edildi)
        $pending = session('pending_register') ?? [];

        // Ek güvenlik: pending 30 dk içinde olmalı
        if (!empty($pending['stored_at']) && (time() - (int) $pending['stored_at']) > 1800) {
            session()->remove('pending_register');
            return ['success' => false, 'message' => 'Oturum süresi doldu. Lütfen yeniden kayıt olun.'];
        }

        // Şifre öncelik: form > session (genelde session)
        $password = (string) ($raw['password'] ?? ($pending['password'] ?? ''));
        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Parola gerekli (en az 8 karakter).'];
        }

        // İsim/soyisim öncelik: form > session
        $firstName = (string) ($raw['first_name'] ?? ($pending['first_name'] ?? ''));
        $lastName = (string) ($raw['last_name'] ?? ($pending['last_name'] ?? ''));

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $kvkkConsent = (int) ($pending['kvkk_consent'] ?? 0);
        $kvkkExplicitConsent = (int) ($pending['kvkk_explicit_consent'] ?? 0);


        try {
            $id = $this->users->insert([
                'name' => $firstName,
                'surname' => $lastName,
                'mail' => $dto->email,
                'password' => $hash,
                'kvkk_illumination_approval' => $kvkkConsent,
                'kvkk_consent_approval' => $kvkkExplicitConsent,
            ], true);

            // doğrulama kaydını güncelle
            $this->verifs->update($record['id'], ['status' => 'verified']);

            // pending'i temizle
            session()->remove('pending_register');
            $user = $this->users->find($id);

            session()->regenerate();
            session()->set([
                'user_id' => (int) $id,
                'user_email' => $dto->email,
                'user_name' => trim(($user['name'] ?? '') . ' ' . ($user['surname'] ?? '')),
                'role_id' => 0,
                'profile_completed' => false,
                'login' => true,
            ]);

            $editorService = new ArticleEditorService();
            $editorService->attachUserToAssignments((int) $id, (string) $dto->email);
            $hasAssignments = $editorService->userHasAssignments((int) $id, (string) $dto->email);
            session()->set('has_editor_assignments', $hasAssignments);

            return [
                'success' => true,
                'message' => 'Hesabınız doğrulandı ve oluşturuldu.',
                'data' => ['id' => $id, 'email' => $dto->email],
            ];
        } catch (DatabaseException $e) {
            return ['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()];
        }
    }

    private function sendVerificationMail(string $to, string $code): void
    {
        $mailer = new \Config\EmailService();
        $subject = 'E-posta Doğrulama Kodu';
        $message = $code; // İstersen burada HTML şablonunla zenginleştir
        $button = [];    // Şimdilik boş
        $mailer->mailGonder($to, $subject, $message, $button);
    }
}
