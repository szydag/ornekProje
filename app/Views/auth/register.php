<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('style') ?>
<style>
    /* KVKK ve Açık Rıza modalları için responsive genişlik */
    @media (max-width: 768px) {
        #kvkk_modal .kt-modal-content,
        #acik_riza_modal .kt-modal-content {
            width: 90vw !important;
            min-width: 320px !important;
            max-width: none !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[440px] w-full">
        <form action="<?= base_url('user/auth/register') ?>" class="kt-card-content flex flex-col gap-5 p-10" id="sign_up_form" method="post">
            <?= csrf_field() ?>

            <div class="text-center mb-2.5">
                <!-- EduContent Logo -->
                <div class="flex justify-center mb-6">
                    <img src="<?= base_url('assets/media/app/educontent-emblem.svg') ?>"
                        alt="EduContent"
                        class="h-16 w-auto">
                </div>

                <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                    Kayıt Ol
                </h3>
                <div class="flex items-center justify-center">
                    <span class="text-sm text-secondary-foreground me-1.5">
                        Zaten hesabınız var mı?
                    </span>
                    <a class="text-sm link underline" href="/auth/login">
                        Giriş Yap
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
                <span class="text-xs text-secondary-foreground uppercase">veya</span>
                <span class="border-t border-border w-full"></span>
            </div>

             -->

            <!-- İsim-Soyisim en başta yan yana -->
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label text-mono">
                        Adınız*
                    </label>
                    <input class="kt-input" name="first_name" placeholder="Adınızı girin" type="text" value="<?= old('first_name') ?>" id="first_name-input" />
                    <div class="text-red-500 text-sm italic mt-1" id="first_name-error" style="display: none;"></div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="kt-form-label text-mono">
                        Soyadınız*
                    </label>
                    <input class="kt-input" name="last_name" placeholder="Soyadınızı girin" type="text" value="<?= old('last_name') ?>" id="last_name-input" />
                    <div class="text-red-500 text-sm italic mt-1" id="last_name-error" style="display: none;"></div>
                </div>
            </div>

            <!-- E-posta -->
            <div class="flex flex-col gap-1">
                <label class="kt-form-label text-mono">
                    E-Posta*
                </label>
                <input class="kt-input" name="email" placeholder="ornek@email.com" type="email" value="<?= old('email') ?>" id="email-input" />
                <div class="text-red-500 text-sm italic mt-1" id="email-error" style="display: none;"></div>
            </div>

            <!-- Şifreler alt alta -->
            <div class="flex flex-col gap-1">
                <label class="kt-form-label text-mono">
                    Şifre*
                </label>
                <div class="kt-input" data-kt-toggle-password="true" id="password-container">
                    <input name="password" placeholder="Şifrenizi girin" type="password" id="password-input" />
                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
                <div class="text-red-500 text-sm italic mt-1" id="password-error" style="display: none;"></div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="kt-form-label text-mono">
                    Şifre Tekrar*
                </label>
                <div class="kt-input" data-kt-toggle-password="true" id="password_repeat-container">
                    <input name="password_repeat" placeholder="Şifrenizi tekrar girin" type="password" id="password_repeat-input" />
                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
                <div class="text-red-500 text-sm italic mt-1" id="password_repeat-error" style="display: none;"></div>
            </div>

            <div class="flex flex-col gap-3">
                <div>
                    <label class="kt-checkbox-group">
                        <input class="kt-checkbox kt-checkbox-sm" name="kvkk_consent" type="checkbox" value="1" id="kvkk_consent-input" />
                        <span class="kt-checkbox-label">
                            <a class="text-sm link underline font-medium text-blue-600 hover:text-blue-700" href="#" data-kt-modal-toggle="#kvkk_modal">KVKK Aydınlatma Metni</a>'ni okudum onaylıyorum
                        </span>
                    </label>
                    <div class="text-red-500 text-sm italic mt-1" id="kvkk_consent-error" style="display: none;"></div>
                </div>

                <div>
                    <label class="kt-checkbox-group">
                        <input class="kt-checkbox kt-checkbox-sm" name="kvkk_explicit_consent" type="checkbox" value="1" id="kvkk_explicit_consent-input" />
                        <span class="kt-checkbox-label">
                            <a class="text-sm link underline font-medium text-primary hover:text-primary/80" href="#" data-kt-modal-toggle="#acik_riza_modal">Açık Rıza Metni</a>'ni okudum onaylıyorum
                        </span>
                    </label>
                    <div class="text-red-500 text-sm italic mt-1" id="kvkk_explicit_consent-error" style="display: none;"></div>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="kt-form-label text-mono">
                    Ben robot değilim
                </label>
                <!-- Buraya reCAPTCHA lazım bunu bana sen vereceksin -->
                <div class="text-sm text-muted-foreground p-3 border border-border rounded">
                    reCAPTCHA buraya gelecek
                </div>
            </div>

            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Kayıt Ol
            </button>
        </form>
    </div>
</div>

<!-- KVKK Modal -->
<div class="kt-modal" data-kt-modal="true" id="kvkk_modal">
    <div class="kt-modal-content mx-auto" style="margin-top: 10vh; width: 70vw; max-width: 1000px; min-width: 600px;">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title">
                KVKK Aydınlatma Metni
            </h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-black-left"></i>
            </button>
        </div>
        <div class="kt-modal-body px-5 py-5">
            <div class="overflow-y-auto max-h-[400px] text-sm leading-relaxed">
                <?php
                $kvkkFile = APPPATH . '../kvkk.txt';
                if (file_exists($kvkkFile)) {
                    $kvkkContent = file_get_contents($kvkkFile);
                    echo nl2br(htmlspecialchars($kvkkContent));
                } else {
                    echo 'KVKK metni bulunamadı.';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Açık Rıza Modal -->
<div class="kt-modal" data-kt-modal="true" id="acik_riza_modal">
    <div class="kt-modal-content mx-auto" style="margin-top: 10vh; width: 70vw; max-width: 1000px; min-width: 600px;">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title">
                Açık Rıza Metni
            </h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-black-left"></i>
            </button>
        </div>
        <div class="kt-modal-body px-5 py-5">
            <div class="overflow-y-auto max-h-[400px] text-sm leading-relaxed">
                <?php
                $acikRizaFile = APPPATH . '../acik-riza-metni.txt';
                if (file_exists($acikRizaFile)) {
                    $acikRizaContent = file_get_contents($acikRizaFile);
                    echo nl2br(htmlspecialchars($acikRizaContent));
                } else {
                    echo 'Açık Rıza metni bulunamadı.';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('sign_up_form');
    const firstNameInput = document.getElementById('first_name-input');
    const lastNameInput = document.getElementById('last_name-input');
    const emailInput = document.getElementById('email-input');
    const passwordInput = document.getElementById('password-input');
    const passwordRepeatInput = document.getElementById('password_repeat-input');
    const kvkkConsentInput = document.getElementById('kvkk_consent-input');
    const kvkkExplicitConsentInput = document.getElementById('kvkk_explicit_consent-input');

    // Real-time validation için event listener'lar ekle
    if (firstNameInput) {
        firstNameInput.addEventListener('input', function() {
            clearFieldError('first_name');
        });
    }

    if (lastNameInput) {
        lastNameInput.addEventListener('input', function() {
            clearFieldError('last_name');
        });
    }

    if (emailInput) {
        emailInput.addEventListener('input', function() {
            clearFieldError('email');
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            clearFieldError('password');
            if (passwordRepeatInput && passwordRepeatInput.value) {
                clearFieldError('password_repeat');
            }
        });
    }

    if (passwordRepeatInput) {
        passwordRepeatInput.addEventListener('input', function() {
            clearFieldError('password_repeat');
        });
    }

    if (kvkkConsentInput) {
        kvkkConsentInput.addEventListener('change', function() {
            clearFieldError('kvkk_consent');
        });
    }

    if (kvkkExplicitConsentInput) {
        kvkkExplicitConsentInput.addEventListener('change', function() {
            clearFieldError('kvkk_explicit_consent');
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {

            clearAllErrors();

            const firstName = this.querySelector('input[name="first_name"]').value.trim();
            const lastName = this.querySelector('input[name="last_name"]').value.trim();
            const email = this.querySelector('input[name="email"]').value.trim();
            const password = this.querySelector('input[name="password"]').value;
            const passwordRepeat = this.querySelector('input[name="password_repeat"]').value;
            const kvkkConsent = this.querySelector('input[name="kvkk_consent"]').checked;
            const kvkkExplicitConsent = this.querySelector('input[name="kvkk_explicit_consent"]').checked;

            let hasErrors = false;

            if (!firstName) {
                showFieldError('first_name', 'Adınız zorunludur.');
                hasErrors = true;
            } else if (firstName.length < 2) {
                showFieldError('first_name', 'Adınız en az 2 karakter olmalıdır.');
                hasErrors = true;
            }

            if (!lastName) {
                showFieldError('last_name', 'Soyadınız zorunludur.');
                hasErrors = true;
            } else if (lastName.length < 2) {
                showFieldError('last_name', 'Soyadınız en az 2 karakter olmalıdır.');
                hasErrors = true;
            }

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

            if (!passwordRepeat) {
                showFieldError('password_repeat', 'Şifre tekrar alanı zorunludur.');
                hasErrors = true;
            } else if (password !== passwordRepeat) {
                showFieldError('password_repeat', 'Şifreler eşleşmiyor.');
                hasErrors = true;
            }

            if (!kvkkConsent) {
                showFieldError('kvkk_consent', 'KVKK aydınlatma metnini onaylamalısınız.');
                hasErrors = true;
            }

            if (!kvkkExplicitConsent) {
                showFieldError('kvkk_explicit_consent', 'Açık rıza metnini onaylamalısınız.');
                hasErrors = true;
            }

            if (hasErrors) {
                showGeneralError('Lütfen formu kontrol ederek gerekli alanları doldurunuz.');
                e.preventDefault(); // Sadece hata varsa form gönderimini engelle
                return;
            }
        });
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function clearAllErrors() {
    clearFieldError('first_name');
    clearFieldError('last_name');
    clearFieldError('email');
    clearFieldError('password');
    clearFieldError('password_repeat');
    clearFieldError('kvkk_consent');
    clearFieldError('kvkk_explicit_consent');

    const existingError = document.querySelector('.kt-alert-danger');
    if (existingError) {
        existingError.remove();
    }

    const existingSuccess = document.querySelector('.kt-alert-success');
    if (existingSuccess) {
        existingSuccess.remove();
    }
}

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

function clearFieldError(fieldName) {
    const errorElement = document.getElementById(fieldName + '-error');
    if (errorElement) {
        errorElement.style.display = 'none';
        errorElement.textContent = '';
    }
}

function showGeneralError(message) {
    const existingError = document.querySelector('.kt-alert-danger');
    if (existingError) {
        existingError.remove();
    }
    const existingSuccess = document.querySelector('.kt-alert-success');
    if (existingSuccess) {
        existingSuccess.remove();
    }

    const errorDiv = document.createElement('div');
    errorDiv.className = 'kt-alert kt-alert-danger';
    errorDiv.innerHTML = message;

    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.parentNode.insertBefore(errorDiv, submitButton);
}

function showGeneralSuccess(message) {
    const existingError = document.querySelector('.kt-alert-danger');
    if (existingError) {
        existingError.remove();
    }
    const existingSuccess = document.querySelector('.kt-alert-success');
    if (existingSuccess) {
        existingSuccess.remove();
    }

    const successDiv = document.createElement('div');
    successDiv.className = 'kt-alert kt-alert-success';
    successDiv.innerHTML = message;

    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.parentNode.insertBefore(successDiv, submitButton);
}
</script>

<?= $this->endSection() ?>