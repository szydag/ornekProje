<!-- Kurs Ekle/Düzenle Modal -->
<div class="kt-modal" data-kt-modal="true" id="addCourseModal">
    <div class="kt-modal-content max-w-[95vw] sm:max-w-[800px] top-[5%] sm:top-[15%] mx-2 sm:mx-auto">
        <div class="kt-modal-header py-3 px-3 sm:py-4 sm:px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-plus text-primary text-xl" id="modalIcon"></i>
                <h3 class="text-lg font-semibold text-mono" id="modalTitle">Kurs Ekle</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-3 sm:p-5">
            <!-- Alert Container -->
            <div class="space-y-3 mb-4" id="alertContainer" style="display: none;">
                <!-- Alerts will be dynamically inserted here -->
            </div>

            <form id="addCourseForm" class="space-y-4">
                <input type="hidden" name="course_id" id="course_id" value="" />

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Kurs Adı*
                    </label>
                    <div class="flex-1">
                        <input type="text" name="course_name" class="kt-input"
                            placeholder="Kurs adını girin" id="course_name-input" />
                        <div class="text-red-500 text-sm italic mt-1" id="course_name-error"
                            style="display: none;"></div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Kurs Açıklama*
                    </label>
                    <div class="flex-1">
                        <textarea name="course_description" class="kt-textarea"
                            placeholder="Kurs açıklamasını girin" rows="4"
                            id="course_description-input"></textarea>
                        <div class="text-red-500 text-sm italic mt-1" id="course_description-error"
                            style="display: none;"></div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Başlangıç Tarihi*
                    </label>
                    <div class="flex-1">
                        <input type="date" name="start_date" class="kt-input" id="start_date-input" />
                        <div class="text-red-500 text-sm italic mt-1" id="start_date-error" style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Bitiş Tarihi
                    </label>
                    <div class="flex-1">
                        <input type="date" name="end_date" class="kt-input" id="end_date_input" />
                        <div class="text-red-500 text-sm italic mt-1" id="end_date-error" style="display: none;"></div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Süresiz
                    </label>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="checkbox" name="unlimited" id="unlimited_checkbox" class="kt-checkbox"
                            onchange="toggleEndDate()">
                        <label for="unlimited_checkbox" class="text-sm text-foreground">Süresiz olarak işaretle</label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-baseline gap-2.5">
                    <label class="kt-form-label w-full sm:max-w-56">
                        Yönetici Ata*
                    </label>
                    <div class="flex-1">
                        <select name="manager" class="kt-select" data-kt-select="true"
                            data-kt-select-enable-search="true" data-kt-select-search-placeholder="Yönetici ara..."
                            data-kt-select-placeholder="Yönetici seçin..." data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }' id="manager-input">
                            <option value="">Yönetici seçin</option>
                        </select>
                        <div class="text-red-500 text-sm italic mt-1" id="manager-error" style="display: none;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-3 px-3 sm:py-4 sm:px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-primary" onclick="saveCourse()" id="saveButton">
                Kaydet
            </button>
        </div>
    </div>
</div>

<script>
    function toggleEndDate() {
        const checkbox = document.getElementById('unlimited_checkbox');
        const endDateInput = document.getElementById('end_date_input');

        if (checkbox && endDateInput) {
            if (checkbox.checked) {
                endDateInput.disabled = true;
                endDateInput.value = '';
                clearCourseFieldError('end_date');
            } else {
                endDateInput.disabled = false;
            }
        }
    }

    function showAlert(type, message, title = null) {
        const alertContainer = document.getElementById('alertContainer');
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

    function clearAlerts() {
        const alertContainer = document.getElementById('alertContainer');
        if (alertContainer) {
            alertContainer.innerHTML = '';
            alertContainer.style.display = 'none';
        }
    }

    function closeModal() {
        const modal = document.getElementById('addCourseModal');
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
            const form = document.getElementById('addCourseForm');
            if (form) {
                form.reset();
            }

            // Alert'leri ve hata mesajlarını temizle
            clearAlerts();
            clearAllCourseErrors();
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

    // Modal'ı aç (ekleme veya düzenleme için)
    function openCourseModal(courseId = null) {

        // Modal elementlerini bul
        const modal = document.getElementById('addCourseModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalIcon = document.getElementById('modalIcon');
        const saveButton = document.getElementById('saveButton');
        const form = document.getElementById('addCourseForm');

        // Form ve hataları temizle
        if (form) {
            form.reset();
        }
        clearAlerts();
        clearAllCourseErrors();

        // Modal başlığını ve butonunu güncelle
        if (courseId) {

            // Başlık güncellemesi
            if (modalTitle) {
                modalTitle.textContent = 'Kurs Düzenle';
            }

            // İkon güncellemesi
            if (modalIcon) {
                modalIcon.className = 'ki-filled ki-pencil text-primary text-xl';
            }

            // Buton metni güncellemesi
            if (saveButton) {
                saveButton.textContent = 'Güncelle';
            }

            // Kurs detaylarını yükle
            loadCourseDetails(courseId);
        } else {

            // Başlık güncellemesi
            if (modalTitle) {
                modalTitle.textContent = 'Kurs Ekle';
            }

            // İkon güncellemesi
            if (modalIcon) {
                modalIcon.className = 'ki-filled ki-plus text-primary text-xl';
            }

            // Buton metni güncellemesi
            if (saveButton) {
                saveButton.textContent = 'Kaydet';
            }

            document.getElementById('course_id').value = '';
        }

        // Yöneticileri yükle
        loadManagers();

        // Modal açıldıktan sonra tekrar kontrol et
        setTimeout(() => {
            if (courseId) {
                const currentTitle = document.getElementById('modalTitle').textContent;
                if (currentTitle !== 'Kurs Düzenle') {
                    document.getElementById('modalTitle').textContent = 'Kurs Düzenle';
                    document.getElementById('modalIcon').className = 'ki-filled ki-pencil text-primary text-xl';
                    document.getElementById('saveButton').textContent = 'Güncelle';
                }
            }
        }, 500);
    }

    // Kurs detaylarını yükle (düzenleme için)
    function loadCourseDetails(courseId) {

        // Eğer ID yoksa hata göster
        if (!courseId) {
            showAlert('destructive', 'Kurs ID\'si bulunamadı.', 'Hata');
            return;
        }

        fetch(`/admin/api/courses/${courseId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error(`HTTP ${response.status}: Kurs bilgileri yüklenemedi`);
                }
            })
            .then(data => {

                if (data.success && data.data) {
                    const course = data.data;

                    // Form alanlarını doldur
                    document.getElementById('course_id').value = course.id;
                    document.getElementById('course_name-input').value = course.title || '';
                    document.getElementById('course_description-input').value = course.description || '';
                    document.getElementById('start_date-input').value = course.start_date || '';
                    document.getElementById('end_date_input').value = course.end_date || '';

                    // Unlimited checkbox kontrolü
                    const unlimitedCheckbox = document.getElementById('unlimited_checkbox');
                    const endDateInput = document.getElementById('end_date_input');

                    if (!course.end_date) {
                        unlimitedCheckbox.checked = true;
                        endDateInput.disabled = true;
                        endDateInput.value = '';
                    } else {
                        unlimitedCheckbox.checked = false;
                        endDateInput.disabled = false;
                    }

                    // Yönetici seçimini ayarla (yöneticiler yüklendikten sonra)
                    setTimeout(() => {
                        const managerSelect = document.getElementById('manager-input');
                        if (managerSelect && course.manager_id) {
                            managerSelect.value = course.manager_id;
                        }
                    }, 500);


                } else {
                    console.error('API response format hatası:', data);
                    showAlert('destructive', 'Kurs bilgileri yüklenemedi.', 'Hata');
                }
            })
            .catch(error => {
                console.error('loadCourseDetails hatası:', error);
                showAlert('destructive', `Kurs bilgileri yüklenirken bir hata oluştu: ${error.message}`, 'Hata');
            });
    }

    function saveCourse() {
        const form = document.getElementById('addCourseForm');
        if (!form) return;

        // Clear previous alerts and errors
        clearAlerts();
        clearAllCourseErrors();

        // Form verilerini al
        const courseId = document.getElementById('course_id').value;
        const courseName = document.getElementById('course_name-input').value.trim();
        const courseDescription = document.getElementById('course_description-input').value.trim();
        const startDate = document.getElementById('start_date-input').value;
        const endDate = document.getElementById('end_date_input').value;
        const unlimited = document.getElementById('unlimited_checkbox').checked;
        const selectedManager = document.getElementById('manager-input').value;

        let hasErrors = false;

        // Kurs adı validasyonu
        if (!courseName) {
            showCourseFieldError('course_name', 'Kurs adı zorunludur.');
            hasErrors = true;
        } else if (courseName.length < 3) {
            showCourseFieldError('course_name', 'Kurs adı en az 3 karakter olmalıdır.');
            hasErrors = true;
        }

        // Kurs açıklama validasyonu
        if (!courseDescription) {
            showCourseFieldError('course_description', 'Kurs açıklaması zorunludur.');
            hasErrors = true;
        } else if (courseDescription.length < 10) {
            showCourseFieldError('course_description', 'Kurs açıklaması en az 10 karakter olmalıdır.');
            hasErrors = true;
        }

        // Başlangıç tarihi validasyonu
        if (!startDate) {
            showCourseFieldError('start_date', 'Başlangıç tarihi zorunludur.');
            hasErrors = true;
        }

        // Bitiş tarihi validasyonu (unlimited değilse)
        if (!unlimited && !endDate) {
            showCourseFieldError('end_date', 'Bitiş tarihi zorunludur veya "Süresiz" seçeneğini işaretleyin.');
            hasErrors = true;
        }

        // Tarih mantık kontrolü
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            showCourseFieldError('end_date', 'Bitiş tarihi başlangıç tarihinden önce olamaz.');
            hasErrors = true;
        }

        // Yönetici seçimi validasyonu
        if (!selectedManager) {
            showCourseFieldError('manager', 'Lütfen bir yönetici seçin.');
            hasErrors = true;
        }

        // Validasyon hataları varsa formu gönderme
        if (hasErrors) {
            showAlert('destructive', 'Lütfen formu kontrol ederek gerekli alanları doldurunuz.', 'Hata');
            return;
        }

        const jsonData = {
            title: courseName,
            description: courseDescription,
            start_date: startDate,
            end_date: endDate || null,
            unlimited: unlimited,
            manager_ids: [parseInt(selectedManager)]
        };


        // API endpoint ve method belirleme (ekleme veya güncelleme)
        const isUpdate = courseId && courseId !== '';
        const apiUrl = isUpdate ? `/admin/api/courses/${courseId}` : '/admin/api/courses';
        const method = isUpdate ? 'PUT' : 'POST';


        // AJAX isteği gönder
        fetch(apiUrl, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(jsonData)
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    // Backend'den gelen hata mesajını almaya çalış
                    return response.text().then(text => {
                        try {
                            const errorData = JSON.parse(text);
                            throw new Error(JSON.stringify(errorData));
                        } catch (e) {
                            throw new Error(text || 'HTTP ' + response.status);
                        }
                    });
                }
            })
            .then(data => {

                // Modal'ı kapat
                closeModal();

                // Başarı mesajı göster
                const successMessage = isUpdate ? 'Kurs başarıyla güncellendi!' : 'Kurs başarıyla eklendi!';
                showPageAlert('success', successMessage, 'İşlem Başarılı');

                // Kurs listesini yenile
                if (typeof refreshCourseList === 'function') {
                    refreshCourseList();
                } else {
                    // Fallback: sayfayı yenile
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Hata:', error);

                // Hata mesajını parse et
                let errorMessage = 'Bir hata oluştu. Lütfen tekrar deneyin.';

                if (error.message) {
                    try {
                        const errorData = JSON.parse(error.message);

                        // Eğer errors objesi varsa (field-specific hatalar)
                        if (errorData.errors) {
                            Object.keys(errorData.errors).forEach(field => {
                                showAlert('destructive', errorData.errors[field], 'Hata');
                            });
                        } else {
                            // Genel hata mesajı
                            errorMessage = errorData.message || errorMessage;
                            showAlert('destructive', errorMessage, 'Hata');
                        }
                    } catch (e) {
                        // JSON değilse, direkt mesajı kullan
                        errorMessage = error.message;
                        showAlert('destructive', errorMessage, 'Hata');
                    }
                } else {
                    showAlert('destructive', errorMessage, 'Hata');
                }
            });
    }

    // Modal açıldığında kullanıcıları çek
    function loadManagers() {
        fetch('/admin/api/managers', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    const select = document.querySelector('select[name="manager"]');
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
                                (manager.name || manager.mail);
                            option.textContent = displayName;
                            select.appendChild(option);
                        });
                    }
                } else {
                    console.warn('Yönetici verisi bulunamadı:', data);
                    const select = document.querySelector('select[name="manager"]');
                    if (select) {
                        select.innerHTML = '<option value="">Yönetici bulunamadı</option>';
                    }
                }
            })
            .catch(error => {
                console.error('Yöneticiler yüklenirken hata:', error);
                const select = document.querySelector('select[name="manager"]');
                if (select) {
                    select.innerHTML = '<option value="">Yöneticiler yüklenemedi</option>';
                }
                showAlert('destructive', 'Yöneticiler yüklenirken bir hata oluştu.', 'Hata');
            });
    }

    // Validasyon helper fonksiyonları
    function showCourseFieldError(fieldName, message) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.color = '#ef4444';
            errorElement.style.fontStyle = 'italic';
            errorElement.style.fontSize = '0.875rem';
            errorElement.style.marginTop = '0.25rem';
        }

        // Input'a kırmızı border ekle
        const inputElement = document.getElementById(fieldName + '-input');
        if (inputElement) {
            inputElement.classList.add('border-red-500', 'focus:border-red-500');
            inputElement.classList.remove('border-gray-300', 'focus:border-blue-500');
        }
    }

    function clearCourseFieldError(fieldName) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }

        // Input'tan kırmızı border'ı kaldır
        const inputElement = document.getElementById(fieldName + '-input');
        if (inputElement) {
            inputElement.classList.remove('border-red-500', 'focus:border-red-500');
            inputElement.classList.add('border-gray-300', 'focus:border-blue-500');
        }
    }

    function clearAllCourseErrors() {
        clearCourseFieldError('course_name');
        clearCourseFieldError('course_description');
        clearCourseFieldError('start_date');
        clearCourseFieldError('end_date');
        clearCourseFieldError('manager');
    }

    // Real-time validation için event listener'ları ekle
    function setupCourseValidation() {
        const nameInput = document.getElementById('course_name-input');
        const descriptionInput = document.getElementById('course_description-input');
        const startDateInput = document.getElementById('start_date-input');
        const endDateInput = document.getElementById('end_date_input');
        const managerInput = document.getElementById('manager-input');
        const unlimitedCheckbox = document.getElementById('unlimited_checkbox');

        if (nameInput) {
            nameInput.addEventListener('input', function () {
                clearCourseFieldError('course_name');
            });
        }

        if (descriptionInput) {
            descriptionInput.addEventListener('input', function () {
                clearCourseFieldError('course_description');
            });
        }

        if (startDateInput) {
            startDateInput.addEventListener('change', function () {
                clearCourseFieldError('start_date');
                clearCourseFieldError('end_date');
            });
        }

        if (endDateInput) {
            endDateInput.addEventListener('change', function () {
                clearCourseFieldError('end_date');
            });
        }

        if (managerInput) {
            managerInput.addEventListener('change', function () {
                clearCourseFieldError('manager');
            });
        }

        if (unlimitedCheckbox) {
            unlimitedCheckbox.addEventListener('change', function () {
                clearCourseFieldError('end_date');
            });
        }
    }

    // DOM yüklendiğinde event listener'ları ekle
    document.addEventListener('DOMContentLoaded', function () {
        // Validasyon sistemini başlat
        setupCourseValidation();
        // Modal açıldığında alert'leri temizle ve kullanıcıları yükle
        const modal = document.getElementById('addCourseModal');
        if (modal) {
            // Modal açıldığında alert'leri temizle ve kullanıcıları yükle
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        const target = mutation.target;
                        if (target.style.display === 'block' || target.style.display === 'flex' || target.classList.contains('kt-modal-open')) {
                            clearAlerts();
                            loadManagers(); // Yöneticileri yükle
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
                    loadManagers();
                }
            };

            // Modal açıldığında kontrol et
            const modalObserver = new MutationObserver(checkModalVisibility);
            modalObserver.observe(modal, {
                attributes: true,
                attributeFilter: ['style', 'class']
            });
        }

        // Modal dışına tıklandığında kapatma
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('addCourseModal');
            if (modal && e.target === modal) {
                closeModal();
            }
        });

        // ESC tuşu ile modal kapatma
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('addCourseModal');
                if (modal && modal.classList.contains('kt-modal-open')) {
                    closeModal();
                }
            }
        });

        // Modal açma butonlarına event listener ekle
        document.addEventListener('click', function (e) {

            // Tüm data-kt-modal-toggle="#addCourseModal" elementlerini bul
            let target = null;

            if (e.target.hasAttribute && e.target.getAttribute('data-kt-modal-toggle') === '#addCourseModal') {
                target = e.target;
            } else if (e.target.closest && e.target.closest('[data-kt-modal-toggle="#addCourseModal"]')) {
                target = e.target.closest('[data-kt-modal-toggle="#addCourseModal"]');
            }

            if (target) {
                // data-course-id attribute'ını kontrol et
                const courseId = target.getAttribute('data-course-id');

                // Modal açılmadan önce modalı hazırla
                setTimeout(() => {
                    if (courseId) {
                        openCourseModal(courseId);
                    } else {
                        openCourseModal();
                    }
                }, 200); // Biraz daha uzun bekleme
            }
        });

        // Modal açıldığında da kontrol et
        const modalElement = document.getElementById('addCourseModal');
        if (modalElement) {
            modalElement.addEventListener('shown.bs.modal', function () {

                // Eğer URL'de veya başka bir yerde düzenleme modu bilgisi varsa kontrol et
                const urlParams = new URLSearchParams(window.location.search);
                const editId = urlParams.get('edit');

                if (editId) {
                    openCourseModal(editId);
                }
            });
        }
    });
</script>