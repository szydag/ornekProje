<!-- Logout Confirmation Modal -->
<div class="kt-modal" data-kt-modal="true" id="logout_confirmation_modal">
    <!-- Modal content -->
    <div class="kt-modal-content top-[15%]" style="max-width: 400px; width: 90vw;">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title">
                <i class="ki-filled ki-exit-up text-danger me-2"></i>
                Çıkış Yap
            </h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="text-center">
                <h4 class="text-lg font-semibold text-foreground mb-2">Çıkış yapmak istediğinizden emin misiniz?</h4>
                <p class="text-sm text-secondary-foreground">
                    Hesabınızdan çıkış yaptıktan sonra tekrar giriş yapmanız gerekecektir.
                </p>
            </div>
        </div>
        <div class="kt-modal-footer">
            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-danger" onclick="confirmLogout()">
                <i class="ki-filled ki-exit-up text-sm me-1"></i>
                Çıkış Yap
            </button>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        // Modal'ı kapat
        const modal = document.getElementById('logout_confirmation_modal');
        if (modal) {
            if (typeof KTModal !== 'undefined' && KTModal.getInstance(modal)) {
                KTModal.getInstance(modal).hide();
            } else {
                modal.classList.remove('kt-modal-open');
                modal.style.display = 'none';
                document.body.classList.remove('kt-modal-open');
            }
        }

        // Loading göster
        showLogoutLoading();

        // Çıkış işlemini gerçekleştir
        setTimeout(() => {
            // Gerçek logout endpoint'ini çağır
            fetch('/app/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hideLogoutLoading();
                    if (data.success) {
                        // Başarılı çıkış - login sayfasına yönlendir
                        window.location.href = '<?= base_url('auth/login') ?>';
                    } else {
                        // Hata durumunda yine de login sayfasına yönlendir
                        window.location.href = '<?= base_url('auth/login') ?>';
                    }
                })
                .catch(error => {
                    hideLogoutLoading();
                    console.error('Logout error:', error);
                    // Hata durumunda yine de login sayfasına yönlendir
                    window.location.href = '<?= base_url('auth/login') ?>';
                });
        }, 500);
    }

    function showLogoutLoading() {
        // Loading overlay oluştur
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'logout-loading-overlay';
        loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999999;
    `;

        const loadingContent = document.createElement('div');
        loadingContent.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    `;

        loadingContent.innerHTML = `
        <div class="flex items-center justify-center size-12 mx-auto mb-4 bg-primary/10 rounded-full">
            <i class="ki-filled ki-loading text-primary text-xl animate-spin"></i>
        </div>
        <p class="text-sm text-foreground font-medium">Çıkış yapılıyor...</p>
    `;

        loadingOverlay.appendChild(loadingContent);
        document.body.appendChild(loadingOverlay);
    }

    function hideLogoutLoading() {
        const loadingOverlay = document.getElementById('logout-loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }
</script>
