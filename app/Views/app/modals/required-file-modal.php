<div class="kt-modal" data-kt-modal="true" id="required_file_modal">
    <div class="kt-modal-backdrop"></div>

    <div class="kt-modal-content max-w-[600px] top-[15%]">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title" id="required_file_title">Dosya Yükle</h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>

        <div class="kt-modal-body px-5 py-5"
            style="max-height: calc(80vh - 120px); overflow-y: auto; background: white;">
            <div class="space-y-3 mb-4" id="requiredFileAlertContainer" style="display: none;"></div>

            <div class="grid gap-5">
                <form id="requiredFileForm">
                    <div class="flex items-center gap-4 p-4 bg-accent/10 rounded-lg">
                        <div class="flex items-center justify-center size-12 rounded-full bg-primary/10">
                            <i class="ki-filled ki-information text-primary text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-mono mb-1" id="required_file_description">Dosya
                                açıklaması</h4>
                            <p class="text-xs text-secondary-foreground">Bu dosya zorunludur ve içerik gönderimi için
                                gereklidir.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1 mb-4">
                        <label class="kt-label text-sm font-medium text-foreground mb-1">
                            Dosya Seç <span class="text-danger">*</span>
                        </label>
                        <input type="file" id="required_file_input" name="required_file" class="kt-input"
                            accept=".pdf,.doc,.docx,.odt,.rtf,.tex,.latex,.txt,.jpg,.jpeg,.png,.pptx,.xml,.xlsx,.xls"
                            required />
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground mb-1">Dosya Açıklaması</label>
                        <textarea id="required_file_desc_input" name="file_description" class="kt-textarea" rows="3"
                            placeholder="Bu dosya hakkında açıklama yazabilirsiniz (isteğe bağlı)"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="kt-modal-footer">
            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="true">İptal</button>
            <button type="button" class="kt-btn kt-btn-primary" onclick="handleRequiredFileUpload()">
                <i class="ki-filled ki-file-up text-sm"></i>
                Dosyayı Yükle
            </button>


        </div>
    </div>
</div>

<script>
    function showRequiredFileAlert(type, message, title = null) {
        const container = document.getElementById('requiredFileAlertContainer');
        if (!container) return;

        const alertId = `alert_${Date.now()}`;
        const alertTitle = title || getDefaultTitle(type);
        const html = `
        <div class="kt-alert kt-alert-light kt-alert-${type}" id="${alertId}">
            <div class="kt-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-info" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="kt-alert-title">${alertTitle}</div>
            <div class="kt-alert-toolbar">
                <div class="kt-alert-actions">
                    <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-x" aria-hidden="true">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="kt-alert-text text-sm mt-2">${message}</div>
        </div>
    `;

        container.insertAdjacentHTML('beforeend', html);
        container.style.display = 'block';

        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.remove();
                if (!container.children.length) container.style.display = 'none';
            }
        }, 5000);
    }

    function getDefaultTitle(type) {
        const map = {
            success: 'Başarılı!',
            info: 'Bilgi',
            primary: 'Bilgi',
            warning: 'Uyarı',
            destructive: 'Hata'
        };
        return map[type] ?? 'Bilgi';
    }

    function clearRequiredFileAlerts() {
        const container = document.getElementById('requiredFileAlertContainer');
        if (!container) return;
        container.innerHTML = '';
        container.style.display = 'none';
    }

    function showPageAlert(type, message, title = null) {
        let container = document.getElementById('pageAlertContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'pageAlertContainer';
            container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            width: 100%;
        `;
            document.body.appendChild(container);
        }

        const alertId = `pageAlert_${Date.now()}`;
        const alertTitle = title || getDefaultTitle(type);
        const html = `
        <div class="kt-alert kt-alert-light kt-alert-${type} mb-3" id="${alertId}"
             style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <div class="kt-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-info" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="kt-alert-title">${alertTitle}</div>
            <div class="kt-alert-toolbar">
                <div class="kt-alert-actions">
                    <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-x" aria-hidden="true">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="kt-alert-text text-sm mt-2">${message}</div>
        </div>
    `;

        container.insertAdjacentHTML('beforeend', html);

        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                    if (!container.children.length) container.remove();
                }, 300);
            }
        }, 4000);
    }

    function closeRequiredFileModal() {
        const modal = document.getElementById('required_file_modal');
        if (!modal) return;

        modal.style.display = 'none';
        modal.classList.remove('kt-modal-open');
        document.body.classList.remove('kt-modal-open');
        document.body.style.filter = '';
        document.body.style.backdropFilter = '';
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        document.querySelectorAll('.kt-modal-backdrop, [data-kt-modal-backdrop]').forEach((el) => el.remove());

        const form = document.getElementById('requiredFileForm');
        if (form) form.reset();
        clearRequiredFileAlerts();
    }

    async function uploadRequiredFileFallback() {
        const form = document.getElementById('requiredFileForm');
        if (!form) return;

        clearRequiredFileAlerts();

        const fileInput = document.getElementById('required_file_input');
        if (!fileInput?.files?.length) {
            showRequiredFileAlert('warning', 'Lütfen bir dosya seçin.');
            return;
        }

        const formData = new FormData();
        formData.append('files[]', fileInput.files[0]);

        let response;
        let payload;

        try {
            response = await fetch('/apps/add-material/step-3/upload', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            payload = await response.json();

            if (!response.ok || payload.status !== 'success') {
                throw new Error(payload.error ?? 'Dosya yüklenemedi.');
            }
        } catch (error) {
            showRequiredFileAlert('destructive', error.message ?? 'Dosya yüklenirken hata oluştu.');
            return;
        }

        const file = payload?.data?.files?.[0];
        if (!file) {
            showRequiredFileAlert('destructive', 'Sunucudan dosya bilgisi alınamadı.');
            return;
        }

        const modal = document.getElementById('required_file_modal');
        const descriptionInput = document.getElementById('required_file_desc_input');
        const notes = descriptionInput?.value?.trim() || null;
        const requiredRole = modal?.dataset?.requiredRole ?? 'full_text';
        const requiredIsPrimary = modal?.dataset?.requiredIsPrimary === 'true';

        document.dispatchEvent(new CustomEvent('step3:file-uploaded', {
            detail: {
                context: 'required',
                file: {
                    ...file,
                    role: requiredRole,
                    is_primary: requiredIsPrimary,
                    language: null,
                    notes,
                },
            },
        }));

        closeRequiredFileModal();
        showPageAlert('success', `${file.name} başarıyla yüklendi!`, 'İşlem Başarılı');
    }

    function handleRequiredFileUpload() {
        if (typeof window.uploadRequiredFileHandler === 'function') {
            window.uploadRequiredFileHandler();
            return;
        }

        uploadRequiredFileFallback();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('required_file_modal');
        if (modal) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        if (modal.style.display === 'flex' || modal.classList.contains('kt-modal-open')) {
                            clearRequiredFileAlerts();
                        }
                    }
                });
            });

            observer.observe(modal, { attributes: true, attributeFilter: ['style', 'class'] });
        }

        document.addEventListener('click', (event) => {
            if (event.target === document.getElementById('required_file_modal')) {
                closeRequiredFileModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const modal = document.getElementById('required_file_modal');
                if (modal && modal.classList.contains('kt-modal-open')) {
                    closeRequiredFileModal();
                }
            }
        });
    });
</script>
