<?php // app/Views/app/modals/add-editor-modal.php ?>
<div
    class="kt-modal"
    data-kt-modal="true"
    id="addEditorModal"
    data-content-id="<?= isset($learningMaterialId) ? (int) $learningMaterialId : 0 ?>"
>
    <div class="kt-modal-content max-w-[600px] top-[15%]">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-user-plus text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-mono">Alan Editörü Ekle</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5">
            <div class="space-y-3 mb-4" id="add_editor_alerts" style="display: none;"></div>

            <form id="addEditorForm" class="space-y-4">
                <div class="text-center mb-4">
                    <p class="text-gray-600">
                        Alan editörü olarak atanacak kişinin e-posta adresini giriniz. Kullanıcı henüz kayıtlı değilse, kayıt olduğunda otomatik olarak erişim alacaktır.
                    </p>
                </div>

                <div class="kt-form-field">
                    <label class="kt-form-label mb-2" for="editor_email">
                        Alan Editörü E-postası <span class="text-danger">*</span>
                    </label>
                    <input
                        id="editor_email"
                        name="editor_email"
                        type="email"
                        class="kt-input"
                        placeholder="ornek@site.com"
                        required
                    >
                    <input
                        type="hidden"
                        name="learning_material_id"
                        value="<?= isset($learningMaterialId) ? (int) $learningMaterialId : 0 ?>"
                    >
                    <div class="text-sm italic font-bold mt-1" id="editor_email-error" style="display:none;color:#dc2626;"></div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">İptal</button>
            <button class="kt-btn kt-btn-primary" type="button" data-add-editor-submit>
                Editör Ekle
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        const modalElement = document.getElementById('addEditorModal');
        if (!modalElement) {
            console.warn('addEditorModal bulunamadı.');
            return;
        }

        const KT = window.KTModal;
        const modalInstance = typeof KT !== 'undefined'
            ? KT.getOrCreateInstance(modalElement)
            : null;

        const alertContainer = document.getElementById('add_editor_alerts');
        const submitButton = modalElement.querySelector('[data-add-editor-submit]');
        const formElement = document.getElementById('addEditorForm');
        const emailInput = document.getElementById('editor_email');
        const contentInput = formElement?.querySelector('input[name="learning_material_id"]');
        let lastContentId = parseInt(contentInput?.value ?? '0', 10) || 0;
        const endpointSubmit = window.addEditorUrl ?? '<?= base_url('api/materials/add-editor') ?>';

        const showAlert = (type, message, title = null) => {
            if (!alertContainer) {
                return;
            }

            const alertId = `editor_alert_${Date.now()}`;
            const titleText = title || (type === 'success' ? 'Başarılı' : type === 'warning' ? 'Uyarı' : 'Bilgi');

            alertContainer.innerHTML = `
                <div class="kt-alert kt-alert-light kt-alert-${type}" id="${alertId}">
                    <div class="kt-alert-icon">
                        <i class="ki-filled ki-information-5"></i>
                    </div>
                    <div class="kt-alert-title">${titleText}</div>
                    <div class="kt-alert-toolbar">
                        <div class="kt-alert-actions">
                            <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                                <i class="ki-filled ki-cross"></i>
                            </button>
                        </div>
                    </div>
                    <div class="kt-alert-text">${message}</div>
                </div>
            `;
            alertContainer.style.display = 'block';
        };

        const clearAlert = () => {
            if (!alertContainer) return;
            alertContainer.innerHTML = '';
            alertContainer.style.display = 'none';
        };

        const setLoading = (state) => {
            if (!submitButton) return;
            submitButton.disabled = state;
            submitButton.classList.toggle('pointer-events-none', state);
            submitButton.classList.toggle('opacity-70', state);
        };

        const showFieldError = (field, message) => {
            const errorDiv = document.getElementById(`${field}-error`);
            if (!errorDiv) return;
            errorDiv.textContent = message;
            errorDiv.style.display = message ? 'block' : 'none';
        };

        const clearFieldErrors = () => {
            showFieldError('editor_email', '');
        };

        const resolveContentId = (candidate) => {
            if (typeof candidate === 'number' && candidate > 0) {
                lastContentId = candidate;
                if (contentInput) {
                    contentInput.value = String(candidate);
                }
                return candidate;
            }

            const directInput = parseInt(contentInput?.value ?? '0', 10);
            if (directInput > 0) {
                lastContentId = directInput;
                return directInput;
            }

            const modalDataId = parseInt(modalElement?.dataset?.learningMaterialId ?? '0', 10);
            if (modalDataId > 0) {
                lastContentId = modalDataId;
                if (contentInput) {
                    contentInput.value = String(modalDataId);
                }
                return modalDataId;
            }

            const bodyDataId = parseInt(document.body.dataset.learningMaterialId ?? '0', 10);
            if (bodyDataId > 0) {
                lastContentId = bodyDataId;
                if (contentInput) {
                    contentInput.value = String(bodyDataId);
                }
                return bodyDataId;
            }

            return 0;
        };

        const openModal = (learningMaterialId = null) => {
            clearAlert();
            clearFieldErrors();

            if (modalInstance && typeof modalInstance.show === 'function') {
                modalInstance.show();
            } else {
                modalElement.style.display = 'flex';
                document.body.classList.add('kt-modal-open');
            }

            resolveContentId(typeof learningMaterialId === 'number' ? learningMaterialId : parseInt(learningMaterialId ?? '0', 10));

            if (emailInput) {
                emailInput.value = '';
                emailInput.focus();
            }
        };

        const submit = async () => {
            if (!formElement || !emailInput || !contentInput) {
                return;
            }

            clearFieldErrors();

            const editorEmail = emailInput.value.trim();
            if (!editorEmail) {
                showFieldError('editor_email', 'Lütfen bir e-posta adresi giriniz.');
                return;
            }
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(editorEmail)) {
                showFieldError('editor_email', 'Geçerli bir e-posta adresi giriniz.');
                return;
            }

            let learningMaterialId = parseInt(contentInput.value, 10) || 0;
            if (learningMaterialId <= 0) {
                learningMaterialId = resolveContentId(lastContentId);
            }
            if (learningMaterialId <= 0) {
                showFieldError('editor_email', 'Eğitim içeriği bilgisine ulaşılamadı.');
                return;
            }

            setLoading(true);

            try {
                const response = await fetch(endpointSubmit, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        learning_material_id: learningMaterialId,
                        editor_email: editorEmail
                    })
                });

                const payload = await response.json();
                if (!response.ok || !(payload?.success)) {
                    throw new Error(payload?.message || 'Alan editörü eklenemedi.');
                }

                const alreadyAssigned = Boolean(payload?.alreadyAssigned);
                const alertType = alreadyAssigned ? 'warning' : 'success';
                const alertTitle = alreadyAssigned ? 'Bilgi' : 'Başarılı';

                showAlert(alertType, payload?.message || 'Alan editörü kaydedildi.', alertTitle);

                if (!alreadyAssigned) {
                    formElement.reset();
                    setTimeout(() => {
                        if (modalInstance && typeof modalInstance.hide === 'function') {
                            modalInstance.hide();
                        } else {
                            modalElement.style.display = 'none';
                            document.body.classList.remove('kt-modal-open');
                        }
                        setTimeout(() => window.location.reload(), 150);
                    }, 800);
                } else {
                    setLoading(false);
                }
            } catch (error) {
                console.error('Alan editörü eklenirken hata:', error);
                showAlert('destructive', error.message || 'Alan editörü eklenirken bir hata oluştu.', 'Hata');
                setLoading(false);
            }
        };

        document.querySelectorAll('[data-kt-modal-toggle="#addEditorModal"]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const target = event.currentTarget;
                const candidate = target?.dataset?.learningMaterialId ?? null;
                openModal(candidate ? Number(candidate) : null);
            });
        });

        modalElement.addEventListener('click', (event) => {
            if (event.target === modalElement) {
                if (modalInstance && typeof modalInstance.hide === 'function') {
                    modalInstance.hide();
                } else {
                    modalElement.style.display = 'none';
                    document.body.classList.remove('kt-modal-open');
                }
            }
        });

        if (submitButton) {
            submitButton.addEventListener('click', submit);
        }

        if (emailInput) {
            emailInput.addEventListener('input', clearFieldErrors);
        }
    })();
</script>
