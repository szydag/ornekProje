<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[370px] w-full">
        <form action="/auth/login" class="kt-card-content flex flex-col gap-5 p-10" id="sign_in_form" method="post"
            novalidate>
            <?= csrf_field() ?>

            <div class="text-center mb-2.5">
                <!-- EduContent Logo -->
                <div class="flex justify-center mb-6">
                    <img src="<?= base_url('assets/media/app/educontent-emblem.svg') ?>" alt="EduContent"
                        class="h-16 w-auto">
                </div>

                <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                    Giriş Yap
                </h3>
                <div class="flex items-center justify-center font-medium">
                    <span class="text-sm text-secondary-foreground me-1.5">
                        Hesabınız yok mu?
                    </span>
                    <a class="text-sm link underline" href="/auth/register">
                        Kayıt Ol
                    </a>
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="kt-alert kt-alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!--
            <div class="grid grid-cols-2 gap-2.5">
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0" src="/assets/media/brand-logos/google.svg" />
                    Google ile
                </a>
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0 dark:hidden" src="/assets/media/brand-logos/apple-black.svg" />
                    <img alt="" class="size-3.5 shrink-0 light:hidden" src="/assets/media/brand-logos/apple-white.svg" />
                    Apple ile
                </a>
            </div>

            <div class="flex items-center gap-2">
                <span class="border-t border-border w-full"></span>
                <span class="text-xs text-muted-foreground font-medium uppercase">Veya</span>
                <span class="border-t border-border w-full"></span>
            </div>
            -->

            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    E-posta
                </label>
                <input class="kt-input" name="email" placeholder="ornek@email.com" type="email"
                    value="<?= old('email') ?>" id="email-input" />
                <div class="text-red-500 text-sm italic mt-1" id="email-error"
                    style="display: none; color: #ef4444; font-style: italic; font-size: 0.875rem; margin-top: 0.25rem;">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Şifre
                    </label>
                    <a class="text-sm kt-link shrink-0" href="/auth/forgot-password">
                        Şifremi Unuttum?
                    </a>
                </div>
                <div class="kt-input" data-kt-toggle-password="true" id="password-container">
                    <input name="password" placeholder="Şifrenizi girin" type="password" id="password-input" />
                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                        data-kt-toggle-password-trigger="true" type="button">
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
                <div class="text-red-500 text-sm italic mt-1" id="password-error"
                    style="display: none; color: #ef4444; font-style: italic; font-size: 0.875rem; margin-top: 0.25rem;">
                </div>
            </div>

            <label class="kt-label">
                <input class="kt-checkbox kt-checkbox-sm" name="remember" type="checkbox" value="1" />
                <span class="kt-checkbox-label">
                    Beni hatırla
                </span>
            </label>

            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Giriş Yap
            </button>
        </form>
    </div>
</div>
<?= $this->section('scripts') ?>
<script>
    // Sayfa yüklendiğinde çalışacak
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('sign_in_form');
        const emailInput = document.getElementById('email-input');
        const passwordInput = document.getElementById('password-input');

        // Real-time validation için event listener'lar ekle
        if (emailInput) {
            emailInput.addEventListener('input', function () {
                clearFieldError('email');
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                clearFieldError('password');
            });
        }

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Mevcut hata mesajlarını kaldır
                clearAllErrors();

                // Form verilerini al
                const email = this.querySelector('input[name="email"]').value.trim();
                const password = this.querySelector('input[name="password"]').value;
                const remember = this.querySelector('input[name="remember"]').checked;

                // Client-side validasyon
                let hasErrors = false;

                if (!email) {
                    showFieldError('email', 'E-posta alanı zorunludur.');
                    hasErrors = true;
                } else if (!isValidEmail(email)) {
                    showFieldError('email', 'Geçerli bir e-posta adresi giriniz.');
                    hasErrors = true;
                }

                if (!password) {
                    showFieldError('password', 'Şifre alanı zorunludur.');
                    hasErrors = true;
                } else if (password.length < 6) {
                    showFieldError('password', 'Şifre en az 6 karakter olmalıdır.');
                    hasErrors = true;
                }

                // Validasyon hataları varsa istek gönderme
                if (hasErrors) {
                    return;
                }

                // JSON data hazırla
                const jsonData = {
                    email: email,
                    password: password,
                    remember: remember
                };
                // AJAX isteği gönder
                fetch('/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(jsonData)
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            // Backend'den gelen hata mesajını almaya çalış
                            return response.text().then(text => {
                                try {
                                    const errorData = JSON.parse(text);
                                    throw new Error(JSON.stringify(errorData));
                                } catch (e) {
                                    throw new Error(text || 'HTTP ' + response.status);
                                }
                            });
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            const target = data.redirect_to ?? '/';
                            window.location.href = target;
                        } else {
                            // Hata mesajını ekranda göster
                            showGeneralError(data.message || 'Giriş başarısız. Lütfen bilgilerinizi kontrol edin.');
                        }
                    })
                    .catch(error => {
                        console.error('Hata:', error);

                        // error.message'ı parse et
                        if (error.message) {
                            try {
                                // JSON string olarak geliyorsa parse et
                                const errorData = JSON.parse(error.message);

                                // Eğer errors objesi varsa (field-specific hatalar)
                                if (errorData.errors) {
                                    Object.keys(errorData.errors).forEach(field => {
                                        showFieldError(field, errorData.errors[field]);
                                    });
                                } else {
                                    // Genel hata mesajı
                                    showGeneralError(errorData.message || 'Bir hata oluştu. Lütfen tekrar deneyin.');
                                }
                            } catch (e) {
                                // JSON değilse, direkt mesajı kullan
                                showGeneralError(error.message);
                            }
                        } else {
                            showGeneralError('Bir hata oluştu. Lütfen tekrar deneyin.');
                        }
                    });
            });
        } else {
            console.error('Form bulunamadı!');
        }
    });

    // Email validasyon fonksiyonu
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Tüm hata mesajlarını temizle
    function clearAllErrors() {
        // Field-specific hataları temizle
        clearFieldError('email');
        clearFieldError('password');

        // Genel hata mesajını temizle
        const existingError = document.querySelector('.kt-alert-danger');
        if (existingError) {
            existingError.remove();
        }
    }

    // Belirli bir field için hata mesajı göster
    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.color = '#ef4444';
            errorElement.style.fontStyle = 'italic';
            errorElement.style.fontSize = '0.875rem';
            errorElement.style.marginTop = '0.25rem';
        }
    }

    // Belirli bir field'ın hata mesajını temizle
    function clearFieldError(fieldName) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
    }

    // Input'a error state ekle (kırmızı border)
    function addErrorState(fieldName) {
        if (fieldName === 'email') {
            const input = document.getElementById('email-input');
            if (input) {
                input.classList.add('border-red-500', 'focus:border-red-500');
                input.classList.remove('border-gray-300', 'focus:border-blue-500');
            }
        } else if (fieldName === 'password') {
            const container = document.getElementById('password-container');
            if (container) {
                container.classList.add('border-red-500', 'focus-within:border-red-500');
                container.classList.remove('border-gray-300', 'focus-within:border-blue-500');
            }
        }
    }

    // Input'tan error state'i kaldır
    function removeErrorState(fieldName) {
        if (fieldName === 'email') {
            const input = document.getElementById('email-input');
            if (input) {
                input.classList.remove('border-red-500', 'focus:border-red-500');
                input.classList.add('border-gray-300', 'focus:border-blue-500');
            }
        } else if (fieldName === 'password') {
            const container = document.getElementById('password-container');
            if (container) {
                container.classList.remove('border-red-500', 'focus-within:border-red-500');
                container.classList.add('border-gray-300', 'focus-within:border-blue-500');
            }
        }
    }

    // Email field'ını validate et
    function validateEmailField() {
        const email = document.getElementById('email-input').value.trim();
        if (!email) {
            showFieldError('email', 'E-posta alanı zorunludur.');
        } else if (!isValidEmail(email)) {
            showFieldError('email', 'Geçerli bir e-posta adresi giriniz.');
        }
    }

    // Password field'ını validate et
    function validatePasswordField() {
        const password = document.getElementById('password-input').value;
        if (!password) {
            showFieldError('password', 'Şifre alanı zorunludur.');
        } else if (password.length < 6) {
            showFieldError('password', 'Şifre en az 6 karakter olmalıdır.');
        }
    }

    // Genel hata mesajı göster (eski showError fonksiyonu)
    function showGeneralError(message) {
        // Mevcut genel hata mesajını kaldır
        const existingError = document.querySelector('.kt-alert-danger');
        if (existingError) {
            existingError.remove();
        }

        // Yeni hata mesajını oluştur
        const errorDiv = document.createElement('div');
        errorDiv.className = 'kt-alert kt-alert-danger';
        errorDiv.innerHTML = message;

        // Giriş Yap butonunun üstüne hata mesajını ekle
        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.parentNode.insertBefore(errorDiv, submitButton);
    }
</script>
<?= $this->endSection('scripts') ?>
<?= $this->endSection() ?>