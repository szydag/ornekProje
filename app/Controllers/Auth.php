<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }

    public function register(): string
    {
        return view('auth/register');
    }

    // Login işlemi
    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'E-posta ve şifre gereklidir.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Geçerli bir e-posta adresi girin.');
        }

        $loginService = new \App\Services\Users\LoginService();
        $dto = \App\DTOs\Users\LoginDTO::fromArray(['email' => $email, 'password' => $password]);
        $result = $loginService->login($dto);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $result['message'] ?? 'Giriş başarısız.');
        }

        // Session ayarları LoginService'de yapılıyor
        // Başarılı login sonrası home sayfasına yönlendir
        $redirectTo = session('intended_url') ?? '/app/home';
        session()->remove('intended_url');

        return redirect()->to($redirectTo)->with('success', 'Giriş başarılı! Hoş geldiniz.');
    }

    // Register işlemi
    public function processRegister()
    {
        $registerService = new \App\Services\Users\RegisterService();
        $data = $this->request->getPost();
        $dto = \App\DTOs\Users\RegisterDTO::fromArray($data);
        
        $result = $registerService->createUserDirectly($dto);

        if (!$result['success']) {
            // Validation hatalarını detaylı göster
            $errorMessage = $result['message'] ?? 'Kayıt başarısız.';
            
            // Eğer validation hataları varsa, bunları da ekle
            if (!empty($result['errors'])) {
                $errorDetails = [];
                foreach ($result['errors'] as $field => $error) {
                    $errorDetails[] = is_array($error) ? implode(', ', $error) : $error;
                }
                if (!empty($errorDetails)) {
                    $errorMessage .= ' ' . implode(' ', $errorDetails);
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage)
                ->with('errors', $result['errors'] ?? []);
        }

        // Session ayarları RegisterService'de yapılıyor
        return redirect()->to('/')
            ->with('success', 'Kayıt başarılı! Hoş geldiniz.');
    }

    // Şifre sıfırlama - email giriş sayfası
    public function forgotPassword(): string
    {
        return view('auth/resetPassword/enterEmail');
    }

    // Şifre sıfırlama emaili gönder
    public function sendResetEmail()
    {
        $email = $this->request->getPost('email');
        
        // Email validation - sadece format kontrolü (boş geçilebilir)
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Geçerli bir e-posta adresi girin.');
        }

        // TODO: Burada veritabanında email kontrolü yapılacak
        // TODO: Reset token oluşturulup email gönderilecek
        
        // Test için checkEmail sayfasına yönlendir
        return redirect()->to('/auth/resetPassword/checkEmail');
    }

    // Şifre değiştirme sayfası
    public function changePassword()
    {
        $token = $this->request->getGet('token');
        
        // Test için token kontrolü yapma, sayfa gösterilsin
        return view('auth/resetPassword/changePassword', ['token' => $token ?? 'test-token']);
    }

    // Şifre değiştirme işlemi
    public function processChangePassword()
    {
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');
        $token = $this->request->getPost('token');

        // Validations - boş kontrolü yapma, sadece eşleşme ve uzunluk
        if ($password && $passwordConfirm && $password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'Şifreler eşleşmiyor.');
        }

        if ($password && strlen($password) < 6) {
            return redirect()->back()->with('error', 'Şifre en az 6 karakter olmalıdır.');
        }

        // TODO: Burada token kontrolü ve şifre güncelleme işlemi yapılacak
        
        return redirect()->to('/auth/login');
    }

    // Email doğrulama sayfası
    public function verifyEmail(): string
    {
        return view('auth/verifyEmail');
    }

    // Email doğrulama tekrar gönderme
    public function resendVerification()
    {
        $email = $this->request->getPost('email') ?? session('user_email');
        
        if (!$email) {
            return redirect()->back()->with('error', 'E-posta adresi bulunamadı.');
        }

        // TODO: Burada email doğrulama maili tekrar gönderilecek
        
        return redirect()->back();
    }

    // CheckEmail sayfası
    public function checkEmail(): string
    {
        return view('auth/resetPassword/checkEmail');
    }

    // 2FA doğrulama sayfası
    public function twoFactor(): string
    {
        return view('auth/twoFactor');
    }

    // 2FA kod doğrulama işlemi
    public function verifyTwoFactor()
    {
        $code0 = $this->request->getPost('code_0');
        $code1 = $this->request->getPost('code_1');
        $code2 = $this->request->getPost('code_2');
        $code3 = $this->request->getPost('code_3');
        $code4 = $this->request->getPost('code_4');
        $code5 = $this->request->getPost('code_5');

        $fullCode = $code0 . $code1 . $code2 . $code3 . $code4 . $code5;

        // Kod uzunluk kontrolü (boş geçilebilir)
        if ($fullCode && strlen($fullCode) !== 6) {
            return redirect()->back()->with('error', 'Lütfen 6 haneli kodu tam olarak girin.');
        }

        // TODO: Burada 2FA kod doğrulaması yapılacak
        
        // Test için app/home sayfasına yönlendir
        return redirect()->to('/app/home');
    }
}
