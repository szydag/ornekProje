<div class="kt-container-fixed p-0">
<form method="post" action="#" enctype="multipart/form-data" id="step4_form" style="width: 100%;">

        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5">

            <!-- Step 4: Ek Bilgiler -->
            <div class="kt-card pb-2.5">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">4. Ek Bilgiler</h3>
                </div>
                <div class="kt-card-content grid gap-5">

                    <!-- Validation Error Display -->
                    <div id="extra-info-error" style="display: none; color: #dc2626; font-size: 0.875rem; padding: 0.75rem; background: #fee2e2; border-radius: 0.5rem;"></div>

                    <!-- Proje Numarası -->
                    <div class="kt-form-field">
                        <label class="kt-form-label mb-2">
                            Proje Numarası
                        </label>
                        <input class="kt-input" name="project_number" id="project_number" type="text" placeholder="Proje numarasını giriniz" />
                        <div id="project_number-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                    </div>

                    <!-- Diller -->
                    <div class="kt-form-field">
                        <label class="kt-form-label mb-2">
                            Diller
                        </label>
                        <div class="flex gap-6">
                            <label class="kt-checkbox-group" style="display: flex; flex-direction: row; align-items: center; gap: 8px;">
                                <input class="kt-checkbox" name="language_tr" id="language_tr" type="checkbox" value="tr" onchange="handleAdditionalLanguageSelection(this)"/>
                                <span class="kt-checkbox-label">Türkçe</span>
                            </label>
                            <label class="kt-checkbox-group" style="display: flex; flex-direction: row; align-items: center; gap: 8px;">
                                <input class="kt-checkbox" name="language_en" id="language_en" type="checkbox" value="en" onchange="handleAdditionalLanguageSelection(this)"/>
                                <span class="kt-checkbox-label">İngilizce</span>
                            </label>
                        </div>
                        <div id="language-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                    </div>

                    <!-- Türkçe Kartı -->
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">Türkçe</h3>
                        </div>
                        <div class="kt-card-content grid gap-5">
                            <!-- Etik Beyan -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Etik Beyan
                                </label>
                                <textarea class="kt-input" style="min-height: 80px !important;" name="ethics_statement_tr" id="ethics_statement_tr" rows="4" placeholder="Etik beyanınızı giriniz"></textarea>
                                <div id="ethics_statement_tr-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>

                            <!-- Destekleyen Kurum -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Destekleyen Kurum
                                </label>
                                <input class="kt-input" name="supporting_institution_tr" id="supporting_institution_tr" type="text" placeholder="Araştırmayı destekleyen kurum adı" />
                                <div id="supporting_institution_tr-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>

                            <!-- Teşekkür -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Teşekkür
                                </label>
                                <textarea class="kt-input" style="min-height: 80px !important;" name="acknowledgments_tr" id="acknowledgments_tr" rows="4" placeholder="Teşekkür metninizi giriniz"></textarea>
                                <div class="kt-form-description text-2sm mt-1">
                                    En az 3 kelime olmalıdır
                                </div>
                                <div id="acknowledgments_tr-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- İngilizce Kartı -->
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">İngilizce</h3>
                        </div>
                        <div class="kt-card-content grid gap-5">
                            <!-- Etik Beyan -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Etik Beyan
                                </label>
                                <textarea class="kt-input" style="min-height: 80px !important;" name="ethics_statement_en" id="ethics_statement_en" rows="4" placeholder="Etik beyanınızı İngilizce olarak giriniz"></textarea>
                                <div id="ethics_statement_en-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>

                            <!-- Destekleyen Kurum -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Destekleyen Kurum
                                </label>
                                <input class="kt-input" name="supporting_institution_en" id="supporting_institution_en" type="text" placeholder="Araştırmayı destekleyen kurum adını İngilizce olarak giriniz" />
                                <div id="supporting_institution_en-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>

                            <!-- Teşekkür -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Teşekkür
                                </label>
                                <textarea class="kt-input" style="min-height: 80px !important;" name="acknowledgments_en" id="acknowledgments_en" rows="4" placeholder="Teşekkür metninizi İngilizce olarak giriniz"></textarea>
                                <div class="kt-form-description text-2sm mt-1">
                                    En az 3 kelime olmalıdır
                                </div>
                                <div id="acknowledgments_en-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic; margin-top: 0.25rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
(() => {
    const API_URL = '/apps/add-material/step-4';
    const jsonHeaders = {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };

    const updateRoot = document.getElementById('content_update_root');
    const IS_UPDATE_MODE = updateRoot?.dataset?.updateMode === '1';

    const dom = {
        form: document.getElementById('step4_form'),
        projectNumber: document.querySelector('input[name="project_number"]'),
    };

    let realtimeValidationBound = false;

    const languages = {
        tr: {
            checkbox: 'input[name="language_tr"]',
            fields: {
                ethics: 'textarea[name="ethics_statement_tr"]',
                supporting: 'input[name="supporting_institution_tr"]',
                thanks: 'textarea[name="acknowledgments_tr"]',
            },
        },
        en: {
            checkbox: 'input[name="language_en"]',
            fields: {
                ethics: 'textarea[name="ethics_statement_en"]',
                supporting: 'input[name="supporting_institution_en"]',
                thanks: 'textarea[name="acknowledgments_en"]',
            },
        },
    };

    function setLanguageChecked(lang, checked) {
        const checkbox = getCheckbox(lang);
        if (!checkbox) {
            return;
        }
        checkbox.checked = Boolean(checked);
    }

    function handleAdditionalLanguageSelection(clickedCheckbox) {
        if (!clickedCheckbox) {
            return;
        }
        const lang = clickedCheckbox.name === 'language_en' ? 'en' : 'tr';
        setLanguageChecked(lang, clickedCheckbox.checked);
    }

    function getFieldElements(fieldName) {
        if (!fieldName) return [];
        const scope = dom.form ?? document;
        const elements = [];
        const byId = scope.querySelector(`#${fieldName}`);
        if (byId) elements.push(byId);
        scope.querySelectorAll(`[name="${fieldName}"]`).forEach((el) => {
            if (!elements.includes(el)) {
                elements.push(el);
            }
        });
        return elements;
    }

    function getCheckbox(lang) {
        const selector = languages[lang]?.checkbox;
        return selector ? document.querySelector(selector) : null;
    }

    function getField(lang, key) {
        const selector = languages[lang]?.fields?.[key];
        return selector ? document.querySelector(selector) : null;
    }

    function valueOrNull(el) {
        if (!el) return null;
        const value = typeof el.value === 'string' ? el.value.trim() : '';
        return value === '' ? null : value;
    }

    function setElementValue(el, value) {
        if (!el) return;
        el.value = value ?? '';
    }

    function getProjectNumber() {
        return valueOrNull(dom.projectNumber);
    }

    function setProjectNumber(value) {
        if (dom.projectNumber) dom.projectNumber.value = value ?? '';
    }

    function clearLanguagesForUpdate() {
        Object.keys(languages).forEach((lang) => {
            setLanguageChecked(lang, false);
            setElementValue(getField(lang, 'ethics'), null);
            setElementValue(getField(lang, 'supporting'), null);
            setElementValue(getField(lang, 'thanks'), null);
        });
    }

    function ensureLanguageForUpdate(lang, values = {}) {
        const normalized = languages[lang] ? lang : 'tr';
        setLanguageChecked(normalized, true);

        if (values && typeof values === 'object') {
            if (Object.prototype.hasOwnProperty.call(values, 'ethics')) {
                setElementValue(getField(normalized, 'ethics'), values.ethics ?? '');
            }
            if (Object.prototype.hasOwnProperty.call(values, 'supporting')) {
                setElementValue(getField(normalized, 'supporting'), values.supporting ?? '');
            }
            if (Object.prototype.hasOwnProperty.call(values, 'thanks')) {
                setElementValue(getField(normalized, 'thanks'), values.thanks ?? '');
            }
            if (Object.prototype.hasOwnProperty.call(values, 'projectNumber')) {
                setProjectNumber(values.projectNumber);
            }
        }
    }

    function collectRows(projectNumber) {
        const rows = [];
        Object.keys(languages).forEach((lang) => {
            const ethics = valueOrNull(getField(lang, 'ethics'));
            const supporting = valueOrNull(getField(lang, 'supporting'));
            const thanks = valueOrNull(getField(lang, 'thanks'));
            const checkbox = getCheckbox(lang);
            const selected = checkbox ? checkbox.checked : false;
            const hasContent = [ethics, supporting, thanks].some((val) => val !== null);

            if (selected || hasContent) {
                rows.push({
                    lang,
                    ethics_declaration: ethics,
                    supporting_institution: supporting,
                    thanks_description: thanks,
                    project_number: projectNumber ?? null,
                });
            }
        });
        return rows;
    }

    function collectPayload() {
        const projectNumber = getProjectNumber();
        return {
            project_number: projectNumber,
            rows: collectRows(projectNumber),
        };
    }

    function fetchJSON(url, options = {}) {
        const config = {
            method: options.method ?? 'GET',
            headers: { ...(options.headers ?? {}) },
        };

        if (!config.headers['X-Requested-With']) {
            config.headers['X-Requested-With'] = 'XMLHttpRequest';
        }

        if (options.body !== undefined) {
            if (options.body instanceof FormData) {
                config.body = options.body;
            } else if (typeof options.body === 'string') {
                config.body = options.body;
                if (!config.headers['Content-Type']) {
                    config.headers['Content-Type'] = 'application/json';
                }
            } else {
                config.body = JSON.stringify(options.body);
                if (!config.headers['Content-Type']) {
                    config.headers['Content-Type'] = 'application/json';
                }
            }
        }

        return fetch(url, config).then(async (response) => {
            let payload = null;
            try {
                payload = await response.json();
            } catch {
                payload = null;
            }

            if (!response.ok) {
                const message = payload?.error ?? payload?.message ?? `HTTP ${response.status}`;
                throw new Error(message);
            }

            if (payload?.status && !['success', 'ok'].includes(payload.status)) {
                throw new Error(payload.error ?? payload.message ?? 'İşlem sırasında hata oluştu.');
            }

            return payload ?? {};
        });
    }

    function hydrateStep(payload) {
        const data = payload?.data ?? payload ?? {};
        setProjectNumber(data.project_number ?? null);
        clearLanguagesForUpdate();

        const rows = Array.isArray(data.rows) ? data.rows : [];
        rows.forEach((row) => {
            const lang = String(row.lang ?? row.language ?? '').toLowerCase();
            if (!languages[lang]) return;

            ensureLanguageForUpdate(lang, {
                ethics: row.ethics_declaration ?? row.ethics_statement ?? '',
                supporting: row.supporting_institution ?? '',
                thanks: row.thanks_description ?? row.acknowledgments ?? '',
                projectNumber: row.project_number ?? data.project_number ?? null,
            });
        });

        const anySelected = Object.keys(languages).some((lang) => getCheckbox(lang)?.checked);
        if (!anySelected) {
            setLanguageChecked('tr', true);
        }
    }

    function showStep4Error(message) {
        const errorElement = document.getElementById('extra-info-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function clearStep4Error() {
        const errorElement = document.getElementById('extra-info-error');
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function clearFieldError(fieldName) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    function clearAllFieldErrors() {
        const fieldNames = [
            'project_number',
            'language',
            'language_tr',
            'language_en',
            'ethics_statement_tr',
            'supporting_institution_tr',
            'acknowledgments_tr',
            'ethics_statement_en',
            'supporting_institution_en',
            'acknowledgments_en',
        ];
        fieldNames.forEach((field) => clearFieldError(field));
    }

    function bindRealtimeValidation() {
        if (realtimeValidationBound) {
            return;
        }
        realtimeValidationBound = true;

        const trackedFields = [
            'project_number',
            'ethics_statement_tr',
            'supporting_institution_tr',
            'acknowledgments_tr',
            'ethics_statement_en',
            'supporting_institution_en',
            'acknowledgments_en',
        ];

        trackedFields.forEach((field) => {
            const elements = getFieldElements(field);
            elements.forEach((element) => {
                const handler = () => {
                    clearFieldError(field);
                    clearStep4Error();
                };
                element.addEventListener('input', handler);
                element.addEventListener('change', handler);
            });
        });

        ['language_tr', 'language_en'].forEach((field) => {
            const checkbox = document.getElementById(field);
            if (checkbox) {
                checkbox.addEventListener('change', () => {
                    clearFieldError('language');
                    clearStep4Error();
                });
            }
        });
    }

    function validateStep4Internal() {
        clearStep4Error();
        clearAllFieldErrors();

        let hasErrors = false;
        let firstErrorField = null;

        // Elementleri bul
        const trCheckbox = document.querySelector('input[name="language_tr"]');
        const enCheckbox = document.querySelector('input[name="language_en"]');
        const projectNumberInput = document.querySelector('input[name="project_number"]');

        const trChecked = trCheckbox?.checked ?? false;
        const enChecked = enCheckbox?.checked ?? false;
        const projectNumber = projectNumberInput?.value.trim() ?? '';

        // 1. Dil kontrolü - ZORUNLU
        if (!trChecked && !enChecked) {
            showFieldError('language', 'En az bir dil seçmelisiniz.');
            if (!firstErrorField) firstErrorField = 'language_tr';
            hasErrors = true;
        }

        // 2. Proje numarası kontrolü - İSTEĞE BAĞLI (length sınırı yok)
        if (!projectNumber) {
            showFieldError('project_number', 'Proje numarası zorunludur.');
            if (!firstErrorField) firstErrorField = 'project_number';
            hasErrors = true;
        }
        const ethicsTr = document.querySelector('textarea[name="ethics_statement_tr"]')?.value.trim() ?? '';
        const supportingTr = document.querySelector('input[name="supporting_institution_tr"]')?.value.trim() ?? '';
        const thanksTr = document.querySelector('textarea[name="acknowledgments_tr"]')?.value.trim() ?? '';

        // Her alan tek tek kontrol edilir
        if (!ethicsTr) {
            showFieldError('ethics_statement_tr', 'Türkçe etik beyan zorunludur.');
            if (!firstErrorField) firstErrorField = 'ethics_statement_tr';
            hasErrors = true;
        }

        if (!supportingTr) {
            showFieldError('supporting_institution_tr', 'Türkçe destekleyen kurum zorunludur.');
            if (!firstErrorField) firstErrorField = 'supporting_institution_tr';
            hasErrors = true;
        }

        if (!thanksTr) {
            showFieldError('acknowledgments_tr', 'Türkçe teşekkür zorunludur.');
            if (!firstErrorField) firstErrorField = 'acknowledgments_tr';
            hasErrors = true;
        } else if (thanksTr.split(/\s+/).filter(Boolean).length < 3) {
            showFieldError('acknowledgments_tr', 'Türkçe teşekkür metni en az 3 kelime olmalıdır.');
            if (!firstErrorField) firstErrorField = 'acknowledgments_tr';
            hasErrors = true;
        }

        
        const ethicsEn = document.querySelector('textarea[name="ethics_statement_en"]')?.value.trim() ?? '';
        const supportingEn = document.querySelector('input[name="supporting_institution_en"]')?.value.trim() ?? '';
        const thanksEn = document.querySelector('textarea[name="acknowledgments_en"]')?.value.trim() ?? '';


        // Her alan tek tek kontrol edilir
        if (!ethicsEn) {
            showFieldError('ethics_statement_en', 'İngilizce etik beyan zorunludur.');
            if (!firstErrorField) firstErrorField = 'ethics_statement_en';
            hasErrors = true;
        }

        if (!supportingEn) {
            showFieldError('supporting_institution_en', 'İngilizce destekleyen kurum zorunludur.');
            if (!firstErrorField) firstErrorField = 'supporting_institution_en';
            hasErrors = true;
        }

        if (!thanksEn) {
            showFieldError('acknowledgments_en', 'İngilizce teşekkür zorunludur.');
            if (!firstErrorField) firstErrorField = 'acknowledgments_en';
            hasErrors = true;
        } else if (thanksEn.split(/\s+/).filter(Boolean).length < 3) {
            showFieldError('acknowledgments_en', 'İngilizce teşekkür metni en az 3 kelime olmalıdır.');
            if (!firstErrorField) firstErrorField = 'acknowledgments_en';
            hasErrors = true;
        }

        // Hata varsa ilk hataya scroll yap
        if (hasErrors) {
            
            if (firstErrorField) {
                const errorElement = document.getElementById(`${firstErrorField}-error`);
                const inputElement = document.querySelector(`[name="${firstErrorField}"]`) || document.getElementById(firstErrorField);
                
                if (errorElement) {
                    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                if (inputElement) {
                    setTimeout(() => inputElement.focus(), 300);
                }
            }
            
            return false;
        }

        return true;
    }

    function submitStep4Internal() {
        if (!validateStep4Internal()) {
            return Promise.reject(new Error('Validasyon hatası'));
        }
        const payload = collectPayload();
        return fetchJSON(API_URL, {
            method: 'POST',
            headers: jsonHeaders,
            body: payload,
        });
    }

    function loadStep4() {
        fetchJSON(API_URL)
            .then((payload) => hydrateStep(payload))
            .catch((error) => {
                console.warn('[Step4] Oturum verisi alınamadı', error);
                hydrateStep({ project_number: null, rows: [] });
            });
    }

    const contentStep4Api = {
        hydrate: (payload) => hydrateStep(payload),
        collect: () => collectPayload(),
        validate: () => validateStep4Internal(),
        load: () => loadStep4(),
        submit: () => submitStep4Internal(),
        clearLanguages: () => clearLanguagesForUpdate(),
        ensureLanguage: (lang, values) => ensureLanguageForUpdate(lang, values),
        setProjectNumber: (value) => setProjectNumber(value),
    };

    window.__contentStep4 = contentStep4Api;

    function registerWithWizard() {
        if (!window.contentWizard) {
            console.warn('[Step 4] contentWizard henüz hazır değil, bekleniyor...');
            setTimeout(registerWithWizard, 100);
            return;
        }
        window.contentWizard.registerHydrator(4, (payload) => hydrateStep(payload));
        window.contentWizard.registerCollector(4, () => collectPayload());
        window.contentWizard.registerValidator(4, () => validateStep4Internal());
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (dom.form) dom.form.setAttribute('action', '#');
        bindRealtimeValidation();
        registerWithWizard();
        if (!IS_UPDATE_MODE) {
            loadStep4();
        } else {
            const cached = window.contentWizard?.getCached?.(4);
            if (cached) {
                hydrateStep(cached);
            }
        }
    });

    // Global fonksiyonları kaydet
    window.handleAdditionalLanguageSelection = handleAdditionalLanguageSelection;
    window.validateStep4 = validateStep4Internal;
    window.submitStep4 = submitStep4Internal;
    window.collectStep4Payload = collectPayload;

    // Eğer sayfa zaten yüklenmişse hemen çalıştır
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        bindRealtimeValidation();
        registerWithWizard();
        if (!IS_UPDATE_MODE) {
            loadStep4();
        } else {
            const cached = window.contentWizard?.getCached?.(4);
            if (cached) {
                hydrateStep(cached);
            }
        }
    }
})();
</script>
