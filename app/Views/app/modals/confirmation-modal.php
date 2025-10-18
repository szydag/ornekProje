<!-- Confirmation Dialog Modal -->
<div class="kt-modal" data-kt-modal="true" id="confirmationModal">
    <div class="kt-modal-content max-w-[600px] top-[15%]">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-question text-warning text-xl" id="confirmationHeaderIcon"></i>
                <h3 class="text-lg font-semibold text-mono" id="confirmationTitle">Onay Gerekli</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0"
                data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5">
            <div class="flex items-start gap-4 mb-4">
                <div class="flex-1">
                    <p class="text-sm text-mono" id="confirmationMessage">
                        Bu işlemi gerçekleştirmek istediğinizden emin misiniz?
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-1 mb-4">
                <label class="kt-label text-sm font-medium text-foreground mb-1">Dosya Seç <span class="text-danger">*</span></label>
                <input type="file" id="required_file_input" name="required_file" class="kt-input" accept=".pdf,.doc,.docx,.odt,.rtf,.tex,.latex,.txt,.jpg,.jpeg,.png,.pptx,.xml,.xlsx,.xls" required />
            </div>

            <!-- Açıklama -->
            <div class="flex flex-col gap-1">
                <label class="kt-label text-sm font-medium text-foreground mb-1">Açıklama</label>
                <textarea id="required_file_desc_input" name="file_description" class="kt-textarea" rows="3" placeholder="Bu dosya hakkında açıklama yazabilirsiniz (isteğe bağlı)"></textarea>
            </div>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-primary" onclick="executeConfirmationAction()">
                Onayla
            </button>
        </div>
    </div>
</div>

<script>
    // Confirmation Dialog Functions
    let confirmationAction = null;

    function setConfirmationData(action, itemId) {
        const titles = {
            'edit': 'Kurs Düzenle',
            'addEditor': 'Yönetici Ekle',
            'addArticle': 'İçerik Ekle',
            'delete': 'Kurs Sil',
            'removeArticle': 'Eğitim İçeriği Çıkar',
            'approve': 'Eğitim İçeriği Onayla',
            'revision': 'Eğitim İçeriği Revizyon',
            'reject': 'Eğitim İçeriği Reddet'
        };

        const messages = {
            'edit': 'Kursyi düzenlemek istediğinizden emin misiniz?',
            'addEditor': 'Bu kursye yönetici eklemek istediğinizden emin misiniz?',
            'addArticle': 'Bu kursye içerik eklemek istediğinizden emin misiniz?',
            'delete': 'Bu kursyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.',
            'removeArticle': 'Bu içerikyi kursden çıkarmak istediğinizden emin misiniz?',
            'approve': 'Bu içerikyi onaylamak istediğinizden emin misiniz? Lütfen açıklama ekleyin.',
            'revision': 'Bu içerik için revizyon istemek istediğinizden emin misiniz? Lütfen revizyon açıklaması ekleyin.',
            'reject': 'Bu içerikyi reddetmek istediğinizden emin misiniz? Lütfen red nedeni açıklayın.'
        };

        const actions = {
            'edit': function() {
                editCourse(itemId);
            },
            'addEditor': function() {
                addEditor(itemId);
            },
            'addArticle': function() {
                addContent(itemId);
            },
            'delete': function() {
                deleteCourse(itemId);
            },
            'removeArticle': function() {
                removeContent(itemId);
            },
            'approve': function() {
                approveContent(itemId);
            },
            'revision': function() {
                revisionContent(itemId);
            },
            'reject': function() {
                rejectContent(itemId);
            }
        };

        const iconConfigs = {
            'edit': {
                icon: 'ki-pencil',
                color: 'text-blue-500',
                bgColor: 'bg-blue-500/10'
            },
            'addEditor': {
                icon: 'ki-users',
                color: 'text-green-500',
                bgColor: 'bg-green-500/10'
            },
            'addArticle': {
                icon: 'ki-document',
                color: 'text-blue-500',
                bgColor: 'bg-blue-500/10'
            },
            'delete': {
                icon: 'ki-trash',
                color: 'text-red-500',
                bgColor: 'bg-red-500/10'
            },
            'removeArticle': {
                icon: 'ki-cross',
                color: 'text-red-500',
                bgColor: 'bg-red-500/10'
            },
            'approve': {
                icon: 'ki-check',
                color: 'text-green-500',
                bgColor: 'bg-green-500/10'
            },
            'revision': {
                icon: 'ki-arrows-circle',
                color: 'text-yellow-500',
                bgColor: 'bg-yellow-500/10'
            },
            'reject': {
                icon: 'ki-cross',
                color: 'text-red-500',
                bgColor: 'bg-red-500/10'
            }
        };

        // Set title and message
        document.getElementById('confirmationTitle').textContent = titles[action];
        document.getElementById('confirmationMessage').textContent = messages[action];
        confirmationAction = actions[action];

        // Set icons and colors
        const config = iconConfigs[action];
        const headerIcon = document.getElementById('confirmationHeaderIcon');
        const bodyIcon = document.getElementById('confirmationBodyIcon');
        const iconContainer = document.getElementById('confirmationIconContainer');

        // Update header icon
        headerIcon.className = `ki-filled ${config.icon} ${config.color} text-xl`;

        // Update body icon
        bodyIcon.className = `ki-filled ${config.icon} ${config.color} text-xl`;

        // Update icon container background
        iconContainer.className = `flex items-center justify-center size-12 rounded-full ${config.bgColor} shrink-0`;

        // Eğitim içeriği işlemleri için dosya ve açıklama alanlarını göster/gizle
        const fileInput = document.getElementById('required_file_input');
        const descInput = document.getElementById('required_file_desc_input');
        const fileLabel = document.querySelector('label[for="required_file_input"]') || document.querySelector('label:has(#required_file_input)');

        if (['approve', 'revision', 'reject'].includes(action)) {
            // Dosya alanını göster ve zorunlu yap
            fileInput.style.display = 'block';
            fileInput.required = true;
            
            // Label'ı güncelle
            if (action === 'approve') {
                fileLabel.innerHTML = 'Onay Belgesi <span class="text-danger">*</span>';
                descInput.placeholder = 'Onay açıklaması yazabilirsiniz (isteğe bağlı)';
            } else if (action === 'revision') {
                fileLabel.innerHTML = 'Revizyon Belgesi <span class="text-danger">*</span>';
                descInput.placeholder = 'Revizyon açıklaması yazabilirsiniz (isteğe bağlı)';
            } else if (action === 'reject') {
                fileLabel.innerHTML = 'Red Belgesi <span class="text-danger">*</span>';
                descInput.placeholder = 'Red nedeni yazabilirsiniz (isteğe bağlı)';
            }

            // Form alanlarını temizle
            fileInput.value = '';
            descInput.value = '';
        } else {
            // Diğer işlemler için dosya alanını gizle
            fileInput.style.display = 'none';
            fileInput.required = false;
            fileLabel.innerHTML = 'Dosya Seç <span class="text-danger">*</span>';
            descInput.placeholder = 'Bu dosya hakkında açıklama yazabilirsiniz (isteğe bağlı)';
        }
    }

    function executeConfirmationAction() {
        // Eğitim içeriği işlemleri için dosya kontrolü
        const fileInput = document.getElementById('required_file_input');
        const descInput = document.getElementById('required_file_desc_input');
        
        // Eğer dosya alanı görünürse (içerik işlemleri)
        if (fileInput.style.display !== 'none') {
            // Dosya kontrolü
            if (!fileInput.files || fileInput.files.length === 0) {
                alert('Lütfen dosya seçiniz.');
                return;
            }
            
            // Dosya ve açıklama verilerini al
            const file = fileInput.files[0];
            const description = descInput.value.trim();
            
            // Verileri global değişkenlere kaydet
            window.currentActionData = {
                file: file,
                description: description
            };
        }

        if (confirmationAction) {
            confirmationAction();
        }
        // Modal'ı kapat - Metronic'in dismiss butonunu tetikle
        const dismissButton = document.querySelector('#confirmationModal [data-kt-modal-dismiss="true"]');
        if (dismissButton) {
            dismissButton.click();
        }
    }

    function showPageAlert(type, message, title = null) {
        // Sayfanın sağ üst köşesinde alert container'ı oluştur
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="kt-alert-title">${alertTitle}</div>
            <div class="kt-alert-toolbar">
                <div class="kt-alert-actions">
                    <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

        pageAlertContainer.insertAdjacentHTML('beforeend', alertHTML);

        // Auto-hide after 4 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                    // Container'ı temizle eğer boşsa
                    if (pageAlertContainer.children.length === 0) {
                        pageAlertContainer.remove();
                    }
                }, 300);
            }
        }, 4000);
    }

    function getDefaultTitle(type) {
        const titles = {
            'success': 'Başarılı!',
            'primary': 'Bilgi',
            'info': 'Bilgi',
            'warning': 'Uyarı',
            'destructive': 'Hata'
        };
        return titles[type] || 'Bilgi';
    }
</script>