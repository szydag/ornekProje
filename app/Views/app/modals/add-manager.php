<?php // app/Views/app/modals/add-manager.php ?>
<div class="kt-modal" data-kt-modal="true" id="addManagerModal">
    <div class="kt-modal-content max-w-[600px] top-[15%]">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-user-plus text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-mono">Yönetici Ekle</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5">
            <div class="space-y-3 mb-4" id="alertContainer" style="display: none;"></div>

            <form id="addManagerForm" class="space-y-4">
                <div class="text-start mb-4">
                    <p class="text-gray-600">
                        Bu kursye yönetici olarak atanacak kullanıcıyı seçiniz.
                    </p>
                </div>

                <div class="kt-form-field">
                    <label class="kt-form-label mb-2">
                        Yönetici Seç <span class="text-danger">*</span>
                    </label>
                    <select id="manager_user_id" name="user_id" class="kt-select" data-kt-select="true"
                        data-kt-select-enable-search="true" data-kt-select-search-placeholder="Yönetici ara..."
                        data-kt-select-placeholder="Yönetici seçin..."
                        data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}'>
                        <option value="">Yönetici seçin</option>
                        <!-- Yöneticiler JavaScript ile yüklenecek -->
                    </select>
                    <div class="text-sm italic font-bold mt-1" id="user_id-error" style="display: none; color: #dc2626;"></div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">İptal</button>
            <button class="kt-btn kt-btn-primary" type="button" data-add-manager-submit onclick="addManager()">
                Yönetici Ekle
            </button>
        </div>
    </div>
</div>

<script>
    const addManagerEndpoint = (typeof addManagerUrl !== 'undefined' && addManagerUrl)
        ? addManagerUrl
        : null;

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

    function setAddManagerButtonLoading(isLoading) {
        const submitBtn = document.querySelector('[data-add-manager-submit]');
        if (!submitBtn) return;
        submitBtn.disabled = isLoading;
        submitBtn.classList.toggle('pointer-events-none', isLoading);
        submitBtn.classList.toggle('opacity-70', isLoading);
    }

    function closeModal() {
        const modal = document.getElementById('addManagerModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('kt-modal-open');
            document.body.classList.remove('kt-modal-open');

            document.querySelectorAll('.kt-modal-backdrop, [data-kt-modal-backdrop]').forEach(backdrop => backdrop.remove());

            document.body.style.filter = '';
            document.body.style.backdropFilter = '';
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            const form = document.getElementById('addManagerForm');
            if (form) {
                form.reset();
            }

            clearAlerts();
            clearAllManagerErrors();
            setAddManagerButtonLoading(false);
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
    function showManagerFieldError(fieldId, message) {
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

    function clearManagerFieldError(fieldId) {
        const errorDiv = document.getElementById(fieldId + '-error');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
        
        const field = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (field) {
            field.classList.remove('border-red-500');
        }
    }

    function clearAllManagerErrors() {
        clearManagerFieldError('user_id');
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

    function validateManagerForm() {
        const form = document.getElementById('addManagerForm');
        if (!form) return false;
        
        let isValid = true;
        
        // Hata mesajlarını temizle
        clearAllManagerErrors();
        
        // Yönetici seçimi kontrolü
        const userId = form.querySelector('select[name="user_id"]').value.trim();
        if (!userId) {
            showManagerFieldError('user_id', 'Yönetici seçimi zorunludur.');
            isValid = false;
        }
        
        return isValid;
    }

    function addManager() {
        // Basit validasyon
        const form = document.getElementById('addManagerForm');
        if (!form) return;

        clearAlerts();
        clearAllManagerErrors();

        if (!validateManagerForm()) {
            return;
        }

        if (!addManagerEndpoint) {
            showAlert('destructive', 'Yönetici ekleme endpointi tanımlı değil.');
            return;
        }

        const selectedUserId = parseInt(form.querySelector('select[name="user_id"]').value, 10);
        if (!selectedUserId) {
            showManagerFieldError('user_id', 'Yönetici seçimi zorunludur.');
            return;
        }

        setAddManagerButtonLoading(true);

        fetch(addManagerEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                manager_ids: [selectedUserId],
            }),
        })
        .then(async response => {
            let data = null;
            try {
                data = await response.json();
            } catch (err) {
                // JSON parse hatası durumunda data null kalır
            }

            if (!response.ok || !data || data.success !== true) {
                const message = (data && (data.error || parseErrors(data.errors))) || 'Yönetici eklenemedi.';
                throw new Error(message);
            }

            showAlert('success', 'Yönetici başarıyla atandı.', 'Başarılı');

            setTimeout(() => {
                form.reset();
                closeModal();
                window.location.reload();
            }, 1200);
        })
        .catch(error => {
            showAlert('destructive', error.message || 'Yönetici eklenirken bir hata oluştu.');
        })
        .finally(() => {
            setAddManagerButtonLoading(false);
        });
    }

    // Kurs ID'sini alma fonksiyonu
    function getCourseId() {
        // URL'den kurs ID'sini al
        const pathParts = window.location.pathname.split('/');
        const courseIndex = pathParts.indexOf('course');
        if (courseIndex !== -1 && pathParts[courseIndex + 1]) {
            return parseInt(pathParts[courseIndex + 1]);
        }
        
        // Global değişkenden al
        if (typeof currentCourseId !== 'undefined') {
            return currentCourseId;
        }
        
        // Varsayılan değer
        return 0;
    }

    // Yönetici kullanıcıları yükleme fonksiyonu (add-course-modal.php'den uyarlandı)
    function loadManagerUsers() {
        fetch('<?= base_url('admin/api/managers') ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success && data.data && data.data.length > 0) {
                const select = document.getElementById('manager_user_id');
                if (select) {
                    // Mevcut option'ları temizle (ilk option hariç)
                    select.innerHTML = '<option value="">Yönetici seçin</option>';
                    
                    // Yeni option'ları ekle
                    data.data.forEach(manager => {
                        const option = document.createElement('option');
                        option.value = manager.id;
                        // Yönetici adını ve soyadını güzel göster
                        const displayName = manager.name && manager.surname ? 
                            `${manager.name} ${manager.surname}` : 
                            (manager.name || manager.email);
                        option.textContent = displayName;
                        select.appendChild(option);
                    });
                    
                }
            } else {
                console.warn('Yönetici verisi bulunamadı:', data);
                const select = document.getElementById('manager_user_id');
                if (select) {
                    select.innerHTML = '<option value="">Yönetici bulunamadı</option>';
                }
            }
        })
        .catch(error => {
            console.error('Yöneticiler yüklenirken hata:', error);
            const select = document.getElementById('manager_user_id');
            if (select) {
                select.innerHTML = '<option value="">Yöneticiler yüklenemedi</option>';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('addManagerModal');
        
        if (!modal) {
            console.error('addManagerModal elementi bulunamadı!');
            return;
        }
        
        
        // Modal açılma butonlarına event listener ekle
        document.addEventListener('click', function(e) {
            
            // Modal açma butonlarını kontrol et
            let target = null;
            
            if (e.target.hasAttribute && e.target.getAttribute('data-kt-modal-toggle') === '#addManagerModal') {
                target = e.target;
            } else if (e.target.closest && e.target.closest('[data-kt-modal-toggle="#addManagerModal"]')) {
                target = e.target.closest('[data-kt-modal-toggle="#addManagerModal"]');
            }
            
            if (target) {
                setTimeout(() => {
                    clearAlerts();
                    loadManagerUsers();
                }, 500);
            }
        });

        // MutationObserver'ı ekle (add-course-modal.php'den uyarlandı)
        if (modal) {
            // Modal açıldığında alert'leri temizle ve yöneticileri yükle
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        const target = mutation.target;
                        if (target.style.display === 'block' || target.style.display === 'flex' || target.classList.contains('kt-modal-open')) {
                            clearAlerts();
                            loadManagerUsers(); // Yöneticileri yükle
                        }
                    }
                });
            });
            
            observer.observe(modal, {
                attributes: true,
                attributeFilter: ['style', 'class']
            });
            
            // Alternatif yöntem: Modal'ın görünür olup olmadığını kontrol et
            const checkModalVisibility = () => {
                if (modal && modal.offsetParent !== null) {
                    clearAlerts();
                    loadManagerUsers();
                }
            };
            
            // Modal açıldığında kontrol et
            const modalObserver = new MutationObserver(checkModalVisibility);
            modalObserver.observe(modal, {
                attributes: true,
                attributeFilter: ['style', 'class']
            });
        }

        document.addEventListener('click', function (e) {
            const modalEl = document.getElementById('addManagerModal');
            if (modalEl && e.target === modalEl) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modalEl = document.getElementById('addManagerModal');
                if (modalEl && modalEl.classList.contains('kt-modal-open')) {
                    closeModal();
                }
            }
        });

        // Real-time validasyon için event listener
        const userSelect = document.getElementById('manager_user_id');
        
        if (userSelect) {
            userSelect.addEventListener('change', function() {
                if (this.value.trim()) {
                    clearManagerFieldError('user_id');
                }
            });
        }
    });
</script>
