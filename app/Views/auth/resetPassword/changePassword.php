<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[370px] w-full">
        <form action="/auth/change-password" class="kt-card-content flex flex-col gap-5 p-10" id="change_password_form" method="post">
            <?= csrf_field() ?>
            
            <div class="text-center">
                <h3 class="text-lg font-medium text-mono">
                    Yeni Şifre
                </h3>
                <span class="text-sm text-secondary-foreground">
                    Yeni şifrenizi belirleyin
                </span>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="kt-alert kt-alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    Yeni Şifre
                </label>
                <div class="kt-input" data-kt-toggle-password="true">
                    <input name="password" placeholder="Yeni şifrenizi girin" type="password" />
                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    Şifre Tekrar
                </label>
                <div class="kt-input" data-kt-toggle-password="true">
                    <input name="password_repead" placeholder="Şifrenizi tekrar girin" type="password" />
                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
            </div>
            
            <input type="hidden" name="token" value="<?= esc($token ?? '') ?>" />
            
            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Şifreyi Değiştir
                <i class="ki-filled ki-check ms-2"></i>
            </button>
            
            <div class="text-center">
                <a href="/auth/login" class="text-sm text-primary hover:text-primary-dark">
                    Giriş sayfasına dön
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>