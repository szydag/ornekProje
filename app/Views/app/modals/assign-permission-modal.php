<?php // app/Views/app/modals/assign-permission-modal.php ?>
<div class="kt-modal" data-kt-modal="true" id="assignPermissionModal">
    <div class="kt-modal-content max-w-[800px] top-[15%]">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-setting-2 text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-mono">Yetki Ata</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5">
            <div class="space-y-3 mb-4" id="alertContainer" style="display: none;"></div>

            <form id="assignPermissionForm" class="space-y-4">
                <div class="flex flex-col gap-2">
                    <div class="flex items-baseline gap-2.5">
                        <label class="kt-form-label max-w-56">Kullanıcı Seç <span class="text-danger">*</span></label>
                        <select id="assign_user_id" name="user_id" class="kt-select" data-kt-select="true"
                            data-kt-select-enable-search="true" data-kt-select-search-placeholder="Kullanıcı ara..."
                            data-kt-select-placeholder="Kullanıcı seçin..."
                            data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}'>
                            <option value="">Kullanıcı seçin</option>
                            <?php foreach ($users ?? [] as $user): ?>
                                <?php
                                $userId = (int) ($user['id'] ?? 0);
                                $fullNameRaw = trim(($user['name'] ?? '') . ' ' . ($user['surname'] ?? ''));
                                $fullName = $fullNameRaw !== '' ? $fullNameRaw : 'İsimsiz Kullanıcı';
                                $emailAddress = $user['mail'] ?? '';
                                $label = $emailAddress ? $fullName . ' (' . $emailAddress . ')' : $fullName;
                                ?>
                                <option value="<?= $userId ?>"><?= esc($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="text-sm italic font-bold mt-1" id="user_id-error" style="display: none; color: #dc2626;"></div>
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex items-baseline gap-2.5">
                        <label class="kt-form-label max-w-56">Yetki Seç <span class="text-danger">*</span></label>
                        <select name="role_id" class="kt-select" data-kt-select="true"
                            data-kt-select-placeholder="Yetki seçin..." data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                            <option value="">Yetki seçin</option>
                            <?php foreach ($roles ?? [] as $role): ?>
                                <?php
                                $roleId = (int) ($role['id'] ?? 0);
                                $roleName = $role['role_name'] ?? '';
                                if ($roleId <= 0 || $roleName === '') {
                                    continue;
                                }
                                ?>
                                <option value="<?= $roleId ?>"><?= esc($roleName) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="text-sm italic font-bold mt-1" id="role_id-error" style="display: none; color: #dc2626;"></div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">İptal</button>
            <button class="kt-btn kt-btn-primary" type="button" data-assign-role-submit onclick="assignPermission()">
                Yetki Ata
            </button>
        </div>
    </div>
</div>

<script>
    const assignRoleEndpoint = typeof assignRoleUrl !== 'undefined'
        ? assignRoleUrl
        : '<?= base_url('admin/api/users/assign-role') ?>';

    function showAlert(type, message, title = null) {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;

        const alertId = 'alert_' + Date.now();
        const alertClass = `kt-alert-${type}`;
        const alertTitle = title || getDefaultTitle(type);

        const alertHTML = `
        <div class="kt-alert kt-alert-light ${alertClass}" id="${alertId}">
            <div class="kt-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="kt-alert-title">${alertTitle}</div>
            <div class="kt-alert-toolbar">
                <div class="kt-alert-actions">
                    <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

        alertContainer.insertAdjacentHTML('beforeend', alertHTML);
        alertContainer.style.display = 'block';

        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.remove();
                if (alertContainer.children.length === 0) {
                    alertContainer.style.display = 'none';
                }
            }
        }, 5000);
    }

    function getDefaultTitle(type) {
        const titles = {
            success: 'Başarılı!',
            primary: 'Bilgi',
            info: 'Bilgi',
            warning: 'Uyarı',
            destructive: 'Hata'
        };
        return titles[type] || 'Bilgi';
    }

    function clearAlerts() {
        const alertContainer = document.getElementById('alertContainer');
        if (alertContainer) {
            alertContainer.innerHTML = '';
            alertContainer.style.display = 'none';
        }
    }

    function setAssignButtonLoading(isLoading) {
        const submitBtn = document.querySelector('[data-assign-role-submit]');
        if (!submitBtn) return;
        submitBtn.disabled = isLoading;
        submitBtn.classList.toggle('pointer-events-none', isLoading);
        submitBtn.classList.toggle('opacity-70', isLoading);
    }

    function closeModal() {
        const modal = document.getElementById('assignPermissionModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('kt-modal-open');
            document.body.classList.remove('kt-modal-open');

            document.querySelectorAll('.kt-modal-backdrop, [data-kt-modal-backdrop]').forEach(backdrop => backdrop.remove());

            document.body.style.filter = '';
            document.body.style.backdropFilter = '';
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            const form = document.getElementById('assignPermissionForm');
            if (form) {
                form.reset();
            }

            clearAlerts();
            clearAllPermissionErrors();
            setAssignButtonLoading(false);
        }
    }

    function showPageAlert(type, message, title = null) {
        let pageAlertContainer = document.getElementById('pageAlertContainer');
        if (!pageAlertContainer) {
            pageAlertContainer = document.createElement('div');
            pageAlertContainer.id = 'pageAlertContainer';
            pageAlertContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            width: 100%;
        `;
            document.body.appendChild(pageAlertContainer);
        }

        const alertId = 'pageAlert_' + Date.now();
        const alertClass = `kt-alert-${type}`;
        const alertTitle = title || getDefaultTitle(type);

        const alertHTML = `
        <div class="kt-alert kt-alert-light ${alertClass} mb-3" id="${alertId}" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <div class="kt-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="kt-alert-title">${alertTitle}</div>
            <div class="kt-alert-toolbar">
                <div class="kt-alert-actions">
                    <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

        pageAlertContainer.insertAdjacentHTML('beforeend', alertHTML);

        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                    if (pageAlertContainer.children.length === 0) {
                        pageAlertContainer.remove();
                    }
                }, 300);
            }
        }, 4000);
    }

    function parseErrors(errors) {
        if (!errors) return '';
        if (Array.isArray(errors)) return errors.join(' ');
        if (typeof errors === 'object') return Object.values(errors).join(' ');
        return String(errors);
    }

    // Validasyon yardımcı fonksiyonları
    function showPermissionFieldError(fieldId, message) {
        const errorDiv = document.getElementById(fieldId + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
        
        const field = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (field) {
            field.classList.add('border-red-500');
            field.focus();
        }
    }

    function clearPermissionFieldError(fieldId) {
        const errorDiv = document.getElementById(fieldId + '-error');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
        
        const field = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (field) {
            field.classList.remove('border-red-500');
        }
    }

    function clearAllPermissionErrors() {
        clearPermissionFieldError('user_id');
        clearPermissionFieldError('role_id');
    }

    // Dinamik sayfa güncelleme fonksiyonları
    function updateUserInTable(userId, roleId, roleLabel) {
        // Kullanıcı satırını bul ve güncelle
        const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);
        if (userRow) {
            const roleCell = userRow.querySelector('.user-role');
            if (roleCell) {
                roleCell.textContent = roleLabel;
                roleCell.className = roleCell.className.replace(/role-\w+/g, `role-${roleId}`);
            }
            
            // Badge güncelle
            const roleBadge = userRow.querySelector('.role-badge');
            if (roleBadge) {
                roleBadge.textContent = roleLabel;
                roleBadge.className = `role-badge role-${roleId}`;
            }
        }
    }

    function refreshUserTable() {
        // AJAX ile tablo verilerini yenile
        const tableContainer = document.querySelector('.user-table-container');
        if (tableContainer) {
            fetch(window.location.href, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Sadece tablo kısmını güncelle
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                const newTable = newDoc.querySelector('.user-table-container');
                if (newTable) {
                    tableContainer.innerHTML = newTable.innerHTML;
                }
            })
            .catch(error => {
                console.error('Tablo yenileme hatası:', error);
            });
        }
    }

    function triggerPageUpdate() {
        // Custom event gönder
        const event = new CustomEvent('userRoleUpdated', {
            detail: {
                timestamp: Date.now(),
                message: 'Kullanıcı yetkisi güncellendi'
            }
        });
        document.dispatchEvent(event);
    }

    function validatePermissionForm() {
        const form = document.getElementById('assignPermissionForm');
        if (!form) return false;
        
        let isValid = true;
        
        // Hata mesajlarını temizle
        clearAllPermissionErrors();
        
        // Kullanıcı seçimi kontrolü
        const userId = form.querySelector('select[name="user_id"]').value.trim();
        if (!userId) {
            showPermissionFieldError('user_id', 'Kullanıcı seçimi zorunludur.');
            isValid = false;
        }
        
        // Yetki seçimi kontrolü
        const roleId = form.querySelector('select[name="role_id"]').value.trim();
        if (!roleId) {
            showPermissionFieldError('role_id', 'Yetki seçimi zorunludur.');
            isValid = false;
        }
        
        return isValid;
    }

    async function assignPermission() {
        const form = document.getElementById('assignPermissionForm');
        if (!form) return;

        clearAlerts();
        clearAllPermissionErrors();

        // Form validasyonu
        if (!validatePermissionForm()) {
            return;
        }

        const formData = new FormData(form);
        const userId = Number(formData.get('user_id'));
        const roleId = Number(formData.get('role_id'));

        setAssignButtonLoading(true);

        try {
            const response = await fetch(assignRoleEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    role_id: roleId
                })
            });

            const result = await response.json().catch(() => ({}));

            if (!response.ok || !result.success) {
                const errorMessage = parseErrors(result.errors) || result.message || 'Rol atanamadı.';
                showAlert('destructive', errorMessage);
                return;
            }

            const roleLabel =
                (result.role && result.role.role_name)
                || (typeof ROLE_NAMES !== 'undefined' && ROLE_NAMES ? ROLE_NAMES[Number(roleId)] : '')
                || String(roleId);


            // 1. Önce mevcut fonksiyonları dene (eğer ana sayfada tanımlıysa)
            let pageUpdated = false;
            
            if (typeof updateUserRowRoles === 'function') {
                try {
                    updateUserRowRoles(userId, roleId, roleLabel);
                    pageUpdated = true;
                } catch (e) {
                    console.warn('Ana sayfa güncelleme hatası:', e);
                }
            }

            // 2. DataTable varsa refresh et
            if (typeof window.userDataTable !== 'undefined' && window.userDataTable) {
                try {
                    window.userDataTable.ajax.reload();
                    pageUpdated = true;
                } catch (e) {
                    console.warn('DataTable yenileme hatası:', e);
                }
            }

            // 3. Custom event gönder
            triggerPageUpdate();

            // 4. Güvenli sayfa yenileme (2 saniye sonra)
            setTimeout(() => {
                window.location.reload();
            }, 2000);

            if (result.duplicate) {
                showPageAlert('info', result.message || 'Rol zaten atanmış.', 'Bilgi');
            } else {
                showPageAlert('success', result.message || 'Rol başarıyla atandı. Sayfa yenileniyor...', 'İşlem Başarılı');
            }

            // Modal'ı hemen kapatma, sayfa yenilene kadar bekle
            setTimeout(() => {
                form.reset();
                closeModal();
            }, 1500);
        } catch (error) {
            console.error('assign-role', error);
            showAlert('destructive', 'Rol atanırken beklenmeyen bir hata oluştu.');
        } finally {
            setAssignButtonLoading(false);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('assignPermissionModal');
        if (modal) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        const target = mutation.target;
                        if (target.style.display === 'flex' || target.classList.contains('kt-modal-open')) {
                            clearAlerts();
                        }
                    }
                });
            });

            observer.observe(modal, {
                attributes: true,
                attributeFilter: ['style', 'class']
            });
        }

        document.addEventListener('click', function (e) {
            const modalEl = document.getElementById('assignPermissionModal');
            if (modalEl && e.target === modalEl) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modalEl = document.getElementById('assignPermissionModal');
                if (modalEl && modalEl.classList.contains('kt-modal-open')) {
                    closeModal();
                }
            }
        });

        // Real-time validasyon için event listener'lar
        const userSelect = document.getElementById('assign_user_id');
        const roleSelect = document.querySelector('select[name="role_id"]');
        
        if (userSelect) {
            userSelect.addEventListener('change', function() {
                if (this.value.trim()) {
                    clearPermissionFieldError('user_id');
                }
            });
        }
        
        if (roleSelect) {
            roleSelect.addEventListener('change', function() {
                if (this.value.trim()) {
                    clearPermissionFieldError('role_id');
                }
            });
        }
    });
</script>
<script>
    (function () {
        const modalSelector = '#assignPermissionModal';
        const userSelect = document.getElementById('assign_user_id');
        let loadedOnce = false; // istersen hep yükle; istersen ilkinde cachele

        // Modal açma tetikleyicileri
        document.querySelectorAll('[data-kt-modal-toggle="#assignPermissionModal"]').forEach(btn => {
            btn.addEventListener('click', openModalAndLoadUsers);
        });

        async function openModalAndLoadUsers() {
            if (!userSelect) return;

            // Her seferinde taze liste istiyorsan loadedOnce kontrolünü kaldır
            if (loadedOnce && userSelect.options.length > 1) return;

            // Temizle & “Yükleniyor” ekle
            userSelect.innerHTML = '<option value="">Yükleniyor...</option>';

            try {
                const res = await fetch('<?= site_url('api/users/options') ?>', { method: 'GET' });
                const json = await res.json();
                const list = Array.isArray(json?.data) ? json.data : [];

                // Doldur
                userSelect.innerHTML = '<option value="">Seçiniz</option>';
                for (const item of list) {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.text ? `${item.text} — ${item.email}` : item.email;
                    userSelect.appendChild(opt);
                }

                // Choices.js kullanıyorsan refresh et
                if (userSelect.closest('.choices') || userSelect.dataset.choices === 'true') {
                    // basit yeniden başlatma
                    const evt = new Event('change', { bubbles: true });
                    userSelect.dispatchEvent(evt);
                }

                loadedOnce = true;
            } catch (e) {
                userSelect.innerHTML = '<option value="">Liste alınamadı</option>';
                console.error(e);
            }
        }
    })();

</script>