<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $session = session();
    $successMessage = $session->getFlashdata('success');
    $errorMessage   = $session->getFlashdata('error');
    $fieldErrors    = $session->getFlashdata('errors') ?? [];

    $institutions     = isset($institutions) && is_array($institutions) ? $institutions : [];
    $titles           = isset($titles) && is_array($titles) ? $titles : [];
    $countries        = isset($countries) && is_array($countries) ? $countries : [];
    $institutionTypes = isset($institutionTypes) && is_array($institutionTypes) ? $institutionTypes : [];

    $shouldLoadDictionaries = empty($institutions) || empty($titles) || empty($countries) || empty($institutionTypes);
    if ($shouldLoadDictionaries) {
        try {
            $wizardService = new \App\Services\Articles\ContentWizardService();
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
            $institutions     = is_array($institutions) ? $institutions : [];
            $titles           = is_array($titles) ? $titles : [];
            $countries        = is_array($countries) ? $countries : [];
            $institutionTypes = is_array($institutionTypes) ? $institutionTypes : [];
        }
    }

    $noInstitutionDefault  = $user['no_institution'] ?? false;
    $addInstitutionDefault = $user['add_institution'] ?? false;

$noInstitutionChecked = old('no_institution') !== null
    ? ((int) old('no_institution') === 1)
    : (bool) $noInstitutionDefault;

$addInstitutionChecked = old('add_institution') !== null
    ? ((int) old('add_institution') === 1)
    : (bool) $addInstitutionDefault;

if ($addInstitutionChecked) {
    $noInstitutionChecked = false;
} elseif ($noInstitutionChecked) {
    $addInstitutionChecked = false;
}

$selectedInstitution = (string) old('institution', isset($user['institution']) ? (string) $user['institution'] : '');
$selectedTitle       = (string) old('title', isset($user['title']) ? (string) $user['title'] : '');
$selectedCountry     = (string) old('country', isset($user['country']) ? (string) $user['country'] : '');
$selectedInstitutionType = (string) old('institution_type', '');
$selectedInstitutionCountry = (string) old('institution_country', '');
?>

<style>
    .hero-bg {
        background-image: url('<?= base_url('/assets/media/images/2600x1200/bg-1.png') ?>');
    }

    .dark .hero-bg {
        background-image: url('<?= base_url('/assets/media/images/2600x1200/bg-1-dark.png') ?>');
    }
</style>

<!-- Page Content -->
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                Profil Bilgilerim
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Kişisel bilgilerinizi güncelleyin
            </div>
        </div>
    </div>

    <!-- Profile Update Form -->
    <form action="<?= base_url('/app/profile/update') ?>" method="post" id="profile_update_form" novalidate>
        <?= csrf_field() ?>

        <div class="kt-card pb-2.5 w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">
                    Profil Bilgileri
                </h3>
            </div>
            <div class="kt-card-content grid gap-5 w-full p-6">

                <?php if ($successMessage): ?>
                    <div class="kt-alert kt-alert-success" id="profile-success-alert">
                        <?= esc($successMessage) ?>
                    </div>
                <?php endif; ?>

                <?php if ($errorMessage): ?>
                    <div class="kt-alert kt-alert-danger">
                        <?= esc($errorMessage) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($fieldErrors)): ?>
                    <div class="kt-alert kt-alert-danger">
                        <ul class="list-disc list-inside">
                            <?php foreach (array_unique(array_values($fieldErrors)) as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Ad Soyad -->
                <div class="space-y-5">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Ad*
                        </label>
                        <div class="grow">
                            <div class="kt-form-field">
                                <input class="kt-input" name="first_name" placeholder="Adınızı girin" type="text" value="<?= esc(old('first_name', $user['first_name'] ?? '')) ?>" required />
                                <div class="text-sm italic mt-1" id="first_name-error" style="display: none; color: #dc2626;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Soyad*
                        </label>
                        <div class="grow">
                            <div class="kt-form-field">
                                <input class="kt-input" name="last_name" placeholder="Soyadınızı girin" type="text" value="<?= esc(old('last_name', $user['last_name'] ?? '')) ?>" required />
                                <div class="text-sm italic mt-1" id="last_name-error" style="display: none; color: #dc2626;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E-posta -->
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="kt-form-label max-w-56">
                        E-posta*
                    </label>
                    <div class="grow">
                        <div class="kt-form-field">
                            <input class="kt-input" name="email" placeholder="E-posta adresinizi girin" type="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>" required />
                            <div class="text-sm italic mt-1" id="email-error" style="display: none; color: #dc2626;"></div>
                        </div>
                    </div>
                </div>

                <!-- Telefon -->
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="kt-form-label max-w-56">
                        Telefon Numarası*
                    </label>
                    <div class="grow">
                        <div class="kt-form-field">
                            <input class="kt-input" name="phone" placeholder="Örn: +90 555 123 45 67" type="tel" value="<?= esc(old('phone', $user['phone'] ?? '')) ?>" required />
                            <small class="text-xs text-muted-foreground mt-1">
                                Ülke kodu ile birlikte telefon numaranızı girin
                            </small>
                            <div class="text-sm italic mt-1" id="phone-error" style="display: none; color: #dc2626;"></div>
                        </div>
                    </div>
                </div>

                <!-- Kurum -->
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5" id="institution_select_row" style="<?= ($addInstitutionChecked || $noInstitutionChecked) ? 'display: none;' : '' ?>">
                    <label class="kt-form-label max-w-56">
                        Kurum*
                    </label>
                    <div class="grow">
                        <div class="kt-form-field">
                            <select class="kt-input" name="institution" data-kt-select="true" data-kt-select-config='{
                                "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                            }' data-kt-select-enable-search="true" data-kt-select-placeholder="Kurum seçiniz" data-kt-select-search-placeholder="Arama...">
                                <?php foreach ($institutions as $value => $institution): ?>
                                    <option value="<?= esc($value) ?>" <?= $selectedInstitution === (string) $value ? 'selected' : '' ?>><?= esc($institution) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="text-sm italic mt-1" id="institution-error" style="display: none; color: #dc2626;"></div>
                        </div>
                    </div>
                </div>

                <!-- Kurum Seçenekleri -->
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="kt-form-label max-w-56">
                        Kurum Seçenekleri
                    </label>
                    <div class="flex flex-col gap-3 grow">
                        <label class="kt-label" id="no_institution_label" style="<?= $addInstitutionChecked ? 'display: none;' : '' ?>">
                            <input class="kt-checkbox kt-checkbox-sm" name="no_institution" type="checkbox" value="1" id="no_institution_checkbox" <?= $noInstitutionChecked ? 'checked' : '' ?>>
                            Kurum yok
                        </label>

                        <label class="kt-label" id="add_institution_label" style="<?= $noInstitutionChecked ? 'display: none;' : '' ?>">
                            <input class="kt-checkbox kt-checkbox-sm" name="add_institution" type="checkbox" value="1" id="add_institution_checkbox" <?= $addInstitutionChecked ? 'checked' : '' ?>>
                            Kurum eklemek istiyorum
                        </label>

                        <div class="text-sm italic mt-1" id="institution_choice-error" style="display: none; color: #dc2626;"></div>

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
                                                    <?php foreach ($institutionTypes as $typeId => $typeName): ?>
                                                        <option value="<?= esc($typeId) ?>" <?= $selectedInstitutionType === (string) $typeId ? 'selected' : '' ?>><?= esc($typeName) ?></option>
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
                                                    
                                                }' data-kt-select-enable-search="true" '>
                                                    <?php foreach ($countries as $code => $country): ?>
                                                        <?php $optionData = ['flag' => $country['flag'] ?? '']; ?>
                                                        <option value="<?= esc($code) ?>" data-kt-select-option=' <?= esc(json_encode($optionData, JSON_UNESCAPED_UNICODE), 'attr') ?>' <?= $selectedInstitutionCountry === (string) $code ? 'selected' : '' ?>><?= esc($country['name']) ?></option>
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
                                <?php foreach ($titles as $value => $title): ?>
                                    <option value="<?= esc($value) ?>" <?= $selectedTitle === (string) $value ? 'selected' : '' ?>><?= esc($title) ?></option>
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
                                                    <?php foreach ($countries as $code => $country): ?>
                                                        <?php $optionData = ['flag' => $country['flag'] ?? '']; ?>
                                                        <option value="<?= esc($code) ?>" data-kt-select-option=' <?= esc(json_encode($optionData, JSON_UNESCAPED_UNICODE), 'attr') ?>' <?= $selectedCountry === (string) $code ? 'selected' : '' ?>><?= esc($country['name']) ?></option>
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
                        Profili Güncelle
                    </button>
                </div>
            </div>
        </div>
    </form>
    <br>
    <br>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Initialize clean selectboxes
    setTimeout(() => {
        const selectboxes = document.querySelectorAll('select.kt-input');
        selectboxes.forEach(select => {
            if (typeof initCleanSelectbox === 'function') {
                initCleanSelectbox(select);
            }
        });
    }, 1000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('profile-success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 4000);
        }

        // Selectbox'ları bul
        const selectboxes = document.querySelectorAll('[data-kt-select="true"]');

        selectboxes.forEach(function(selectbox) {
            selectbox.addEventListener('click', function() {
                // Diğer tüm selectbox'ları kapat
                selectboxes.forEach(function(otherSelectbox) {
                    if (otherSelectbox !== selectbox) {
                        // KtSelect instance'ını bul ve kapat
                        const ktSelectInstance = KTSelect.getInstance(otherSelectbox);
                        if (ktSelectInstance) {
                            ktSelectInstance.hide();
                        }
                    }
                });
            });
        });

        const institutionRow = document.getElementById('institution_select_row');
        const institutionFields = document.getElementById('institution_fields');
        const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');
        const addInstitutionCheckbox = document.getElementById('add_institution_checkbox');
        const noInstitutionLabel = document.getElementById('no_institution_label');
        const addInstitutionLabel = document.getElementById('add_institution_label');

        function syncInstitutionMode() {
            const addChecked = !!(addInstitutionCheckbox && addInstitutionCheckbox.checked);
            const noChecked = !!(noInstitutionCheckbox && noInstitutionCheckbox.checked);

            if (addChecked) {
                if (institutionFields) {
                    institutionFields.style.display = 'block';
                }
                if (institutionRow) {
                    institutionRow.style.display = 'none';
                }
                if (noInstitutionLabel) {
                    noInstitutionLabel.style.display = 'none';
                }
                if (noInstitutionCheckbox) {
                    noInstitutionCheckbox.checked = false;
                }
                if (addInstitutionLabel) {
                    addInstitutionLabel.style.display = '';
                }
                return;
            }

            if (noChecked) {
                if (institutionFields) {
                    institutionFields.style.display = 'none';
                }
                if (institutionRow) {
                    institutionRow.style.display = 'none';
                }
                if (addInstitutionLabel) {
                    addInstitutionLabel.style.display = 'none';
                }
                if (addInstitutionCheckbox) {
                    addInstitutionCheckbox.checked = false;
                }
                if (noInstitutionLabel) {
                    noInstitutionLabel.style.display = '';
                }
                return;
            }

            if (institutionFields) {
                institutionFields.style.display = 'none';
            }
            if (institutionRow) {
                institutionRow.style.display = '';
            }
            if (noInstitutionLabel) {
                noInstitutionLabel.style.display = '';
            }
            if (addInstitutionLabel) {
                addInstitutionLabel.style.display = '';
            }
        }

        if (addInstitutionCheckbox) {
            addInstitutionCheckbox.addEventListener('change', syncInstitutionMode);
        }

        if (noInstitutionCheckbox) {
            noInstitutionCheckbox.addEventListener('change', syncInstitutionMode);
        }

        syncInstitutionMode();

        // Form validasyonu
        const form = document.getElementById('profile_update_form');
        if (form) {
            form.addEventListener('submit', function(e) {

                // Hata mesajlarını temizle
                clearAllErrors();

                let hasErrors = false;

                // Ad validasyonu
                const firstName = document.querySelector('input[name="first_name"]');
                if (!firstName) {
                    hasErrors = true;
                } else if (!firstName.value.trim()) {
                    showError('first_name', 'Ad alanı zorunludur.');
                    hasErrors = true;
                } else if (firstName.value.trim().length < 2) {
                    showError('first_name', 'Ad en az 2 karakter olmalıdır.');
                    hasErrors = true;
                } else if (firstName.value.trim().length > 50) {
                    showError('first_name', 'Ad en fazla 50 karakter olmalıdır.');
                    hasErrors = true;
                }

                // Soyad validasyonu
                const lastName = document.querySelector('input[name="last_name"]');
                if (!lastName) {
                    hasErrors = true;
                } else if (!lastName.value.trim()) {
                    showError('last_name', 'Soyad alanı zorunludur.');
                    hasErrors = true;
                } else if (lastName.value.trim().length < 2) {
                    showError('last_name', 'Soyad en az 2 karakter olmalıdır.');
                    hasErrors = true;
                } else if (lastName.value.trim().length > 50) {
                    showError('last_name', 'Soyad en fazla 50 karakter olmalıdır.');
                    hasErrors = true;
                }

                // E-posta validasyonu
                const email = document.querySelector('input[name="email"]');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email) {
                    hasErrors = true;
                } else if (!email.value.trim()) {
                    showError('email', 'E-posta alanı zorunludur.');
                    hasErrors = true;
                } else if (!emailRegex.test(email.value.trim())) {
                    showError('email', 'Geçerli bir e-posta adresi giriniz.');
                    hasErrors = true;
                }

                // Telefon validasyonu
                const phone = document.querySelector('input[name="phone"]');
                if (!phone) {
                    hasErrors = true;
                } else if (!phone.value.trim()) {
                    showError('phone', 'Telefon numarası zorunludur.');
                    hasErrors = true;
                } else if (phone.value.trim().length < 10) {
                    showError('phone', 'Telefon numarası en az 10 karakter olmalıdır.');
                    hasErrors = true;
                } else if (phone.value.trim().length > 20) {
                    showError('phone', 'Telefon numarası en fazla 20 karakter olmalıdır.');
                    hasErrors = true;
                }

                // Kurum validasyonu
                const noInstitutionChecked = document.getElementById('no_institution_checkbox')?.checked;
                const addInstitutionChecked = document.getElementById('add_institution_checkbox')?.checked;
                const institutionSelect = document.querySelector('select[name="institution"]');

                if (!noInstitutionChecked && !addInstitutionChecked) {
                    if (!institutionSelect || !institutionSelect.value) {
                        showError('institution', 'Kurum seçimi zorunludur.');
                        hasErrors = true;
                    }
                }

                // Kurum ekleme validasyonu
                if (addInstitutionChecked) {
                    const institutionName = document.querySelector('input[name="institution_name"]');
                    const institutionType = document.querySelector('select[name="institution_type"]');
                    const institutionCountry = document.querySelector('select[name="institution_country"]');
                    const institutionCity = document.querySelector('input[name="institution_city"]');

                    if (!institutionName || !institutionName.value.trim()) {
                        showError('institution_name', 'Kurum adı zorunludur.');
                        hasErrors = true;
                    }

                    if (!institutionType || !institutionType.value) {
                        showError('institution_type', 'Kurum türü zorunludur.');
                        hasErrors = true;
                    }

                    if (!institutionCountry || !institutionCountry.value) {
                        showError('institution_country', 'Kurum ülkesi zorunludur.');
                        hasErrors = true;
                    }

                    if (!institutionCity || !institutionCity.value.trim()) {
                        showError('institution_city', 'Kurum şehri zorunludur.');
                        hasErrors = true;
                    }
                }

                // Ünvan validasyonu
                const title = document.querySelector('select[name="title"]');
                if (!title || !title.value) {
                    showError('title', 'Ünvan seçimi zorunludur.');
                    hasErrors = true;
                }

                // Ülke validasyonu
                const country = document.querySelector('select[name="country"]');
                if (!country || !country.value) {
                    showError('country', 'Ülke seçimi zorunludur.');
                    hasErrors = true;
                }

                if (hasErrors) {
                    e.preventDefault();
                }
            });
        }

        function showError(fieldName, message) {
            const errorElement = document.getElementById(fieldName + '-error');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function clearError(fieldName) {
            const errorElement = document.getElementById(fieldName + '-error');
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        }

        function clearAllErrors() {
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.style.display = 'none';
            });
        }

        // Input değişikliklerinde hataları temizle
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearError(this.name);
            });
            input.addEventListener('change', function() {
                clearError(this.name);
            });
        });

        // Veriler PHP ile doğrudan geliyor, fetch gerekmez
        
        // Veriler ContentWizardService ile doğru şekilde geliyor
    });

    // Veriler ContentWizardService ile backend'den geliyor
</script>

<?= $this->endSection() ?>
