<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[440px] w-full">
        <div class="kt-card-content p-10">
            <div class="flex justify-center py-10">
                <img alt="image" class="dark:hidden max-h-[130px]" src="/assets/media/illustrations/30.svg"/>
                <img alt="image" class="light:hidden max-h-[130px]" src="/assets/media/illustrations/30-dark.svg"/>
            </div>
            
            <h3 class="text-lg font-medium text-mono text-center mb-3">
                E-postanızı Kontrol Edin
            </h3>
            
            <div class="text-sm text-center text-secondary-foreground mb-7.5">
                Şifrenizi sıfırlamak için lütfen 
                <a class="text-sm text-foreground font-medium hover:text-primary" href="#">
                    <?= esc($email ?? 'e-posta adresinize') ?>
                </a>
                <br/>
                gönderilen bağlantıya tıklayın. Teşekkürler
            </div>
            
            <div class="flex justify-center mb-5">
                <a class="kt-btn kt-btn-primary flex justify-center" href="/auth/change-password">
                    Şimdilik Atla
                </a>
            </div>
            
            <div class="flex items-center justify-center gap-1">
                <span class="text-xs text-secondary-foreground">
                    E-posta almadınız mı?
                </span>
                <a class="text-xs font-medium link" href="/auth/forgot-password">
                    Tekrar Gönder
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>