<!-- Kurs Düzenle Modal -->
<div class="kt-modal" data-kt-modal="true" id="editEncyclopediaModal">
    <div class="kt-modal-content max-w-[800px]" style="top: 7%;">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-pencil text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-mono">Kurs Düzenle</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0"
                data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5">
            <!-- Alert Container -->
            <div class="space-y-3 mb-4" id="editAlertContainer" style="display: none;">
                <!-- Alerts will be dynamically inserted here -->
            </div>
            
            <form id="editEncyclopediaForm" class="space-y-4">
                <input type="hidden" name="course_id" id="edit_course_id" value="" />
                
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Kurs Adı*
                    </label>
                    <div>
                        <input type="text" name="course_name" class="kt-input" placeholder="Kurs adını girin" id="edit_course_name-input" />
                        <div class="text-red-500 text-sm italic mt-1" id="edit_course_name-error" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Kurs Açıklama*
                    </label>
                    <div>
                        <textarea name="course_description" class="kt-textarea" placeholder="Kurs açıklamasını girin" rows="4" id="edit_course_description-input"></textarea>
                        <div class="text-red-500 text-sm italic mt-1" id="edit_course_description-error" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Başlangıç Tarihi*
                    </label>
                    <div>
                        <input type="date" name="start_date" class="kt-input" id="edit_start_date-input" />
                        <div class="text-red-500 text-sm italic mt-1" id="edit_start_date-error" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Bitiş Tarihi
                    </label>
                    <div class="space-y-2">
                        <input type="date" name="end_date" class="kt-input" id="edit_end_date-input" />
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="unlimited" id="edit_unlimited-checkbox" onchange="toggleEditEndDate()" />
                            <label for="edit_unlimited-checkbox" class="text-sm text-muted-foreground cursor-pointer">
                                Süresiz olarak işaretle
                            </label>
                        </div>
                        <div class="text-red-500 text-sm italic mt-1" id="edit_end_date-error" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Yönetici Ata*
                    </label>
                    <div>
                        <select name="manager" class="kt-select" id="edit_manager-input" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <option value="">Yönetici seçin</option>
                        </select>
                        <div class="text-red-500 text-sm italic mt-1" id="edit_manager-error" style="display: none;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-primary" onclick="saveEditEncyclopedia()">
                Güncelle
            </button>
        </div>
    </div>
</div>

<script>
// Sayfa yüklendiğinde yöneticileri yükle
document.addEventListener('DOMContentLoaded', function() {
    // Modal hazır
});

// Yöneticileri yükle
function loadEditManagers() {
    fetch('api/managers', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const managerSelect = document.getElementById('edit_manager-input');
        if (!managerSelect) {
            return;
        }
        
        // Dropdown'ı temizle
        managerSelect.innerHTML = '<option value="">Yönetici seçin</option>';
        
        if (data.success && data.data && Array.isArray(data.data)) {
            // Tüm yöneticileri ekle
            data.data.forEach(manager => {
                const option = document.createElement('option');
                option.value = manager.id;
                
                // Farklı veri yapılarını destekle
                let managerName = '';
                if (manager.first_name && manager.last_name) {
                    managerName = `${manager.first_name} ${manager.last_name}`;
                } else if (manager.name && manager.surname) {
                    managerName = `${manager.name} ${manager.surname}`;
                } else if (manager.name) {
                    managerName = manager.name;
                } else if (manager.first_name) {
                    managerName = manager.first_name;
                } else {
                    managerName = `Yönetici ${manager.id}`;
                }
                
                option.textContent = managerName.trim();
                managerSelect.appendChild(option);
            });
            
            // Mevcut kurs verisinden yöneticiyi seç
            if (window.currentEncyclopedia) {
                setTimeout(() => {
                    selectCurrentManager(window.currentEncyclopedia);
                }, 100);
            }
        }
    })
    .catch(error => {
        console.error('Managers yükleme hatası:', error);
    });
}

// Mevcut yöneticiyi seç
function selectCurrentManager(course) {
    const managerSelect = document.getElementById('edit_manager-input');
    if (!managerSelect || managerSelect.options.length <= 1) {
        return;
    }
    
    // Kurs verisinden yönetici ID'sini al
    let targetId = null;
    if (course.editors && course.editors.length > 0) {
        targetId = course.editors[0].id;
    } else if (course.manager_id) {
        targetId = course.manager_id;
    } else if (course.user_id) {
        targetId = course.user_id;
    }
    
    if (targetId) {
        // Doğru yöneticiyi bul ve seç
        for (let i = 0; i < managerSelect.options.length; i++) {
            const option = managerSelect.options[i];
            if (String(option.value) === String(targetId)) {
                managerSelect.selectedIndex = i;
                return;
            }
        }
        
        // Eğer eşleşen bulunamazsa, ilk yöneticiyi seç
        managerSelect.selectedIndex = 1;
    } else {
        // Varsayılan olarak ilk yöneticiyi seç
        managerSelect.selectedIndex = 1;
    }
}

// Süresiz checkbox toggle
function toggleEditEndDate() {
    const checkbox = document.getElementById('edit_unlimited-checkbox');
    const endDateInput = document.getElementById('edit_end_date-input');
    
    if (checkbox.checked) {
        endDateInput.disabled = true;
        endDateInput.value = '';
        clearEditFieldError('end_date');
    } else {
        endDateInput.disabled = false;
    }
}

// Kurs güncelle
function saveEditEncyclopedia() {
    clearEditAlerts();
    clearAllEditErrors();
    
    // Form verilerini al
    const formData = new FormData();
    const courseId = document.getElementById('edit_course_id').value;
    const courseName = document.getElementById('edit_course_name-input').value.trim();
    const courseDescription = document.getElementById('edit_course_description-input').value.trim();
    const startDate = document.getElementById('edit_start_date-input').value;
    const endDate = document.getElementById('edit_end_date-input').value;
    const manager = document.getElementById('edit_manager-input').value;
    const unlimited = document.getElementById('edit_unlimited-checkbox').checked;
    
    // Validasyon
    let hasErrors = false;
    
    if (!courseName) {
        showEditFieldError('course_name', 'Kurs adı zorunludur.');
        hasErrors = true;
    } else if (courseName.length < 2) {
        showEditFieldError('course_name', 'Kurs adı en az 2 karakter olmalıdır.');
        hasErrors = true;
    }
    
    if (!courseDescription) {
        showEditFieldError('course_description', 'Kurs açıklaması zorunludur.');
        hasErrors = true;
    } else if (courseDescription.length < 10) {
        showEditFieldError('course_description', 'Kurs açıklaması en az 10 karakter olmalıdır.');
        hasErrors = true;
    }
    
    if (!startDate) {
        showEditFieldError('start_date', 'Başlangıç tarihi zorunludur.');
        hasErrors = true;
    }
    
    if (!unlimited && !endDate) {
        showEditFieldError('end_date', 'Bitiş tarihi zorunludur veya süresiz olarak işaretleyin.');
        hasErrors = true;
    }
    
    if (unlimited && endDate) {
        showEditFieldError('end_date', 'Süresiz seçili iken bitiş tarihi girilemez.');
        hasErrors = true;
    }
    
    if (!manager) {
        showEditFieldError('manager', 'Yönetici seçimi zorunludur.');
        hasErrors = true;
    }
    
    // Tarih mantık kontrolü
    if (startDate && endDate && !unlimited) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (end <= start) {
            showEditFieldError('end_date', 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır.');
            hasErrors = true;
        }
    }
    
    if (hasErrors) {
        showEditError('Lütfen formu kontrol ederek gerekli alanları doldurunuz.');
        return;
    }
    
    // Form verilerini JSON olarak hazırla
    const jsonData = {
        title: courseName,
        description: courseDescription,
        start_date: startDate,
        end_date: unlimited ? null : endDate,
        manager: manager,
        unlimited: unlimited ? '1' : '0'
    };
    
    // AJAX ile güncelle
    fetch(`updates/courses/${courseId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showEditSuccess('Kurs başarıyla güncellendi.');
            
            // Modal'ı kapat
            setTimeout(() => {
                const modal = document.getElementById('editEncyclopediaModal');
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                
                // Sayfa alert'i göster
                showEditPageAlert('success', 'Kurs başarıyla güncellendi.', 'Başarılı!');
                
                // Sayfayı yenile veya listeyi güncelle
                if (typeof refreshEncyclopediaList === 'function') {
                    refreshEncyclopediaList();
                } else {
                    window.location.reload();
                }
            }, 1500);
            
        } else {
            if (data.errors) {
                // Alan bazlı hataları göster
                Object.keys(data.errors).forEach(field => {
                    showEditFieldError(field, data.errors[field]);
                });
            } else {
                showEditError(data.message || 'Kurs güncellenirken hata oluştu.');
            }
        }
    })
    .catch(error => {
        showEditError('Kurs güncellenirken hata oluştu: ' + error.message);
    });
}

// Alert gösterme fonksiyonu
function showEditAlert(type, message, title = null) {
    const alertContainer = document.getElementById('editAlertContainer');
    if (!alertContainer) return;
    
    const alertId = 'editAlert_' + Date.now();
    const alertClass = `kt-alert-${type}`;
    const alertTitle = title || getEditDefaultTitle(type);
    
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
            <div class="kt-alert-text">${message}</div>
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

function getEditDefaultTitle(type) {
    const titles = {
        'success': 'Başarılı!',
        'primary': 'Bilgi',
        'info': 'Bilgi',
        'warning': 'Uyarı',
        'destructive': 'Hata'
    };
    return titles[type] || 'Bilgi';
}

// Hata mesajı göster (eski fonksiyonlar - geriye dönük uyumluluk için)
function showEditError(message) {
    showEditAlert('destructive', message, 'Hata!');
}

function showEditSuccess(message) {
    showEditAlert('success', message, 'Başarılı!');
}

// Alan hatası göster
function showEditFieldError(fieldName, message) {
    const errorElement = document.getElementById(`edit_${fieldName}-error`);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        errorElement.style.color = '#ef4444';
        errorElement.style.fontStyle = 'italic';
        errorElement.style.fontSize = '0.875rem';
        errorElement.style.marginTop = '0.25rem';
    }
    
    // Input'a kırmızı border ekle
    const inputElement = document.getElementById(`edit_${fieldName}-input`);
    if (inputElement) {
        inputElement.classList.add('border-red-500', 'focus:border-red-500');
        inputElement.classList.remove('border-gray-300', 'focus:border-blue-500');
    }
}

// Alan hatasını temizle
function clearEditFieldError(fieldName) {
    const errorElement = document.getElementById(`edit_${fieldName}-error`);
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }
    
    // Input'tan kırmızı border'ı kaldır
    const inputElement = document.getElementById(`edit_${fieldName}-input`);
    if (inputElement) {
        inputElement.classList.remove('border-red-500', 'focus:border-red-500');
        inputElement.classList.add('border-gray-300', 'focus:border-blue-500');
    }
}

// Tüm alan hatalarını temizle
function clearAllEditErrors() {
    const errorFields = ['course_name', 'course_description', 'start_date', 'end_date', 'manager'];
    errorFields.forEach(field => clearEditFieldError(field));
}

// Sayfa alert fonksiyonu (modal dışında gösterim için)
function showEditPageAlert(type, message, title = null) {
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
    const alertTitle = title || getEditDefaultTitle(type);
    
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
            <div class="kt-alert-text">${message}</div>
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
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
            if (pageAlertContainer.children.length === 0) {
                pageAlertContainer.remove();
            }
        }
    }, 5000);
}

// Alert'leri temizle
function clearEditAlerts() {
    const alertContainer = document.getElementById('editAlertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = '';
        alertContainer.style.display = 'none';
    }
}
</script>

<style>
/* Responsive modal top position */
@media (min-width: 640px) {
    #editEncyclopediaModal .kt-modal-content {
        top: 15% !important;
    }
}

@media (max-width: 639px) {
    #editEncyclopediaModal .kt-modal-content {
        top: 7% !important;
    }
}
</style>
