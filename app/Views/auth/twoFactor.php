<?= $this->extend('auth/layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-center grow bg-center bg-no-repeat auth-bg-simple">
    <div class="kt-card max-w-[380px] w-full" id="two-factor-form">
        <form action="<?= base_url('user/auth/verify-two-factor') ?>" class="kt-card-content flex flex-col gap-5 p-10" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="email" value="<?= esc($email ?? '') ?>">

            <img alt="image" class="dark:hidden h-20 mb-2" src="/assets/media/illustrations/34.svg" />
            <img alt="image" class="light:hidden h-20 mb-2" src="/assets/media/illustrations/34-dark.svg" />

            <div class="text-center mb-2">
                <h3 class="text-lg font-medium text-mono mb-5">
                    E-postanızı Doğrulayın
                </h3>
                <div class="flex flex-col">
                    <span class="text-sm text-secondary-foreground mb-1.5">
                        Size gönderilen doğrulama kodunu girin
                    </span>
                    <a class="text-sm font-medium text-mono" href="#">
                        <?= esc($email ?? '***@email.com') ?>
                    </a>
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="kt-alert kt-alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-wrap justify-center gap-2.5" id="verification-code-container">
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_0" placeholder="" type="text" value="" data-index="0" />
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_1" placeholder="" type="text" value="" data-index="1" />
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_2" placeholder="" type="text" value="" data-index="2" />
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_3" placeholder="" type="text" value="" data-index="3" />
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_4" placeholder="" type="text" value="" data-index="4" />
                <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center" maxlength="1" name="code_5" placeholder="" type="text" value="" data-index="5" />
            </div>

            <div class="flex flex-col items-center justify-center mb-2 gap-2">
                <span class="text-2sm text-secondary-foreground">
                    Kod almadınız mı? <a href="#" class="text-primary hover:text-primary-dark cursor-pointer" id="resend-link" onclick="event.preventDefault(); resendCode();">
                        Tekrar Gönder
                    </a>
                </span>
                <span id="countdown-timer">180s</span>
            </div>

            <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Devam Et
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#verification-code-container input[data-index]');
        const container = document.getElementById('verification-code-container');

        // Input alanlarını sıralayalım
        const sortedInputs = Array.from(inputs).sort((a, b) => {
            return parseInt(a.dataset.index) - parseInt(b.dataset.index);
        });

        // Kopyala-yapıştır desteği
        container.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/\D/g, '').slice(0, 6); // Sadece rakamları al, max 6 karakter

            // Her bir rakamı ilgili input alanına yerleştir
            for (let i = 0; i < digits.length && i < sortedInputs.length; i++) {
                sortedInputs[i].value = digits[i];
            }

            // Son doldurulan input alanından sonraki boş alana focus et
            const nextEmptyIndex = digits.length;
            if (nextEmptyIndex < sortedInputs.length) {
                sortedInputs[nextEmptyIndex].focus();
            } else if (digits.length === 6) {
                // Tüm alanlar doluysa form submit edilebilir
                sortedInputs[sortedInputs.length - 1].blur();
            }
        });

        // Her input için event listener'lar ekle
        sortedInputs.forEach((input, index) => {
            // Input'a değer girildiğinde
            input.addEventListener('input', function(e) {
                const value = e.target.value;

                // Sadece rakam kabul et
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Eğer değer girildiyse bir sonraki input'a geç
                if (value && index < sortedInputs.length - 1) {
                    sortedInputs[index + 1].focus();
                } else if (value && index === sortedInputs.length - 1) {
                    // Son input doldurulduysa focus'u kaldır
                    e.target.blur();
                }
            });

            // Geri tuşu ile önceki input'a geç
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace') {
                    // Eğer input boşsa ve ilk input değilse öncekine geç
                    if (!e.target.value && index > 0) {
                        e.preventDefault();
                        sortedInputs[index - 1].focus();
                    }
                }

                // Ok tuşları ile navigasyon
                if (e.key === 'ArrowLeft' && index > 0) {
                    e.preventDefault();
                    sortedInputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < sortedInputs.length - 1) {
                    e.preventDefault();
                    sortedInputs[index + 1].focus();
                }
            });

            // Input'a tıklandığında mevcut değeri seç
            input.addEventListener('click', function() {
                this.select();
            });

            // Focus olduğunda değeri seç
            input.addEventListener('focus', function() {
                this.select();
            });
        });

        // İlk input'a otomatik focus
        sortedInputs[0].focus();

        // 3 dakikalık geri sayım (180 saniye)
        let countdownTime = 180;
        let countdownInterval;
        const countdownElement = document.getElementById('countdown-timer');
        const resendLink = document.getElementById('resend-link');

        function updateCountdown() {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;

            // Format: MM:SS veya sadece saniye
            if (countdownTime >= 60) {
                countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            } else {
                countdownElement.textContent = `${countdownTime}s`;
            }

            if (countdownTime <= 0) {
                // Geri sayım bitti, "Tekrar Gönder" linkini aktif et
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.opacity = '1';
                countdownElement.textContent = 'Tekrar gönderebilirsiniz';
                clearInterval(countdownInterval);
            }

            countdownTime--;
        }

        // İlk güncelleme
        updateCountdown();

        // Her saniye güncelle
        countdownInterval = setInterval(updateCountdown, 1000);
    });
</script>

<?= $this->endSection() ?>