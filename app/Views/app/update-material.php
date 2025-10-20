<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>
<?php
// $learning_material_id bu view’e controller’dan gönderilmeli.
?>
<div class="kt-container-fixed grow pb-5" id="content_update_root"
    data-content-id="<?= esc($learningMaterialId ?? $learning_material_id ?? 0) ?>" data-update-mode="1">


    <form action="#" method="post">
        <div data-kt-stepper="true">
            <div class="kt-card">
                <div class="kt-card-header h-auto px-10 py-5">
                    <div data-kt-stepper-item="#stepper_1" class="active flex gap-2.5 items-center">
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
                        <div class="flex flex-col gap-0.5">
                            <h4
                                class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                Temel Bilgiler
                            </h4>
                            <span
                                class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Eğitim İçeriği
                                temel bilgileri</span>
                        </div>
                    </div>
                    <div data-kt-stepper-item="#stepper_2" class="flex gap-2.5 items-center">
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
                        <div class="flex flex-col gap-0.5">
                            <h4
                                class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                Katkıda Bulunanlar
                            </h4>
                            <span
                                class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Katkıda Bulunan
                                bilgileri</span>
                        </div>
                    </div>
                    <div data-kt-stepper-item="#stepper_3" class="flex gap-2.5 items-center">
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
                        <div class="flex flex-col gap-0.5">
                            <h4
                                class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                Ek Dosyalar
                            </h4>
                            <span
                                class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Dosya
                                yükleme</span>
                        </div>
                    </div>
                    <div data-kt-stepper-item="#stepper_4" class="flex gap-2.5 items-center">
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
                        <div class="flex flex-col gap-0.5">
                            <h4
                                class="text-sm font-medium text-mono kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">
                                Özet ve Anahtar Kelimeler
                            </h4>
                            <span
                                class="text-sm text-muted-foreground kt-stepper-item-active:!text-blue-500 kt-stepper-item-completed:!text-blue-500 kt-stepper-item-completed:opacity-70">Eğitim İçeriği
                                özeti</span>
                        </div>
                    </div>
                    <div data-kt-stepper-item="#stepper_5" class="flex gap-2.5 items-center">
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
                        <div class="flex flex-col gap-0.5">
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
                <div class="kt-card-content px-5 py-20">
                    <div class="" id="stepper_1">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/updateSteps/update-material-step-1') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_2">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/updateSteps/update-material-step-2') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_3">
                        <div class="space-y -6">
                            <?= $this->include('app/add-material/updateSteps/update-material-step-3') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_4">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/updateSteps/update-material-step-4') ?>
                        </div>
                    </div>
                    <div class="hidden" id="stepper_5">
                        <div class="space-y-6">
                            <?= $this->include('app/add-material/updateSteps/update-material-step-5') ?>
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
                        <button type="button" class="kt-btn kt-btn-primary kt-stepper-last:hidden"
                            data-kt-stepper-next="true">
                            İleri<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        <button type="button" class="kt-btn kt-btn-success hidden kt-stepper-last:inline-flex"
                            id="finalize_button">
                            Eğitim İçeriğini Gönder
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Mevcut modalların aynısı gerekiyorsa tekrar include edebilirsin -->
<?= $this->include('app/modals/add-author-modal') ?>
<?= $this->include('app/modals/add-file-modal') ?>
<?= $this->include('app/modals/required-file-modal') ?>
<script>
    (() => {
        const init = () => {
            const root = document.getElementById('content_update_root');
            if (!root) return;

            const CONTENT_ID = Number(root.dataset?.learningMaterialId ?? 0) || 0;
            const STEP_COUNT = 5;

            const items = document.querySelectorAll('[data-kt-stepper-item]');
            const views = Array.from({ length: STEP_COUNT }, (_, idx) => document.getElementById(`stepper_${idx + 1}`));
            const backBtn = document.querySelector('[data-kt-stepper-back]');
            let nextBtn = document.querySelector('[data-kt-stepper-next]');
            const finalizeBtn = document.getElementById('finalize_button');

            let currentStep = 1;

            const ensureContentId = () => {
                if (window.contentUpdate && CONTENT_ID && !window.contentUpdate.learningMaterialId) {
                    window.contentUpdate.learningMaterialId = CONTENT_ID;
                }
            };

            const hydrateInitialData = () => {
                if (!window.contentUpdate) {
                    console.error('[ContentUpdate] contentUpdate yöneticisi bulunamadı.');
                    return;
                }

                ensureContentId();

                const initialData = <?= isset($initialData) ? json_encode($initialData, JSON_UNESCAPED_UNICODE) : 'null' ?>;
                if (initialData) {
                    window.contentUpdate.setInitialPayload(initialData);
                } else if (CONTENT_ID && !window.contentUpdate.getInitialPayload()) {
                    window.contentUpdate.bootstrap({ learningMaterialId: CONTENT_ID }).catch((error) => {
                        console.error('[ContentUpdate] İlk veriler yüklenemedi', error);
                    });
                }
            };

            const dispatchStepHydrate = (step) => {
                document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                    detail: { step }
                }));
            };

            const updateHeaderState = () => {
                items.forEach((item, index) => {
                    const circle = item.querySelector('.shrink-0');
                    const number = circle?.querySelector('[data-kt-stepper-number]');
                    const check = circle?.querySelector('svg');
                    const step = index + 1;

                    circle?.classList.remove('kt-stepper-item-active', 'kt-stepper-item-completed');
                    number?.classList.remove('hidden', 'text-white');
                    check?.classList.add('hidden');

                    if (step < currentStep) {
                        circle?.classList.add('kt-stepper-item-completed');
                        number?.classList.add('hidden');
                        check?.classList.remove('hidden');
                    } else if (step === currentStep) {
                        circle?.classList.add('kt-stepper-item-active');
                        number?.classList.add('text-white');
                    }
                });

                views.forEach((view, index) => {
                    if (!view) return;
                    view.classList.toggle('hidden', index + 1 !== currentStep);
                });

                if (backBtn) {
                    backBtn.classList.toggle('kt-stepper-first:hidden', currentStep === 1);
                }
                if (nextBtn) {
                    nextBtn.classList.toggle('kt-stepper-last:hidden', currentStep === STEP_COUNT);
                }
                if (finalizeBtn) {
                    finalizeBtn.classList.toggle('hidden', currentStep !== STEP_COUNT);
                }
            };

            const goToStep = (step) => {
                const bounded = Math.max(1, Math.min(STEP_COUNT, step));
                if (bounded === currentStep) return;
                currentStep = bounded;
                updateHeaderState();
                dispatchStepHydrate(currentStep);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };

            const handleNext = (event) => {
                event.preventDefault();
                if (currentStep >= STEP_COUNT) return;
                goToStep(currentStep + 1);
            };

            const handleBack = (event) => {
                event.preventDefault();
                if (currentStep <= 1) return;
                goToStep(currentStep - 1);
            };

            const handleFinalize = async (event) => {
                event.preventDefault();
                if (!window.contentUpdate) return;

                const button = event.currentTarget;
                button.disabled = true;

                const originalLabel = button.innerHTML;
                button.dataset.originalLabel = originalLabel;
                button.innerHTML = 'Kaydediliyor...';

                try {
                    const response = await window.contentUpdate.submit({ learningMaterialId: CONTENT_ID });
                    alert('Eğitim içeriği başarıyla güncellendi.');
                    if (response?.next) {
                        window.location.href = response.next;
                    }
                } catch (error) {
                    console.error('[ContentUpdate] Güncelleme başarısız', error);
                    alert(error?.message ?? 'Güncelleme sırasında hata oluştu.');
                } finally {
                    button.innerHTML = button.dataset.originalLabel ?? 'Kaydet';
                    button.disabled = false;
                }
            };

            items.forEach((item, index) => {
                item.addEventListener('click', (event) => {
                    event.preventDefault();
                    goToStep(index + 1);
                });
            });

            if (nextBtn) {
                const clone = nextBtn.cloneNode(true);
                nextBtn.replaceWith(clone);
                nextBtn = clone;
                nextBtn.addEventListener('click', handleNext);
            }

            backBtn?.addEventListener('click', handleBack);
            finalizeBtn?.addEventListener('click', handleFinalize);

            hydrateInitialData();
            updateHeaderState();
            dispatchStepHydrate(currentStep);

            document.addEventListener('content-update:hydrated', () => {
                if (currentStep === STEP_COUNT && typeof window.renderStepData === 'function') {
                    window.renderStepData();
                }
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>

<?= $this->endSection() ?>