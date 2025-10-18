<div class="kt-modal" data-kt-modal="true" id="add_file_modal">
    <!-- Blur backdrop -->
    <div class="kt-modal-backdrop"></div>

    <!-- Modal content -->
    <div class="kt-modal-content max-w-[600px] top-[15%]">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title">
                Ek Dosya Yükle
            </h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body px-5 py-5" style="max-height: calc(80vh - 120px); overflow-y: auto; overflow-x: hidden; visibility: visible; opacity: 1; background: white;">
            <!-- Alert Container -->
            <div class="space-y-3 mb-4" id="fileAlertContainer" style="display: none;">
                <!-- Alerts will be dynamically inserted here -->
            </div>
            
            <div class="grid gap-5">
                <form id="addFileForm">
                    <!-- Dosya Tipi -->
                    <div class="flex flex-col gap-1 mb-4">
                        <label class="kt-label text-sm font-medium text-foreground mb-1">
                            Dosya Tipi <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" name="file_type" id="file_type_select" data-kt-select-placeholder="Dosya tipi seçin..." required data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <option value="">Dosya tipi seçin</option>
                            <option value="1">Eğitim İçeriği Metni</option>
                            <option value="2">Şekil/Grafik</option>
                            <option value="3">Tablo</option>
                            <option value="4">Ek Materyal</option>
                            <option value="5">Kapak Sayfası</option>
                            <option value="6">Özet</option>
                            <option value="7">Referanslar</option>
                            <option value="8">Diğer</option>
                        </select>
                    </div>

                    <!-- Açıklama -->
                    <div class="flex flex-col gap-1 mb-4">
                        <label class="kt-label text-sm font-medium text-foreground  mb-1">
                            Açıklama
                        </label>
                        <input class="kt-input" name="file_description" type="text" placeholder="Dosya açıklaması" />
                    </div>

                    <!-- Dosya -->
                    <div class="flex flex-col gap-1 mb-4">
                        <label class="kt-label text-sm font-medium text-foreground  mb-1">
                            Dosya <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="additional_file" type="file" id="additional_file_input" accept=".xlsx,.odt,.rtf,.rtx,.latex,.txt,.tex,.pdf,.docx,.doc,.xls,.jpeg,.png,.pptx,.xml" required />
                    </div>

                    <!-- Dosya Uzantıları Açıklaması -->
                    <div class="p-4 bg-accent/10 rounded-lg">
                        <h6 class="text-sm font-medium text-mono mb-1">Geçerli Dosya Uzantıları:</h6>
                        <p class="text-xs text-secondary-foreground">
                            .xlsx, .odt, .rtf, .rtx, .latex, .txt, .tex, .pdf, .docx, .doc, .xls, .jpeg, .png, .pptx, .xml
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="kt-modal-footer">
            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-primary" onclick="addFile()">
                Ekle
            </button>
        </div>
    </div>
</div>

<script>
function showFileAlert(type, message, title = null) {
    const alertContainer = document.getElementById('fileAlertContainer');
    if (!alertContainer) return;
    
    const alertId = 'alert_' + Date.now();
    const alertClass = `kt-alert-${type}`;
    const alertTitle = title || getDefaultTitle(type);
    
    const alertHTML = `
        <div class="kt-alert kt-alert-light ${alertClass}" id="${alertId}">
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
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    alertContainer.style.display = 'block';
    
    // Auto-hide after 5 seconds
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
        'success': 'Başarılı!',
        'primary': 'Bilgi',
        'info': 'Bilgi',
        'warning': 'Uyarı',
        'destructive': 'Hata'
    };
    return titles[type] || 'Bilgi';
}

function clearFileAlerts() {
    const alertContainer = document.getElementById('fileAlertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = '';
        alertContainer.style.display = 'none';
    }
}

function closeFileModal() {
    const modal = document.getElementById('add_file_modal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('kt-modal-open');
        document.body.classList.remove('kt-modal-open');
        
        // Tüm backdrop'ları temizle (birden fazla olabilir)
        const backdrops = document.querySelectorAll('.kt-modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.remove();
        });
        
        // Metronic'in oluşturduğu backdrop'ları da temizle
        const metronicBackdrops = document.querySelectorAll('[data-kt-modal-backdrop]');
        metronicBackdrops.forEach(backdrop => {
            backdrop.remove();
        });
        
        // Body'deki blur effect'i kaldır
        document.body.style.filter = '';
        document.body.style.backdropFilter = '';
        
        // Body'den modal class'larını ve style'ları temizle
        document.body.classList.remove('kt-modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Form'u temizle
        const form = document.getElementById('addFileForm');
        if (form) {
            form.reset();
        }
        
        // Alert'leri temizle
        clearFileAlerts();
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

function addFile() {
    const form = document.getElementById('addFileForm');
    if (!form) return;
    
    // Clear previous alerts
    clearFileAlerts();
    
    const formData = new FormData(form);
    
    // Modal'ı hemen kapat
    closeFileModal();
    
    // Sayfanın sağ üst köşesinde başarı mesajı göster
    showPageAlert('success', 'Dosya başarıyla yüklendi!', 'İşlem Başarılı');
}

// DOM yüklendiğinde event listener'ları ekle
document.addEventListener('DOMContentLoaded', function() {
    // Modal açıldığında alert'leri temizle
    const modal = document.getElementById('add_file_modal');
    if (modal) {
        // Modal açıldığında alert'leri temizle
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const target = mutation.target;
                    if (target.style.display === 'flex' || target.classList.contains('kt-modal-open')) {
                        clearFileAlerts();
                    }
                }
            });
        });
        
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
    }
    
    // Modal dışına tıklandığında kapatma
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('add_file_modal');
        if (modal && e.target === modal) {
            closeFileModal();
        }
    });
    
    // ESC tuşu ile modal kapatma
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('add_file_modal');
            if (modal && modal.classList.contains('kt-modal-open')) {
                closeFileModal();
            }
        }
    });
});
</script>