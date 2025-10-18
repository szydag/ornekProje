<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[370px] w-full">
        <form action="/auth/send-reset-email" class="kt-card-content flex flex-col gap-5 p-10" id="reset_password_enter_email_form" method="post">
            <?= csrf_field() ?>
            
            <div class="text-center">
                <h3 class="text-lg font-medium text-mono">
                    E-posta Adresiniz
                </h3>
                <span class="text-sm text-secondary-foreground">
                    Şifre sıfırlama bağlantısı için e-posta adresinizi girin
                </span>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="kt-alert kt-alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    E-posta
                </label>
                <input class="kt-input" name="email" placeholder="ornek@email.com" type="email" value="" />
            </div>
            
            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Devam Et
                <i class="ki-filled ki-black-right ms-2"></i>
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>