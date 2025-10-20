<div class="kt-modal" data-kt-modal="true" id="add_author_modal">
    <div class="kt-modal-content max-w-[800px] top-[17px] max-h-[700px]">
        <div class="kt-modal-header py-4 px-5">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-profile-user text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-mono" id="author_modal_title">Katkıda Bulunan Ekle</h3>
            </div>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0"
                data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-5 max-h-[70vh] overflow-y-auto">
            <!-- Alert Container -->
            <div class="space-y-3 mb-4 hidden" id="authorAlertContainer"></div>

            <form id="addAuthorForm" class="space-y-4">
                <!-- Sıra ve ORCID -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Sıra <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="author_order" type="number" placeholder="Katkıda Bulunan sırası" required />
                        <div class="text-sm italic font-bold mt-1" id="author_order-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            ORCID <span class="text-danger">*</span>
                        </label>
                        <div class="flex flex-col gap-1">
                            <input class="kt-input" name="orcid" type="text" placeholder="0000-0000-0000-0000" maxlength="19" required data-responsible-field="orcid" />
                            <div class="text-sm italic font-bold mt-1" id="orcid-error" style="display: none; color: #dc2626;"></div>
                        </div>
                    </div>
                </div>

                <!-- Ad ve Soyad -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Adı <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="author_name" type="text" placeholder="Katkıda Bulunan adı" required />
                        <div class="text-sm italic font-bold mt-1" id="author_name-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Soyadı <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="author_surname" type="text" placeholder="Katkıda Bulunan soyadı" required />
                        <div class="text-sm italic font-bold mt-1" id="author_surname-error" style="display: none; color: #dc2626;"></div>
                    </div>
                </div>

                <!-- E-Posta ve Telefon -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            E-Posta <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="author_email_modal" type="email" placeholder="yazar@example.com" required />
                        <div class="text-sm italic font-bold mt-1" id="author_email_modal-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Telefon
                        </label>
                        <input class="kt-input" name="author_phone" type="tel" placeholder="+90 555 123 45 67" data-responsible-field="phone" />
                    </div>
                </div>

                <!-- Ülke ve Şehir -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Ülke <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" data-kt-select-enable-search="true" data-kt-select-search-placeholder="Ülke ara..." data-kt-select-placeholder="Ülke seçiniz..." name="author_country" id="author_country" required data-responsible-field="country" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <?php if (isset($countries) && is_array($countries)): ?>
                                <?php foreach ($countries as $code => $country): ?>
                                    <option value="<?= esc($code) ?>"><?= esc($country['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="text-sm italic font-bold mt-1" id="author_country-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Şehir <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="author_city" type="text" placeholder="Şehir adını girin" required data-responsible-field="city" />
                        <div class="text-sm italic font-bold mt-1" id="author_city-error" style="display: none; color: #dc2626;"></div>
                    </div>
                </div>

                <!-- Adres -->
                <div class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Adres
                    </label>
                    <textarea class="kt-textarea w-full" name="author_address" rows="3" placeholder="Katkıda Bulunan adresi"></textarea>
                </div>

                <!-- Kurum ve Ünvan -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2" id="institution_select_wrapper">
                        <label class="kt-form-label">
                            Kurum <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" name="author_institution" id="author_institution_select" data-kt-select-enable-search="true" data-kt-select-search-placeholder="Kurum ara..." data-kt-select-placeholder="Kurum seçin..." required data-responsible-field="institution" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                            <?php if (isset($institutions) && is_array($institutions)): ?>
                                <?php foreach ($institutions as $id => $name): ?>
                                    <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="text-sm italic font-bold mt-1" id="author_institution-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Ünvan
                        </label>
                        <select class="kt-select" data-kt-select="true" data-kt-select-enable-search="true" data-kt-select-search-placeholder="Ünvan ara..." data-kt-select-placeholder="Ünvan seçin..." name="author_title" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                            <?php if (isset($titles) && is_array($titles)): ?>
                                <?php foreach ($titles as $id => $name): ?>
                                    <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Kurum Ekleme Checkbox -->
                <div id="add_institution_section" class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Kurum Ekleme
                    </label>
                    <div class="flex items-center gap-2">
                        <input class="kt-checkbox" name="add_new_institution" type="checkbox" id="add_institution_checkbox" onchange="toggleInstitutionFields()" />
                        <label for="add_institution_checkbox" class="text-sm text-foreground">Kurum Eklemek İstiyorum</label>
                    </div>
                </div>

                <!-- Yeni Kurum Alanları (Checkbox işaretlendiğinde görünür) -->
                <div id="new_institution_fields" class="hidden space-y-4 p-4 border border-border rounded-lg bg-accent/5">
                    <!-- Kurum Adı -->
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label">
                            Kurum Adı <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="institution_name" type="text" placeholder="Kurum adını girin" />
                        <div class="text-sm italic font-bold mt-1" id="institution_name-error" style="display: none; color: #dc2626;"></div>
                    </div>

                    <!-- Kurum Dili ve Kurum Tipi -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="kt-form-label">
                                Kurum Dili <span class="text-danger">*</span>
                            </label>
                            <select class="kt-select" data-kt-select="true" data-kt-select-placeholder="Kurum dili seçiniz..." name="institution_language" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                                <option value="">Seçiniz...</option>
                                <option value="tr">Türkçe</option>
                                <option value="en">İngilizce</option>
                                <option value="de">Almanca</option>
                                <option value="fr">Fransızca</option>
                            </select>
                            <div class="text-sm italic font-bold mt-1" id="institution_language-error" style="display: none; color: #dc2626;"></div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="kt-form-label">
                                Kurum Tipi <span class="text-danger">*</span>
                            </label>
                            <select class="kt-select" data-kt-select="true" data-kt-select-enable-search="true" data-kt-select-search-placeholder="Kurum tipi ara..." data-kt-select-placeholder="Kurum tipi seçiniz..." name="institution_type" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                                <option value="">Seçiniz...</option>
                                <?php if (isset($institutionTypes) && is_array($institutionTypes)): ?>
                                    <?php foreach ($institutionTypes as $id => $name): ?>
                                        <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="text-sm italic font-bold mt-1" id="institution_type-error" style="display: none; color: #dc2626;"></div>
                        </div>
                    </div>

                    <!-- Kurum Ülke ve Kurum Şehir -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="kt-form-label">
                                Kurum Ülke <span class="text-danger">*</span>
                            </label>
                            <select class="kt-select" data-kt-select="true" data-kt-select-enable-search="true" data-kt-select-search-placeholder="Kurum ülkesi ara..." data-kt-select-placeholder="Kurum ülkesi seçiniz..." name="institution_country" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }'>
                                <?php if (isset($countries) && is_array($countries)): ?>
                                    <?php foreach ($countries as $code => $country): ?>
                                        <option value="<?= esc($code) ?>"><?= esc($country['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="text-sm italic font-bold mt-1" id="institution_country-error" style="display: none; color: #dc2626;"></div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="kt-form-label">
                                Kurum Şehir
                            </label>
                            <input class="kt-input" name="institution_city" type="text" placeholder="Kurum şehir adını girin" />
                        </div>
                    </div>
                </div>

                <!-- Kurum Yok Checkbox -->
                <div id="no_institution_section" class="flex flex-col gap-2">
                    <label class="kt-form-label">
                        Kurum Durumu
                    </label>
                    <div class="flex items-center gap-2">
                        <input class="kt-checkbox" name="no_institution" type="checkbox" id="no_institution_checkbox" onchange="toggleNoInstitution()" />
                        <label for="no_institution_checkbox" class="text-sm text-foreground">Kurum Yok</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="kt-modal-footer py-4 px-5">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">
                İptal
            </button>
            <button class="kt-btn kt-btn-primary" type="button" data-author-modal-submit onclick="saveAuthor()">
                Kaydet
            </button>
        </div>
    </div>
</div>

<script>
    function showAuthorAlert(type, message, title = null) {
        const alertContainer = document.getElementById('authorAlertContainer');
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
        alertContainer.classList.remove('hidden');
        alertContainer.style.display = 'block';

        // Auto-hide after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.remove();
                if (alertContainer.children.length === 0) {
                    alertContainer.style.display = 'none';
                    alertContainer.classList.add('hidden');
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

    function clearAuthorAlerts() {
        const alertContainer = document.getElementById('authorAlertContainer');
        if (alertContainer) {
            alertContainer.innerHTML = '';
            alertContainer.style.display = 'none';
            alertContainer.classList.add('hidden');
        }
    }

    function closeAuthorModal() {
        const modal = document.getElementById('add_author_modal');
        if (!modal) return;

        clearAuthorAlerts();
        if (typeof window.clearResponsibleModalHighlights === 'function') {
            window.clearResponsibleModalHighlights();
        }

        if (typeof window.KTModal !== 'undefined') {
            const instance = window.KTModal.getInstance(modal) || new window.KTModal(modal);
            instance.hide();
        } else {
            modal.style.display = 'none';
            modal.classList.remove('kt-modal-open');
            document.body.classList.remove('kt-modal-open');
            document.body.style.overflow = '';
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

    function toggleInstitutionFields() {
        const checkbox = document.getElementById('add_institution_checkbox');
        const fieldsContainer = document.getElementById('new_institution_fields');
        const institutionSelect = document.getElementById('author_institution_select');
        const institutionWrapper = document.getElementById('institution_select_wrapper');
        const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');

        if (checkbox && fieldsContainer && institutionSelect) {
            if (checkbox.checked) {
                // Kurum ekleme alanlarını göster
                fieldsContainer.classList.remove('hidden');
                // Kurum select'ini disable et
                institutionSelect.disabled = true;
                // KT-Select için ek disable işlemi
                if (typeof KTSearch !== 'undefined' && KTSearch.getInstance(institutionSelect)) {
                    KTSearch.getInstance(institutionSelect).disable();
                }
                // Ek disable işlemleri
                institutionSelect.style.pointerEvents = 'none';
                institutionSelect.style.opacity = '0.5';
                const ktSelectWrapper = institutionSelect.parentElement.querySelector('.kt-select');
                if (ktSelectWrapper) {
                    ktSelectWrapper.style.pointerEvents = 'none';
                    ktSelectWrapper.style.opacity = '0.5';
                }
                if (institutionWrapper) {
                    institutionWrapper.classList.add('hidden');
                }
                // Kurum yok checkbox'ını temizle
                if (noInstitutionCheckbox) {
                    noInstitutionCheckbox.checked = false;
                }
            } else {
                // Kurum ekleme alanlarını gizle
                fieldsContainer.classList.add('hidden');
                // Kurum select'ini enable et
                institutionSelect.disabled = false;
                // KT-Select için ek enable işlemi
                if (typeof KTSearch !== 'undefined' && KTSearch.getInstance(institutionSelect)) {
                    KTSearch.getInstance(institutionSelect).enable();
                }
                // Ek enable işlemleri
                institutionSelect.style.pointerEvents = 'auto';
                institutionSelect.style.opacity = '1';
                const ktSelectWrapper = institutionSelect.parentElement.querySelector('.kt-select');
                if (ktSelectWrapper) {
                    ktSelectWrapper.style.pointerEvents = 'auto';
                    ktSelectWrapper.style.opacity = '1';
                }
                if (institutionWrapper && !(noInstitutionCheckbox && noInstitutionCheckbox.checked)) {
                    institutionWrapper.classList.remove('hidden');
                }
            }
        }
    }

    function toggleNoInstitution() {
        const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');
        const addInstitutionCheckbox = document.getElementById('add_institution_checkbox');
        const institutionSelect = document.getElementById('author_institution_select');
        const fieldsContainer = document.getElementById('new_institution_fields');
        const institutionWrapper = document.getElementById('institution_select_wrapper');

        if (noInstitutionCheckbox && institutionSelect) {
            if (noInstitutionCheckbox.checked) {
                if (addInstitutionCheckbox) {
                    addInstitutionCheckbox.checked = false;
                }
                // Kurum select'ini disable et
                institutionSelect.disabled = true;
                // KT-Select için ek disable işlemi
                if (typeof KTSearch !== 'undefined' && KTSearch.getInstance(institutionSelect)) {
                    KTSearch.getInstance(institutionSelect).disable();
                }
                // Ek disable işlemleri
                institutionSelect.style.pointerEvents = 'none';
                institutionSelect.style.opacity = '0.5';
                const ktSelectWrapper = institutionSelect.parentElement.querySelector('.kt-select');
                if (ktSelectWrapper) {
                    ktSelectWrapper.style.pointerEvents = 'none';
                    ktSelectWrapper.style.opacity = '0.5';
                }
                if (institutionWrapper) {
                    institutionWrapper.classList.add('hidden');
                }
                // Kurum ekleme alanlarını gizle
                if (fieldsContainer) {
                    fieldsContainer.classList.add('hidden');
                }
            } else {
                // Kurum select'ini enable et
                institutionSelect.disabled = false;
                // KT-Select için ek enable işlemi
                if (typeof KTSearch !== 'undefined' && KTSearch.getInstance(institutionSelect)) {
                    KTSearch.getInstance(institutionSelect).enable();
                }
                // Ek enable işlemleri
                institutionSelect.style.pointerEvents = 'auto';
                institutionSelect.style.opacity = '1';
                const ktSelectWrapper = institutionSelect.parentElement.querySelector('.kt-select');
                if (ktSelectWrapper) {
                    ktSelectWrapper.style.pointerEvents = 'auto';
                    ktSelectWrapper.style.opacity = '1';
                }
                if (institutionWrapper && !(addInstitutionCheckbox && addInstitutionCheckbox.checked)) {
                    institutionWrapper.classList.remove('hidden');
                }
            }
        }
    }

    function saveAuthor() {
        const form = document.getElementById('addAuthorForm');
        if (!form) return;

        // Clear previous alerts
        clearAuthorAlerts();

        // Validasyon yap
        if (!validateAuthorForm()) {
            return; // Validasyon başarısızsa dur
        }

        if (typeof window.addContentStep2SaveAuthor === 'function') {
            window.addContentStep2SaveAuthor();
            return;
        }

        const formData = new FormData(form);

        // Modal'ı hemen kapat
        closeAuthorModal();

        // Sayfanın sağ üst köşesinde başarı mesajı göster
        showPageAlert('success', 'Katkıda Bulunan başarıyla eklendi!', 'İşlem Başarılı');
    }

    function validateAuthorForm() {
        const form = document.getElementById('addAuthorForm');
        if (!form) return false;

        let isValid = true;

        // Hata mesajlarını temizle
        clearAllAuthorErrors();

        // Sıra kontrolü
        const order = form.querySelector('input[name="author_order"]').value.trim();
        if (!order || isNaN(order) || parseInt(order) < 1) {
            showAuthorFieldError('author_order', 'Geçerli bir sıra numarası giriniz.');
            isValid = false;
        }

        // ORCID kontrolü
        const orcid = form.querySelector('input[name="orcid"]').value.trim();
        if (!orcid) {
            showAuthorFieldError('orcid', 'ORCID alanı zorunludur.');
            isValid = false;
        } else if (!/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/i.test(orcid)) {
            showAuthorFieldError('orcid', 'ORCID formatı geçersiz. Format: 0000-0000-0000-0000');
            isValid = false;
        }

        // Ad kontrolü
        const name = form.querySelector('input[name="author_name"]').value.trim();
        if (!name) {
            showAuthorFieldError('author_name', 'Ad alanı zorunludur.');
            isValid = false;
        }

        // Soyad kontrolü
        const surname = form.querySelector('input[name="author_surname"]').value.trim();
        if (!surname) {
            showAuthorFieldError('author_surname', 'Soyad alanı zorunludur.');
            isValid = false;
        }

        // Email kontrolü
        const email = form.querySelector('input[name="author_email_modal"]').value.trim();
        if (!email) {
            showAuthorFieldError('author_email_modal', 'E-posta alanı zorunludur.');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showAuthorFieldError('author_email_modal', 'Geçerli bir e-posta adresi giriniz.');
            isValid = false;
        }

        // Ülke kontrolü
        const country = form.querySelector('select[name="author_country"]').value.trim();
        if (!country) {
            showAuthorFieldError('author_country', 'Ülke seçimi zorunludur.');
            isValid = false;
        }

        // Şehir kontrolü
        const city = form.querySelector('input[name="author_city"]').value.trim();
        if (!city) {
            showAuthorFieldError('author_city', 'Şehir alanı zorunludur.');
            isValid = false;
        }

        // Kurum ekleme checkbox'ı durumunu kontrol et
        const addInstitutionCheckbox = document.getElementById('add_institution_checkbox');
        const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');

        // Kurum kontrolü (sadece kurum ekleme ve kurum yok checkbox'ları işaretli değilse)
        if (!addInstitutionCheckbox.checked && !noInstitutionCheckbox.checked) {
            const institution = form.querySelector('select[name="author_institution"]').value.trim();
            if (!institution) {
                showAuthorFieldError('author_institution', 'Kurum seçimi zorunludur.');
                isValid = false;
            }
        }

        // Kurum ekleme alanları kontrolü (eğer kurum ekleme checkbox'ı işaretliyse)
        if (addInstitutionCheckbox && addInstitutionCheckbox.checked) {
            // Kurum adı kontrolü
            const institutionName = form.querySelector('input[name="institution_name"]').value.trim();
            if (!institutionName) {
                showAuthorFieldError('institution_name', 'Kurum adı zorunludur.');
                isValid = false;
            }

            // Kurum dili kontrolü
            const institutionLanguage = form.querySelector('select[name="institution_language"]').value.trim();
            if (!institutionLanguage) {
                showAuthorFieldError('institution_language', 'Kurum dili seçimi zorunludur.');
                isValid = false;
            }

            // Kurum tipi kontrolü
            const institutionType = form.querySelector('select[name="institution_type"]').value.trim();
            if (!institutionType) {
                showAuthorFieldError('institution_type', 'Kurum tipi seçimi zorunludur.');
                isValid = false;
            }

            // Kurum ülke kontrolü
            const institutionCountry = form.querySelector('select[name="institution_country"]').value.trim();
            if (!institutionCountry) {
                showAuthorFieldError('institution_country', 'Kurum ülke seçimi zorunludur.');
                isValid = false;
            }
        }

        return isValid;
    }

    function showAuthorFieldError(fieldName, message) {
        const errorDiv = document.getElementById(fieldName + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
    }

    function clearAuthorFieldError(fieldName) {
        const errorDiv = document.getElementById(fieldName + '-error');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }

    function clearAllAuthorErrors() {
        const errorFields = ['author_order', 'orcid', 'author_name', 'author_surname', 'author_email_modal', 'author_country', 'author_city', 'author_institution', 'institution_name', 'institution_language', 'institution_type', 'institution_country'];
        errorFields.forEach(field => clearAuthorFieldError(field));
    }

    // DOM yüklendiğinde event listener'ları ekle
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('add_author_modal');
        if (modal) {
            modal.addEventListener('shown.kt.modal', () => {
                clearAuthorAlerts();
                clearAllAuthorErrors();
            });
            modal.addEventListener('hidden.kt.modal', () => {
                clearAuthorAlerts();
                clearAllAuthorErrors();
            });
            const closeBtn = modal.querySelector('[data-kt-modal-dismiss="true"]');
            if (closeBtn && typeof window.KTModal === 'undefined') {
                closeBtn.addEventListener('click', (event) => {
                    event.preventDefault();
                    closeAuthorModal();
                });
            }
        }

        // Form input'larına real-time validation ekle
        const form = document.getElementById('addAuthorForm');
        if (form) {
            const formInputs = form.querySelectorAll('input[name="author_order"], input[name="orcid"], input[name="author_name"], input[name="author_surname"], input[name="author_email_modal"], input[name="author_city"], select[name="author_country"], select[name="author_institution"], input[name="institution_name"], select[name="institution_language"], select[name="institution_type"], select[name="institution_country"]');
            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearAuthorFieldError(this.name);
                });
                input.addEventListener('change', function() {
                    clearAuthorFieldError(this.name);
                });
            });
        }

        toggleInstitutionFields();
        toggleNoInstitution();
    });
</script>
