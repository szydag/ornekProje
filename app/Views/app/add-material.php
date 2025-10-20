<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>
<div class="kt-container-fixed grow pb-5 max-w-none px-2 sm:px-4" id="content">
    <form action="#" method="post">
        <div data-kt-stepper="true">
            <div class="kt-card">
                <div class="kt-card-header h-auto px-3 sm:px-10 py-4 sm:py-5 overflow-x-auto">
                    <div class="flex flex-row items-center justify-between w-full sm:gap-2">
                        <div data-kt-stepper-item="#stepper_1" class="active flex items-center gap-2.5 flex-1 justify-center">
                            <div
                                class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:!bg-blue-500 kt-stepper-item-active:!text-white kt-stepper-item-completed:!bg-blue-500 kt-stepper-item-completed:!text-white">
                                <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">1</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline"
                                    aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5 stepper-description">
                                <h4
                                    class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                    Temel Bilgiler
                                </h4>
                                <span
                                    class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">İçerik
                                    temel bilgileri</span>
                            </div>
                        </div>
                        <div data-kt-stepper-item="#stepper_2" class="flex items-center gap-2.5 flex-1 justify-center">
                            <div
                                class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:!bg-blue-500 kt-stepper-item-active:!text-white kt-stepper-item-completed:!bg-blue-500 kt-stepper-item-completed:!text-white">
                                <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">2</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline"
                                    aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5 stepper-description">
                                <h4
                                    class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                    Katkıda Bulunanlar
                                </h4>
                                <span
                                    class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Katkıda Bulunan
                                    bilgileri</span>
                            </div>
                        </div>
                        <div data-kt-stepper-item="#stepper_3" class="flex items-center gap-2.5 flex-1 justify-center">
                            <div
                                class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:!bg-blue-500 kt-stepper-item-active:!text-white kt-stepper-item-completed:!bg-blue-500 kt-stepper-item-completed:!text-white">
                                <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">3</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline"
                                    aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5 stepper-description">
                                <h4
                                    class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                    Ek Dosyalar
                                </h4>
                                <span
                                    class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Dosya
                                    yükleme</span>
                            </div>
                        </div>
                        <div data-kt-stepper-item="#stepper_4" class="flex items-center gap-2.5 flex-1 justify-center">
                            <div
                                class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:!bg-blue-500 kt-stepper-item-active:!text-white kt-stepper-item-completed:!bg-blue-500 kt-stepper-item-completed:!text-white">
                                <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">4</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline"
                                    aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5 stepper-description">
                                <h4
                                    class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                    Özet ve Anahtar Kelimeler
                                </h4>
                                <span
                                    class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">İçerik
                                    özeti</span>
                            </div>
                        </div>
                        <div data-kt-stepper-item="#stepper_5" class="flex items-center gap-2.5 flex-1 justify-center">
                            <div
                                class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:!bg-blue-500 kt-stepper-item-active:!text-white kt-stepper-item-completed:!bg-blue-500 kt-stepper-item-completed:!text-white">
                                <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">5</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline"
                                    aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5 stepper-description">
                                <h4
                                    class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                    Önizleme ve Gönderim
                                </h4>
                                <span
                                    class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Son
                                    kontrol</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-card-content px-3 sm:px-5 py-10 sm:py-20">
                    <div class="" id="stepper_1">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/steps/add-material-step-1') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_2">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/steps/add-material-step-2') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_3">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/steps/add-material-step-3') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_4">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/steps/add-material-step-4') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_5">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/steps/add-material-step-5') ?>
                        </div>
                    </div>
                </div>
                <div class="kt-card-footer justify-between p-5">
                    <div>
                        <button type="button" class="kt-btn kt-btn-secondary kt-stepper-first:hidden"
                            data-kt-stepper-back="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-left" aria-hidden="true">
                                <path d="m12 19-7-7 7-7"></path>
                                <path d="M19 12H5"></path>
                            </svg>Geri
                        </button>
                    </div>
                    <div>
                        <button type="button" class="kt-btn kt-btn-primary"
                            data-kt-stepper-next="true">
                            İleri<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        <button type="button" class="kt-btn kt-btn-success"
                            id="finalize_button" style="display: none;">
                            İçeriği Gönder
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modals -->
<?= $this->include('app/modals/add-author-modal') ?>
<?= $this->include('app/modals/add-file-modal') ?>
<?= $this->include('app/modals/required-file-modal') ?>

<style>
    /* Stepper renkleri için özel CSS */
    .kt-stepper-item-active {
        background-color: #3b82f6 !important;
        color: white !important;
    }

    .kt-stepper-item-completed {
        background-color: #3b82f6 !important;
        color: white !important;
    }

    .kt-stepper-item-active h4,
    .kt-stepper-item-completed h4 {
        color: #3b82f6 !important;
    }

    .kt-stepper-item-active span,
    .kt-stepper-item-completed span {
        color: #3b82f6 !important;
    }

    /* Aktif sayfada numara beyaz olsun */
    .kt-stepper-item-active [data-kt-stepper-number] {
        color: white !important;
    }

    .kt-stepper-item-completed svg {
        color: white !important;
    }

    /* Step açıklamaları için responsive CSS */
    @media (max-width: 767px) {
        .stepper-description {
            display: none !important;
        }
    }

    @media (min-width: 768px) {
        .stepper-description {
            display: flex !important;
        }
    }
</style>

<script>
    (() => {
        const API_BASE = '/apps/add-material';
        const STEP_COUNT = 5;

        const stepperItems = document.querySelectorAll('[data-kt-stepper-item]');
        const stepperContents = document.querySelectorAll('[id^="stepper_"]');
        const backBtn = document.querySelector('[data-kt-stepper-back]');
        let nextBtn = document.querySelector('[data-kt-stepper-next]');
        const finalizeBtn = document.getElementById('finalize_button');

        let currentStep = 1;
        const loadedSteps = new Set();
        const stepCache = new Map();

        const wizard = {
            hydrators: new Map(),
            validators: new Map(),
            collectors: new Map(),
        };

        window.contentWizard = window.contentWizard || {
            registerHydrator(step, fn) {
                wizard.hydrators.set(Number(step), fn);
            },
            registerValidator(step, fn) {
                wizard.validators.set(Number(step), fn);
            },
            registerCollector(step, fn) {
                wizard.collectors.set(Number(step), fn);
            },
            getCached(step) {
                return stepCache.get(Number(step)) ?? null;
            },
        };

        const jsonHeaders = {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        async function fetchJSON(path, options = {}) {
            const response = await fetch(path, {
                method: options.method ?? 'GET',
                headers: options.headers ?? (options.body ? jsonHeaders : {
                    'X-Requested-With': 'XMLHttpRequest'
                }),
                body: options.body ?? null,
            });

            const payload = await response.json().catch(() => ({}));
            if (!response.ok || (payload.status && !['ok', 'success'].includes(payload.status))) {
                const message = payload.error ?? payload.message ?? `HTTP ${response.status}`;
                throw new Error(message);
            }
            return payload;
        }

        function serializeForm(form) {
            if (!form) return {};
            const data = {};
            const formData = new FormData(form);

            for (const [rawKey, value] of formData.entries()) {
                const key = rawKey.endsWith('[]') ? rawKey.slice(0, -2) : rawKey;
                const current = data[key];

                if (current === undefined) {
                    data[key] = rawKey.endsWith('[]') ? [value] : value;
                } else if (Array.isArray(current)) {
                    current.push(value);
                } else {
                    data[key] = [current, value];
                }
            }

            Object.keys(data).forEach((key) => {
                const val = data[key];
                if (typeof val === 'string' && val.includes(',')) {
                    const split = val
                        .split(',')
                        .map((item) => item.trim())
                        .filter(Boolean);
                    if (split.length > 1) data[key] = split;
                }
            });

            return data;
        }

        function getCollector(step) {
            if (wizard.collectors.has(step)) {
                return wizard.collectors.get(step);
            }
            const form = document.getElementById(`step${step}_form`);
            return () => serializeForm(form);
        }

        function getValidator(step) {
            // Önce wizard.validators'dan kontrol et
            if (wizard.validators.has(step)) {
                console.log(`[Wizard] Step ${step} için wizard.validators'dan validator bulundu`);
                return wizard.validators.get(step);
            }

            // Sonra window'dan kontrol et
            const fn = window[`validateStep${step}`];
            if (typeof fn === 'function') {
                console.log(`[Wizard] Step ${step} için window.validateStep${step} bulundu`);
                return fn;
            }

            // Validator bulunamadı - uyarı ver ve güvenlik için false dön
            console.error(`[Wizard] ⚠️ UYARI: Step ${step} için validator tanımlı değil!`);
            console.error(`[Wizard] Güvenlik nedeniyle step geçişi engellenecek.`);
            return () => {
                alert(`Step ${step} için validasyon fonksiyonu bulunamadı. Lütfen sayfayı yenileyin.`);
                return false; // Güvenlik: Validator yoksa geçişe izin verme
            };
        }

        function getHydrator(step) {
            if (wizard.hydrators.has(step)) {
                return wizard.hydrators.get(step);
            }
            return null;
        }

        function toggleNextButtonLoading(isLoading) {
            if (!nextBtn) return;
            if (isLoading) {
                nextBtn.dataset.originalLabel = nextBtn.dataset.originalLabel ?? nextBtn.innerHTML;
                nextBtn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Kaydediliyor...';
                nextBtn.disabled = true;
            } else if (nextBtn.dataset.originalLabel) {
                nextBtn.innerHTML = nextBtn.dataset.originalLabel;
                delete nextBtn.dataset.originalLabel;
                nextBtn.disabled = false;
            }
        }

        function scrollToTop() {
            window.requestAnimationFrame(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        async function hydrateStep(step) {
            if (loadedSteps.has(step)) return;
            const url = `${API_BASE}/step-${step}`;
            try {
                const payload = await fetchJSON(url);
                loadedSteps.add(step);
                stepCache.set(step, payload);
                document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                    detail: {
                        step,
                        payload
                    }
                }));

                const hydrator = getHydrator(step);
                if (typeof hydrator === 'function') {
                    hydrator(payload);
                }
            } catch (error) {
                console.error(`[Wizard] Step ${step} hydrate failed`, error);
                alert(error.message ?? 'Adım verileri yüklenemedi.');
            }
        }

        async function submitStep(step) {
            const submitFn = window[`submitStep${step}`];
            if (typeof submitFn === 'function') {
                const result = await submitFn();
                stepCache.set(step, result);
                return result;
            }

            const collector = getCollector(step);
            const payload = collector ? collector() : {};
            const url = `${API_BASE}/step-${step}`;
            const response = await fetchJSON(url, {
                method: 'POST',
                body: JSON.stringify(payload)
            });
            stepCache.set(step, response);
            return response;
        }

        /*async function processCurrentStep() {
             return true;
         }*/


        async function processCurrentStep() { //validasyon için bu kısmın yorumdan çıkarılması üst taraftaki kısmın devre dışı bırakılması gerekiyor
            console.log(`[Wizard] Step ${currentStep} validation kontrolü yapılıyor...`);

            // Önce validation kontrolü yap
            const validator = getValidator(currentStep);
            console.log(`[Wizard] Validator bulundu:`, typeof validator);

            const isValid = await Promise.resolve(validator());
            console.log(`[Wizard] Validation sonucu:`, isValid);

            // Validation başarısız ise sonraki step'e geçme
            if (!isValid) {
                console.log(`[Wizard] Validation başarısız - step geçişi engellendi`);
                return false;
            }

            // Validation başarılı - şimdi kaydet
            toggleNextButtonLoading(true);
            try {
                await submitStep(currentStep);
                return true;
            } catch (error) {
                console.error(`[Wizard] Step ${currentStep} submit failed`, error);
                alert(error.message ?? 'Adım kaydedilemedi.');
                return false;
            } finally {
                toggleNextButtonLoading(false);
            }
        }

        function updateStepperUI() {
            stepperItems.forEach((item, index) => {
                const stepNumber = index + 1;
                const circle = item.querySelector('.shrink-0');
                const number = circle?.querySelector('[data-kt-stepper-number]');
                const checkIcon = circle?.querySelector('svg');
                const title = item.querySelector('h4');
                const subtitle = item.querySelector('span');

                circle?.classList.remove('kt-stepper-item-active', 'kt-stepper-item-completed');
                number?.classList.remove('hidden', 'text-white');
                checkIcon?.classList.add('hidden');
                checkIcon?.classList.remove('text-white');
                title?.classList.remove('text-blue-500');
                subtitle?.classList.remove('text-blue-500');

                if (stepNumber < currentStep) {
                    circle?.classList.add('kt-stepper-item-completed');
                    number?.classList.add('hidden');
                    checkIcon?.classList.remove('hidden');
                    checkIcon?.classList.add('text-white');
                    title?.classList.add('text-blue-500');
                    subtitle?.classList.add('text-blue-500');
                } else if (stepNumber === currentStep) {
                    circle?.classList.add('kt-stepper-item-active');
                    number?.classList.add('text-white');
                    title?.classList.add('text-blue-500');
                    subtitle?.classList.add('text-blue-500');
                }
            });

            stepperContents.forEach((content, index) => {
                const stepNumber = index + 1;
                if (stepNumber === currentStep) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });

            if (backBtn) {
                backBtn.classList.toggle('kt-stepper-first:hidden', currentStep === 1);
            }

            if (nextBtn) {
                if (currentStep === STEP_COUNT) {
                    nextBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = '';
                }
            }

            if (finalizeBtn) {
                if (currentStep === STEP_COUNT) {
                    finalizeBtn.style.display = 'inline-flex';
                } else {
                    finalizeBtn.style.display = 'none';
                }
            }
        }

        async function goToStep(step) {
            currentStep = Math.min(Math.max(step, 1), STEP_COUNT);
            await hydrateStep(currentStep);
            updateStepperUI();
            scrollToTop();
            if (currentStep === STEP_COUNT && typeof window.renderStepData === 'function') {
                try {
                    window.renderStepData();
                } catch (error) {
                    console.warn('[Wizard] renderStepData çağrısı sırasında sorun oluştu:', error);
                }
            }
        }

        async function handleNext(event) {
            console.log(`[Wizard] handleNext çağrıldı - currentStep: ${currentStep}`);
            event.preventDefault();
            event.stopImmediatePropagation();
            event.stopPropagation();
            if (currentStep > STEP_COUNT) return;

            const processResult = await processCurrentStep();
            console.log(`[Wizard] processCurrentStep sonucu:`, processResult);

            if (!processResult) {
                console.log(`[Wizard] processCurrentStep başarısız - step geçişi durduruldu`);
                return;
            }

            if (currentStep < STEP_COUNT) {
                console.log(`[Wizard] Step ${currentStep + 1}'e geçiliyor...`);
                await goToStep(currentStep + 1);
            } else {
                updateStepperUI();
                scrollToTop();
            }
        }

        function handleBack(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            event.stopPropagation();
            if (currentStep > 1) {
                currentStep -= 1;
                updateStepperUI();
                scrollToTop();
            }
        }

        stepperItems.forEach((item, index) => {
            item.addEventListener('click', async (event) => {
                event.preventDefault();
                event.stopImmediatePropagation();
                event.stopPropagation();
                const targetStep = index + 1;

                // Eğer ileri step'e geçmeye çalışıyorsa validation kontrolü yap
                if (targetStep > currentStep) {
                    // Mevcut step'i işle
                    if (!await processCurrentStep()) {
                        return;
                    }
                }

                await goToStep(targetStep);
            });
        });

        if (nextBtn) {
            const clonedNextBtn = nextBtn.cloneNode(true);
            nextBtn.replaceWith(clonedNextBtn);
            nextBtn = clonedNextBtn;
            nextBtn.addEventListener('click', handleNext);
        }

        backBtn?.addEventListener('click', handleBack);

        function showFinalizeSuccess(nextUrl) {
            if (!nextUrl) return;

            const containerId = 'pageAlertContainer';
            let container = document.getElementById(containerId);
            if (!container) {
                container = document.createElement('div');
                container.id = containerId;
                container.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 10000;
                    max-width: 360px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                `;
                document.body.appendChild(container);
            }

            const alertId = `finalize_alert_${Date.now()}`;
            const alert = document.createElement('div');
            alert.id = alertId;
            alert.className = 'kt-alert kt-alert-light kt-alert-success shadow-lg border border-green-100 animate-in fade-in slide-in-from-top-5';
            alert.style.cssText = 'transition: all 0.3s ease;';
            alert.innerHTML = `
                <div class="kt-alert-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle">
                        <path d="m9 12 2 2 4-4"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                </div>
                <div class="kt-alert-content">
                    <div class="kt-alert-title">İçerik başarıyla kaydedildi</div>
                    <div class="kt-alert-description">
                        İçerik detay sayfasına yönlendiriliyorsunuz.
                    </div>
                </div>
            `;

            container.appendChild(alert);

            let redirected = false;
            const cleanup = () => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                window.setTimeout(() => alert.remove(), 250);
            };

            const redirect = () => {
                if (redirected) return;
                redirected = true;
                cleanup();
                window.location.href = nextUrl;
            };

            window.setTimeout(redirect, 5000);
        }

        async function handleFinalizeClick(event) {
            event.preventDefault();
            if (!finalizeBtn) return;

            if (typeof validateStep5 === 'function') {
                const isValid = await Promise.resolve(validateStep5());
                if (!isValid) return;
            }

            const originalLabel = finalizeBtn.innerHTML;
            const getStepData = (step, fallback) => {
                if (typeof fallback === 'function') {
                    try {
                        const fresh = fallback();
                        if (fresh && typeof fresh === 'object') {
                            return fresh;
                        }
                    } catch (error) {
                        console.warn(`[Wizard] Step ${step} fallback toplayamadı:`, error);
                    }
                }

                const cached = stepCache.get(step);
                if (cached?.data) {
                    return cached.data;
                }
                if (cached && typeof cached === 'object') {
                    return cached;
                }
                return {};
            };

            const buildFinalizePayload = () => {
                const payload = {
                    meta: {
                        user_id: window?.AUTH_USER_ID ?? null
                    }, // varsa ekleyebilirsin
                    step1: getStepData(1, collectStep1Payload),
                    step2: getStepData(2, () => window.__contentStep2?.getPayload?.() ?? {
                        authors: []
                    }),
                    step3: getStepData(3, () => window.__contentStep3?.collect?.() ?? {
                        files: []
                    }),
                    step4: getStepData(4, collectStep4Payload),
                    step5: getStepData(5, collectStep5Payload),
                };

                payload.step3_uploads = payload.step3?.files ?? [];
                return payload;
            };

            finalizeBtn.disabled = true;
            finalizeBtn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Gönderiliyor...';

            try {
                if (typeof submitStep5 === 'function') {
                    await Promise.resolve(submitStep5());
                }

                const finalizePayload = buildFinalizePayload();

                const response = await fetch('/apps/add-material/finalize', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(finalizePayload),
                });


                let payload = null;
                try {
                    payload = await response.json();
                } catch (_) {
                    payload = null;
                }

                if (!response.ok || !payload || payload.status !== 'success') {
                    const message = payload?.error ||
                        payload?.debug ||
                        payload?.lastQuery ||
                        `İçeriği kaydederken bir sorun oluştu (HTTP ${response.status}).`;
                    alert(message);
                    return;
                }

                if (payload.next) {
                    showFinalizeSuccess(payload.next);
                    return;
                }

                alert('İçerik başarıyla kaydedildi, ancak yönlendirme bilgisi bulunamadı.');
            } catch (error) {
                alert(error?.message ?? 'Finalize işlemi sırasında beklenmeyen bir hata oluştu.');
            } finally {
                finalizeBtn.disabled = false;
                finalizeBtn.innerHTML = originalLabel;
            }
        }

        finalizeBtn?.addEventListener('click', handleFinalizeClick);

        document.addEventListener('content-wizard:hydrate', (event) => {
            const {
                step,
                payload
            } = event.detail ?? {};
            console.debug('[Wizard] Hydrated step', step, payload);

            // Step 5'e geçiş yapıldığında verileri render et
            if (step === 5 && window.renderStepData) {
                console.log('[Wizard] Step 5 verileri render ediliyor...');
                setTimeout(() => window.renderStepData(), 100);
            }
        });

        hydrateStep(1).finally(updateStepperUI);
    })();
</script>



<?= $this->endSection() ?>