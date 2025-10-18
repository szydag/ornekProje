<?php
    $institutions     = isset($institutions) && is_array($institutions) ? $institutions : [];
    $titles           = isset($titles) && is_array($titles) ? $titles : [];
    $countries        = isset($countries) && is_array($countries) ? $countries : [];
    $institutionTypes = isset($institutionTypes) && is_array($institutionTypes) ? $institutionTypes : [];

    $shouldLoadDictionaries = empty($institutions) || empty($titles) || empty($countries) || empty($institutionTypes);
    if ($shouldLoadDictionaries) {
        try {
            $wizardService = new \App\Services\LearningMaterials\ContentWizardService();
            if (empty($institutions)) {
                $institutions = $wizardService->getInstitutions();
            }
            if (empty($titles)) {
                $titles = $wizardService->getTitles();
            }
            if (empty($countries)) {
                $countries = $wizardService->getCountries();
            }
            if (empty($institutionTypes)) {
                $institutionTypes = $wizardService->getInstitutionTypes();
            }
        } catch (\Throwable $e) {
            log_message('error', 'Profile completion view dictionary load failed: {msg}', ['msg' => $e->getMessage()]);
            $institutions     = is_array($institutions) ? $institutions : [];
            $titles           = is_array($titles) ? $titles : [];
            $countries        = is_array($countries) ? $countries : [];
            $institutionTypes = is_array($institutionTypes) ? $institutionTypes : [];
        }
    }

    $userData = isset($user) && is_array($user) ? $user : [];

    $selectedInstitution = (string) old('institution', isset($userData['institution']) ? (string) $userData['institution'] : '');
    $selectedTitle = (string) old('title', isset($userData['title']) ? (string) $userData['title'] : '');

    $selectedCountry = (string) old('country', isset($userData['country']) ? (string) $userData['country'] : '');
    $selectedInstitutionType = (string) old('institution_type', '');
    $selectedInstitutionCountry = (string) old('institution_country', '');

    $noInstitutionOld = old('no_institution');
    $addInstitutionOld = old('add_institution');

    $noInstitutionChecked = $noInstitutionOld !== null
        ? ((int) $noInstitutionOld === 1)
        : (!empty($userData['no_institution']));

    $addInstitutionChecked = $addInstitutionOld !== null
        ? ((int) $addInstitutionOld === 1)
        : (!empty($userData['add_institution']));

    if ($addInstitutionChecked) {
        $noInstitutionChecked = false;
    } elseif ($noInstitutionChecked) {
        $addInstitutionChecked = false;
    }
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <base href="../../">
    <title>
        Metronic - Tailwind CSS
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Metronic - Tailwind CSS " name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content="assets/media/app/og-image.png" name="twitter:image" />
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Metronic - Tailwind CSS " property="og:title" />
    <meta content="" property="og:description" />
    <meta content="assets/media/app/og-image.png" property="og:image" />
    <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="assets/media/app/favicon.ico" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="assets/vendors/apexcharts/apexcharts.css" rel="stylesheet" />
    <link href="assets/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body class="h-full text-base text-foreground bg-background mt-7" style="margin-top: 4rem">
    <!-- Hero Section -->
    <div class="bg-center bg-cover bg-no-repeat hero-bg">
        <!-- Container -->
        <div class="kt-container-fixed px-4 lg:px-8 pb-10">
            <div class="flex flex-col items-center gap-2 lg:gap-3.5 py-8 lg:pt-12 lg:pb-16">
                <div class="text-center">
                    <h1 class="text-2xl font-semibold text-mono mb-2">Profil Bilgilerinizi Tamamlayın</h1>
                    <p class="text-secondary-foreground">Hesabınızı aktif hale getirmek için profil bilgilerinizi
                        tamamlamanız gerekmektedir.</p>
                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>

    <!-- Page Content -->
    <div class="kt-container-fixed px-4 lg:px-8 py-8 lg:py-12">

        <!-- Profile Update Form -->
        <form action="" method="post" id="profile_update_form">
            <?= csrf_field() ?>

            <!-- Error Display Area -->
            <div id="error-container" class="mb-4" style="display: none;">
                <!-- Errors will be displayed here -->
            </div>

            <div class="kt-card pb-2.5 w-full max-w-4xl mx-auto">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        Profil Bilgileri
                    </h3>
                </div>
                <div class="kt-card-content grid gap-5 w-full p-6">

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="kt-alert kt-alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="kt-alert kt-alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="kt-alert kt-alert-danger">
                            <ul class="list-disc list-inside">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Telefon -->
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Telefon Numarası*
                        </label>
                        <div class="grow">
                            <input class="kt-input" name="phone" placeholder="Örn: +90 555 123 45 67" type="tel"
                                value="<?= old('phone') ?>" />
                            <small class="text-xs text-muted-foreground mt-1">
                                Ülke kodu ile birlikte telefon numaranızı girin
                            </small>
                        </div>
                    </div>

                    <!-- Kurum -->
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Kurum*
                        </label>
                        <div class="grow">
                            <select class="kt-input" name="institution" id="institution_select" data-kt-select="true" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }' data-kt-select-enable-search="true" data-kt-select-placeholder="Kurum seçiniz"
                                data-kt-select-search-placeholder="Arama...">
                                <?php foreach (($institutions ?? []) as $value => $institution): ?>
                                    <option value="<?= esc($value) ?>" <?= $selectedInstitution === (string) $value ? 'selected' : '' ?>><?= esc($institution) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Kurum Seçenekleri -->
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Kurum Seçenekleri
                        </label>
                        <div class="flex flex-col gap-3 grow">
                            <label class="kt-label">
                                <input class="kt-checkbox kt-checkbox-sm" name="no_institution" type="checkbox"
                                    value="1" id="no_institution_checkbox"
                                    <?= $noInstitutionChecked ? 'checked' : '' ?>
                                    onclick="toggleNoInstitution()">
                                Kurum yok
                            </label>

                            <label class="kt-label">
                                <input class="kt-checkbox kt-checkbox-sm" name="add_institution" type="checkbox"
                                    value="1" id="add_institution_checkbox"
                                    <?= $addInstitutionChecked ? 'checked' : '' ?>
                                    onclick="toggleInstitutionFields()">
                                Kurum eklemek istiyorum
                            </label>

                            <div id="institution_fields" class="mt-3 space-y-3" style="<?= $addInstitutionChecked ? '' : 'display: none;' ?>">
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-gray-800 mb-3">Yeni Kurum Bilgileri</h4>

                                    <div class="space-y-3">
                                        <div class="flex items-baseline gap-2.5">
                                            <label class="kt-form-label w-40 text-left">Kurum Adı</label>
                                            <div class="flex-1">
                                                <div class="kt-form-field">
                                                    <input class="kt-input w-full" name="institution_name" placeholder="Kurum adını girin" type="text" value="<?= esc(old('institution_name', '')) ?>" />
                                                    <div class="text-sm italic mt-1" id="institution_name-error" style="display: none; color: #dc2626;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-baseline gap-2.5">
                                            <label class="kt-form-label w-40 text-left">Kurum Türü</label>
                                            <div class="flex-1">
                                                <div class="kt-form-field">
                                                    <select
                                                        class="kt-input w-full"
                                                        name="institution_type"
                                                        data-kt-select="true"
                                                        data-kt-select-placeholder="Kurum türü seçiniz"
                                                        id="institution_type_select"
                                                        data-kt-select-config='{
                                                        "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                                                    }'>
                                                        <option value="">Kurum türü seçiniz</option>
                                                        <?php foreach (($institutionTypes ?? []) as $typeId => $typeName): ?>
                                                            <option value="<?= esc($typeId) ?>" <?= (isset($selectedInstitutionType) && $selectedInstitutionType === (string) $typeId) ? 'selected' : '' ?>><?= esc($typeName) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="text-sm italic mt-1" id="institution_type-error" style="display: none; color: #dc2626;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-baseline gap-2.5">
                                            <label class="kt-form-label w-40 text-left">Kurum Ülkesi</label>
                                            <div class="flex-1">
                                                <div class="kt-form-field">
                                                    <select
                                                        class="kt-input w-full"
                                                        name="institution_country"
                                                        data-kt-select="true"
                                                        data-kt-select-placeholder="Ülke seçiniz"
                                                        data-kt-select-search-placeholder="Arama..."
                                                        id="institution_country_select"
                                                        data-kt-select-config='{
                                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                                                    
                                                }' data-kt-select-enable-search="true">
                                                    <?php foreach (($countries ?? []) as $code => $country): ?>
                                                        <?php $optionData = ['flag' => $country['flag'] ?? '']; ?>
                                                        <option value="<?= esc($code) ?>" data-kt-select-option='<?= esc(json_encode($optionData, JSON_UNESCAPED_UNICODE), 'attr') ?>' <?= $selectedInstitutionCountry === (string) $code ? 'selected' : '' ?>><?= esc($country['name']) ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    <div class="text-sm italic mt-1" id="institution_country-error" style="display: none; color: #dc2626;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-baseline gap-2.5">
                                            <label class="kt-form-label w-40 text-left">Kurum Şehri</label>
                                            <div class="flex-1">
                                                <div class="kt-form-field">
                                                    <input class="kt-input w-full" name="institution_city" placeholder="Şehir adını girin" type="text" value="<?= esc(old('institution_city', '')) ?>" />
                                                    <div class="text-sm italic mt-1" id="institution_city-error" style="display: none; color: #dc2626;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ünvan -->
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Ünvan*
                        </label>
                        <div class="grow">
                            <div class="kt-form-field">
                                <select class="kt-input" name="title" data-kt-select="true" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }' data-kt-select-placeholder="Ünvan seçiniz">
                                    <?php foreach (($titles ?? []) as $value => $title): ?>
                                        <option value="<?= esc($value) ?>" <?= (isset($selectedTitle) && $selectedTitle === (string) $value) ? 'selected' : '' ?>><?= esc($title) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-sm italic mt-1" id="title-error" style="display: none; color: #dc2626;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Ülke -->
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Ülke*
                        </label>
                        <div class="flex-1">
                            <div class="kt-form-field">
                                <select
                                    class="kt-input w-full"
                                    name="country"
                                    data-kt-select="true"
                                    data-kt-select-placeholder="Ülke seçiniz"
                                    data-kt-select-search-placeholder="Arama..."
                                    id="country_select"
                                    data-kt-select-config='{
                                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                                                    
                                                }' data-kt-select-enable-search="true">
                                    <?php foreach (($countries ?? []) as $code => $country): ?>
                                        <?php $optionData = ['flag' => $country['flag'] ?? '']; ?>
                                        <option value="<?= esc($code) ?>" data-kt-select-option='<?= esc(json_encode($optionData, JSON_UNESCAPED_UNICODE), 'attr') ?>' <?= $selectedCountry === (string) $code ? 'selected' : '' ?>><?= esc($country['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-sm italic mt-1" id="country-error" style="display: none; color: #dc2626;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button class="kt-btn kt-btn-primary" type="submit">
                            <i class="ki-filled ki-check text-sm mr-2"></i>
                            Profili Tamamla
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Form validation functions
        function showError(fieldName, message) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                // Remove existing error message from anywhere in the form
                const existingError = document.querySelector(`[name="${fieldName}"]`).parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                // Find the immediate parent container (flex-1 or grow)
                let container = field.parentNode;

                // Add new error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-xs mt-1 italic font-medium';
                errorDiv.style.color = '#dc2626';
                errorDiv.textContent = message;
                container.appendChild(errorDiv);
            }
        }

        function showFieldError(fieldName, message) {
            showError(fieldName, message);
        }

        function showGeneralError(message) {
            const errorContainer = document.getElementById('error-container');
            if (errorContainer) {
                errorContainer.innerHTML = `
                    <div class="kt-alert kt-alert-danger">
                        <div class="kt-alert-content">
                            <div class="kt-alert-title">Hata!</div>
                            <div class="kt-alert-text">${message}</div>
                        </div>
                    </div>
                `;
                errorContainer.style.display = 'block';
            }
        }

        function clearAllErrors() {
            // Clear field errors from all containers
            document.querySelectorAll('.error-message').forEach(error => error.remove());

            // Clear general error
            const errorContainer = document.getElementById('error-container');
            if (errorContainer) {
                errorContainer.style.display = 'none';
                errorContainer.innerHTML = '';
            }
        }

        function isValidPhone(phone) {
            // 0 ile başlayan veya 0 olmadan 10 haneli numara kabul eder
            const phoneRegex = /^0?\d{10}$/;
            return phoneRegex.test(phone.replace(/\s/g, ''));
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Kurum checkbox interaktif fonksiyonları
        function toggleInstitutionFields() {
            const checkbox = document.getElementById('add_institution_checkbox');
            const fieldsContainer = document.getElementById('institution_fields');
            const institutionContainer = document.getElementById('institution_select').parentElement.parentElement;
            const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');

            if (checkbox.checked) {
                // Kurum ekleme alanlarını göster
                fieldsContainer.style.display = 'block';
                // Kurum select'ini gizle
                institutionContainer.style.display = 'none';
                // Kurum yok checkbox'ını gizle
                noInstitutionCheckbox.parentElement.style.display = 'none';
                noInstitutionCheckbox.checked = false;
            } else {
                // Kurum ekleme alanlarını gizle
                fieldsContainer.style.display = 'none';
                // Kurum select'ini göster
                institutionContainer.style.display = 'flex';
                // Kurum yok checkbox'ını göster
                noInstitutionCheckbox.parentElement.style.display = 'block';
            }
        }

        function toggleNoInstitution() {
            const checkbox = document.getElementById('no_institution_checkbox');
            const fieldsContainer = document.getElementById('institution_fields');
            const institutionContainer = document.getElementById('institution_select').parentElement.parentElement;
            const addInstitutionCheckbox = document.getElementById('add_institution_checkbox');

            if (checkbox.checked) {
                // Kurum ekleme alanlarını gizle
                fieldsContainer.style.display = 'none';
                // Kurum select'ini gizle
                institutionContainer.style.display = 'none';
                // Kurum ekleme checkbox'ını gizle
                addInstitutionCheckbox.parentElement.style.display = 'none';
                addInstitutionCheckbox.checked = false;
            } else {
                // Kurum select'ini göster
                institutionContainer.style.display = 'flex';
                // Kurum ekleme checkbox'ını göster
                addInstitutionCheckbox.parentElement.style.display = 'block';
            }
        }

        // Metronic JavaScript'lerinin yüklenmesini bekle
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profile_update_form');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearAllErrors();

                    // Get form data
                    const phone = this.querySelector('input[name="phone"]').value.trim();
                    const institution = this.querySelector('select[name="institution"]').value;
                    const title = this.querySelector('select[name="title"]').value;
                    const country = this.querySelector('select[name="country"]').value;
                    const noInstitution = this.querySelector('input[name="no_institution"]').checked;
                    const addInstitution = this.querySelector('input[name="add_institution"]').checked;

                    let hasErrors = false;

                    // Phone validation

                    if (!phone) {
                        showError('phone', 'Telefon numarası zorunludur.');
                        hasErrors = true;
                    } else if (!isValidPhone(phone)) {
                        showError('phone', 'Geçerli bir telefon numarası giriniz (örn: 05551234567 veya 5551234567).');
                        hasErrors = true;
                    }

                    // Institution validation
                    if (!noInstitution && !addInstitution) {
                        if (!institution) {
                            showError('institution', 'Kurum seçimi zorunludur.');
                            hasErrors = true;
                        }
                    }

                    // Title validation
                    if (!title) {
                        showError('title', 'Ünvan seçimi zorunludur.');
                        hasErrors = true;
                    }

                    // Country validation
                    if (!country) {
                        showError('country', 'Ülke seçimi zorunludur.');
                        hasErrors = true;
                    }

                    // New institution validation (if adding new institution)
                    if (addInstitution) {
                        const institutionName = this.querySelector('input[name="institution_name"]').value.trim();
                        const institutionType = this.querySelector('select[name="institution_type"]').value;
                        const institutionCountry = this.querySelector('select[name="institution_country"]').value;
                        const institutionCity = this.querySelector('input[name="institution_city"]').value.trim();

                        if (!institutionName) {
                            showError('institution_name', 'Kurum adı zorunludur.');
                            hasErrors = true;
                        }

                        if (!institutionType) {
                            showError('institution_type', 'Kurum türü seçimi zorunludur.');
                            hasErrors = true;
                        }

                        if (!institutionCountry) {
                            showError('institution_country', 'Kurum ülkesi seçimi zorunludur.');
                            hasErrors = true;
                        }

                        if (!institutionCity) {
                            showError('institution_city', 'Kurum şehri zorunludur.');
                            hasErrors = true;
                        }
                    }

                    if (hasErrors) {
                        return;
                    }

                    // Convert form data to JSON
                    const formData = new FormData(this);
                    const jsonData = {};

                    for (let [key, value] of formData.entries()) {
                        if (jsonData[key]) {
                            // Handle multiple values (like checkboxes)
                            if (Array.isArray(jsonData[key])) {
                                jsonData[key].push(value);
                            } else {
                                jsonData[key] = [jsonData[key], value];
                            }
                        } else {
                            jsonData[key] = value;
                        }
                    }

                    // Send AJAX request
                    fetch('/apps/profile/complete', {
                            method: 'POST',
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
                            if (data.success) {
                                // Success - redirect to home page
                                window.location.href = '/';
                            } else {
                                showGeneralError(data.message || 'Profil tamamlanırken bir hata oluştu.');
                            }
                        })
                        .catch(error => {
                            if (error.message) {
                                try {
                                    const errorData = JSON.parse(error.message);
                                    if (errorData.errors) {
                                        // Field-specific errors
                                        Object.keys(errorData.errors).forEach(field => {
                                            showFieldError(field, errorData.errors[field]);
                                        });
                                    } else {
                                        showGeneralError(errorData.message || 'Bir hata oluştu. Lütfen tekrar deneyin.');
                                    }
                                } catch (e) {
                                    showGeneralError(error.message);
                                }
                            } else {
                                showGeneralError('Bir hata oluştu. Lütfen tekrar deneyin.');
                            }
                        });
                });
            }

            // Metronic'in yüklenmesini bekle
            function initializeSelectboxes() {
                // Selectbox'ları bul
                const selectboxes = document.querySelectorAll('[data-kt-select="true"]');

                if (selectboxes.length === 0) {
                    return;
                }

                // Metronic KTSelect'in yüklenip yüklenmediğini kontrol et
                if (typeof KTSelect === 'undefined') {
                    setTimeout(initializeSelectboxes, 500);
                    return;
                }
                // Her selectbox'ı initialize et
                selectboxes.forEach(function(selectbox) {
                    try {
                        // KTSelect instance'ı oluştur
                        const ktSelectInstance = new KTSelect(selectbox);
                    } catch (error) {
                        console.error('Selectbox initialize hatası:', error);
                    }
                });

                // Selectbox click event'leri
                selectboxes.forEach(function(selectbox) {
                    selectbox.addEventListener('click', function() {
                        // Diğer tüm selectbox'ları kapat
                        selectboxes.forEach(function(otherSelectbox) {
                            if (otherSelectbox !== selectbox) {
                                const ktSelectInstance = KTSelect.getInstance(otherSelectbox);
                                if (ktSelectInstance) {
                                    ktSelectInstance.hide();
                                }
                            }
                        });
                    });
                });
            }

            // İlk deneme
            initializeSelectboxes();
        });
    </script>

    <!-- Metronic JavaScript dosyaları -->
    <script src="assets/js/core.bundle.js">
    </script>
    <script src="assets/vendors/ktui/ktui.min.js">
    </script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js">
    </script>
    <script src="assets/js/widgets/general.js">
    </script>
    <script src="assets/js/layouts/demo1.js">
    </script>

</body>

</html>
