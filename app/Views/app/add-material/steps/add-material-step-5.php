<div class="kt-container-fixed p-0">
    <form method="post" action="/app/add-material/step-5" enctype="multipart/form-data" id="step5_form" style="width: 100%;">
        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5">

            <!-- Önceki Adımların Detayları -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Önceki Adımların Detayları</h3>
                </div>
                <div class="kt-card-content py-3">
                    <div data-kt-accordion="true" data-kt-accordion-expand-all="false">

                        <!-- Step 1: Eğitim İçeriği Üst Verileri -->
                        <div class="kt-accordion-item not-last:border-b border-b-primary/20" data-kt-accordion-item="true">
                            <button aria-controls="step1_content" class="kt-accordion-toggle py-4" data-kt-accordion-toggle="#step1_content">
                                <span class="text-base text-mono">
                                    1. Eğitim İçeriği Üst Verileri
                                </span>
                                <span class="kt-accordion-active:hidden inline-flex">
                                    <i class="ki-filled ki-plus text-muted-foreground text-sm"></i>
                                </span>
                                <span class="kt-accordion-active:inline-flex hidden">
                                    <i class="ki-filled ki-minus text-muted-foreground text-sm"></i>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" id="step1_content">
                                <div class="text-secondary-foreground text-base pb-4">
                                    <!-- İçerik Türü ve Genel Bilgiler -->
                                    <div class="mb-6">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">İçerik Türü:</label>
                                                <p class="text-sm font-medium mt-1" id="step1_publication_type">Belirtilmedi</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Birinci Dil:</label>
                                                <p class="text-sm font-medium mt-1" id="step1_primary_language">Belirtilmedi</p>
                                            </div>
                                            <div class="mb-8">
                                                <label class="text-sm font-medium text-muted-foreground">Konular:</label>
                                                <p class="text-sm font-medium mt-1" id="step1_topics">Belirtilmedi</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Türkçe ve İngilizce Bilgiler Kartları -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Türkçe Bilgiler Kartı -->
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                                    <h4 class="kt-card-title">Türkçe Bilgiler</h4>
                                                </div>
                                            </div>
                                            <div class="kt-card-content">
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Başlık:</label>
                                                        <p class="text-sm font-medium mt-1" id="step1_title_tr">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Kısa Başlık:</label>
                                                        <p class="text-sm mt-1" id="step1_short_title_tr">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Anahtar Kelimeler:</label>
                                                        <p class="text-sm mt-1" id="step1_keywords_tr">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Öz:</label>
                                                        <p class="text-sm mt-1 leading-relaxed" id="step1_abstract_tr">Belirtilmedi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- İngilizce Bilgiler Kartı -->
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 bg-secondary rounded-full"></div>
                                                    <h4 class="kt-card-title">İngilizce Bilgiler</h4>
                                                </div>
                                            </div>
                                            <div class="kt-card-content">
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Başlık:</label>
                                                        <p class="text-sm font-medium mt-1" id="step1_title_en">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Kısa Başlık:</label>
                                                        <p class="text-sm mt-1" id="step1_short_title_en">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Anahtar Kelimeler:</label>
                                                        <p class="text-sm mt-1" id="step1_keywords_en">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Öz:</label>
                                                        <p class="text-sm mt-1 leading-relaxed" id="step1_abstract_en">Belirtilmedi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Katkıda Bulunanlar -->
                        <div class="kt-accordion-item not-last:border-b border-b-primary/20" data-kt-accordion-item="true">
                            <button aria-controls="step2_content" class="kt-accordion-toggle py-4" data-kt-accordion-toggle="#step2_content">
                                <span class="text-base text-mono">
                                    2. Katkıda Bulunanlar
                                </span>
                                <span class="kt-accordion-active:hidden inline-flex">
                                    <i class="ki-filled ki-plus text-muted-foreground text-sm"></i>
                                </span>
                                <span class="kt-accordion-active:inline-flex hidden">
                                    <i class="ki-filled ki-minus text-muted-foreground text-sm"></i>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" id="step2_content">
                                <div class="text-secondary-foreground text-base pb-4 space-y-6">
                                    <div class="mb-10">
                                        <h4 class="text-md font-semibold text-secondary mb-4">Sorumlu Katkıda Bulunan</h4>
                                        <div id="step2_responsible_container" class="space-y-3"></div>
                                    </div>
                                   <div class="mb-10">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-md font-semibold text-secondary">Diğer Katkıda Bulunanlar</h4>
                                            <span class="text-xs text-muted-foreground" id="step2_author_count"></span>
                                        </div>
                                        <div id="step2_authors_container" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                                        <p id="step2_authors_empty" class="text-sm text-muted-foreground">Henüz yazar eklenmedi.</p>
                                    </div>
                                   <div class="mb-10">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-md font-semibold text-secondary">Çevirmenler</h4>
                                            <span class="text-xs text-muted-foreground" id="step2_translator_count"></span>
                                        </div>
                                        <div id="step2_translators_container" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                                        <p id="step2_translators_empty" class="text-sm text-muted-foreground">Henüz çevirmen eklenmedi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Dosyalar -->
                        <div class="kt-accordion-item not-last:border-b border-b-primary/20" data-kt-accordion-item="true">
                            <button aria-controls="step3_content" class="kt-accordion-toggle py-4" data-kt-accordion-toggle="#step3_content">
                                <span class="text-base text-mono">
                                    3. Dosyalar
                                </span>
                                <span class="kt-accordion-active:hidden inline-flex">
                                    <i class="ki-filled ki-plus text-muted-foreground text-sm"></i>
                                </span>
                                <span class="kt-accordion-active:inline-flex hidden">
                                    <i class="ki-filled ki-minus text-muted-foreground text-sm"></i>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" id="step3_content">
                                <div class="text-secondary-foreground text-base pb-4 space-y-6">
                                    <div>
                                        <h4 class="text-md font-semibold text-secondary mb-4">Zorunlu Dosyalar</h4>
                                        <div id="step3_required_list" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                                        <p id="step3_required_empty" class="text-sm text-muted-foreground">Henüz zorunlu dosya yüklenmedi.</p>
                                    </div>
                                    <div>
                                        <h4 class="text-md font-semibold text-secondary mb-4">Ek Dosyalar</h4>
                                        <div id="step3_additional_list" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                                        <p id="step3_additional_empty" class="text-sm text-muted-foreground">Ek dosya yüklenmedi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Ek Bilgiler -->
                        <div class="kt-accordion-item not-last:border-b border-b-primary/20" data-kt-accordion-item="true">
                            <button aria-controls="step4_content" class="kt-accordion-toggle py-4" data-kt-accordion-toggle="#step4_content">
                                <span class="text-base text-mono">
                                    4. Ek Bilgiler
                                </span>
                                <span class="kt-accordion-active:hidden inline-flex">
                                    <i class="ki-filled ki-plus text-muted-foreground text-sm"></i>
                                </span>
                                <span class="kt-accordion-active:inline-flex hidden">
                                    <i class="ki-filled ki-minus text-muted-foreground text-sm"></i>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" id="step4_content">
                                <div class="text-secondary-foreground text-base pb-4">
                                    <!-- Proje Numarası -->
                                    <div class="mb-6">
                                        <div>
                                            <label class="text-sm font-medium text-muted-foreground">Proje Numarası:</label>
                                            <p class="text-sm font-medium mt-1" id="step4_project_number">Belirtilmedi</p>
                                        </div>
                                    </div>

                                    <!-- Türkçe ve İngilizce Ek Bilgiler Kartları -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Türkçe Ek Bilgiler Kartı -->
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                                    <h4 class="kt-card-title">Türkçe Ek Bilgiler</h4>
                                                </div>
                                            </div>
                                            <div class="kt-card-content">
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Etik Beyan:</label>
                                                        <p class="text-sm mt-1" id="step4_ethics_tr">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Destekleyen Kurum:</label>
                                                        <p class="text-sm mt-1" id="step4_supporting_tr">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Teşekkür:</label>
                                                        <p class="text-sm mt-1" id="step4_thanks_tr">Belirtilmedi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- İngilizce Ek Bilgiler Kartı -->
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 bg-secondary rounded-full"></div>
                                                    <h4 class="kt-card-title">İngilizce Ek Bilgiler</h4>
                                                </div>
                                            </div>
                                            <div class="kt-card-content">
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Etik Beyan:</label>
                                                        <p class="text-sm mt-1" id="step4_ethics_en">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Destekleyen Kurum:</label>
                                                        <p class="text-sm mt-1" id="step4_supporting_en">Belirtilmedi</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Teşekkür:</label>
                                                        <p class="text-sm mt-1" id="step4_thanks_en">Belirtilmedi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Eğitim İçeriği Kontrol Listesi -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Eğitim İçeriği Kontrol Listesi</h3>
                </div>
                <div class="kt-card-content py-3">
                    <div class="grid gap-5">
                        <label class="kt-checkbox-group" style="display: flex; align-items: center; gap: 6px;">
                            <input class="kt-checkbox" name="checklist[]" type="checkbox" value="required_info" />
                            <span class="kt-checkbox-label">
                                İlk sayfada gerekli bilgiler bulunmalıdır.
                            </span>
                        </label>

                        <label class="kt-checkbox-group" style="display: flex; align-items: center; gap: 6px;">
                            <input class="kt-checkbox" name="checklist[]" type="checkbox" value="author_approval" />
                            <span class="kt-checkbox-label">
                                Eğitim İçeriği gönderimi tüm içerik yazarları tarafından onaylanmalıdır.
                            </span>
                        </label>

                        <label class="kt-checkbox-group" style="display: flex; align-items: center; gap: 6px;">
                            <input class="kt-checkbox" name="checklist[]" type="checkbox" value="writing_rules" />
                            <span class="kt-checkbox-label">
                                Eğitim İçeriği yazım kurallarına dikkat edilerek yazılmış olmalıdır.
                            </span>
                        </label>

                        <div id="checklist-error" style="display: none; color: #dc2626; font-size: 0.875rem; font-style: italic;"></div>


                    </div>
                </div>
            </div>


            <!-- Editöre Notlar -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Editöre Notlar</h3>
                </div>
                <div class="kt-card-content py-3">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="kt-form-label max-w-56">
                            Editöre Notlar
                        </label>
                        <div class="grow">
                            <textarea class="kt-input" style="min-height: 80px !important;" name="editor_notes" rows="8" placeholder="Editöre iletmek istediğiniz özel notlar varsa buraya yazabilirsiniz (isteğe bağlı)"></textarea>
                            <div class="kt-form-description text-2sm mt-1">
                                Eğitim İçeriğiyle ilgili editöre özel bilgi vermek istiyorsanız bu alanı kullanabilirsiniz
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    // Accordion initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Metronic accordion initialization
        const accordionContainer = document.querySelector('[data-kt-accordion="true"]');
        if (accordionContainer) {
            const accordionItems = accordionContainer.querySelectorAll('[data-kt-accordion-item="true"]');

            accordionItems.forEach(function(item) {
                const toggle = item.querySelector('[data-kt-accordion-toggle]');
                const content = item.querySelector('.kt-accordion-content');
                const plusIcon = toggle.querySelector('.kt-accordion-active\\:hidden');
                const minusIcon = toggle.querySelector('.kt-accordion-active\\:inline-flex');

                if (toggle && content) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();

                        const isActive = item.classList.contains('kt-accordion-active');

                        if (isActive) {
                            // Close accordion
                            item.classList.remove('kt-accordion-active');
                            content.classList.add('hidden');
                            if (plusIcon) plusIcon.classList.remove('hidden');
                            if (plusIcon) plusIcon.classList.add('inline-flex');
                            if (minusIcon) minusIcon.classList.add('hidden');
                            if (minusIcon) minusIcon.classList.remove('inline-flex');
                        } else {
                            // Open accordion
                            item.classList.add('kt-accordion-active');
                            content.classList.remove('hidden');
                            if (plusIcon) plusIcon.classList.add('hidden');
                            if (plusIcon) plusIcon.classList.remove('inline-flex');
                            if (minusIcon) minusIcon.classList.remove('hidden');
                            if (minusIcon) minusIcon.classList.add('inline-flex');
                        }
                    });
                }
            });
        }
    });

    function showStep5Error(message) {
        const errorElement = document.getElementById('checklist-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function clearStep5Error() {
        const errorElement = document.getElementById('checklist-error');
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    function toggleChecklistWarning(show) {
        const warningDiv = document.getElementById('checklist_warning');
        if (!warningDiv) return;
        warningDiv.classList.toggle('hidden', !show);
        if (show) {
            warningDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    const updateRoot = document.getElementById('content_update_root');
    const IS_UPDATE_MODE = updateRoot?.dataset?.updateMode === '1';

    // Form gönderme kontrolü
    const step5Form = document.getElementById('step5_form');
    if (step5Form && !IS_UPDATE_MODE) {
        step5Form.addEventListener('submit', function(e) {
            clearStep5Error();
            const checkboxes = document.querySelectorAll('input[name="checklist[]"]:checked');

            if (checkboxes.length < 3) {
                e.preventDefault();
                showStep5Error('Eğitim İçeriği Kontrol Listesi\'ndeki tüm maddeleri işaretlemelisiniz.');
                toggleChecklistWarning(true);
                return false;
            }

            toggleChecklistWarning(false);
            const confirmation = confirm('Eğitim İçeriğiyi göndermek istediğinizden emin misiniz? Bu işlem geri alınamaz.');
            if (!confirmation) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    }

    // Checkbox durumunu kontrol et
    document.querySelectorAll('input[name="checklist[]"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            clearStep5Error();
            toggleChecklistWarning(false);
            const checkedCount = document.querySelectorAll('input[name="checklist[]"]:checked').length;
            const submitBtn = document.querySelector('button[type="submit"]');

            if (submitBtn) {
                if (checkedCount === 3) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('kt-btn-light');
                    submitBtn.classList.add('kt-btn-success');
                    toggleChecklistWarning(false);
                    clearStep5Error();
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.remove('kt-btn-success');
                    submitBtn.classList.add('kt-btn-light');
                }
            }
        });
    });

    // Sayfa yüklendiğinde submit butonunu devre dışı bırak
    if (!IS_UPDATE_MODE) {
        window.addEventListener('load', function() {
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.remove('kt-btn-success');
                submitBtn.classList.add('kt-btn-light');
            }
        });
    }
</script>
<script>
    (function () {
        function collectStep5Payload() {
            const form = document.getElementById('step5_form');
            if (!form) {
                return {
                    checklist: {
                        required_info: false,
                        author_approval: false,
                        writing_rules: false,
                    },
                    rules_ok: 'hayir',
                    all_authors_ok: 'hayir',
                    description: null,
                    editor_notes: null,
                };
            }

            const formData  = new FormData(form);
            const checklist = formData.getAll('checklist[]');
            const notesRaw  = (formData.get('description') ?? formData.get('editor_notes') ?? '')
                .toString()
                .trim();

            const flags = {
                required_info: checklist.includes('required_info'),
                author_approval: checklist.includes('author_approval'),
                writing_rules: checklist.includes('writing_rules'),
            };

            return {
                checklist: flags,
                rules_ok: flags.required_info && flags.writing_rules ? 'evet' : 'hayir',
                all_authors_ok: flags.author_approval ? 'evet' : 'hayir',
                description: notesRaw || null,
                editor_notes: notesRaw || null,
            };
        }

        function deriveChecklist(approvals) {
            const defaults = {
                required_info: false,
                author_approval: false,
                writing_rules: false,
            };

            if (!approvals || typeof approvals !== 'object') {
                return defaults;
            }

            if (approvals.checklist && typeof approvals.checklist === 'object') {
                Object.keys(defaults).forEach((key) => {
                    defaults[key] = Boolean(approvals.checklist[key]);
                });
                return defaults;
            }

            const normalizeFlag = (value) => {
                const normalized = String(value ?? '').trim().toLowerCase();
                return ['evet', 'true', '1', 'yes'].includes(normalized);
            };

            const rulesOk = normalizeFlag(approvals.rules_ok ?? approvals.rulesOk);
            const authorsOk = normalizeFlag(approvals.all_authors_ok ?? approvals.allAuthorsOk);

            if (rulesOk) {
                defaults.required_info = true;
                defaults.writing_rules = true;
            }
            if (authorsOk) {
                defaults.author_approval = true;
            }

            return defaults;
        }

        function refreshSubmitButtonState() {
            const checkedCount = document.querySelectorAll('input[name="checklist[]"]:checked').length;
            const submitBtn = document.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            if (checkedCount === 3) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('kt-btn-light');
                submitBtn.classList.add('kt-btn-success');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('kt-btn-success');
                submitBtn.classList.add('kt-btn-light');
            }
        }

        function hydrateStep5Form(approvals) {
            const flags = deriveChecklist(approvals);
            document.querySelectorAll('input[name="checklist[]"]').forEach((checkbox) => {
                const key = checkbox.value;
                checkbox.checked = Boolean(flags[key]);
            });

            const editorNotes = document.querySelector('textarea[name="editor_notes"]');
            if (editorNotes) {
                editorNotes.value = approvals?.description ?? approvals?.editor_notes ?? approvals?.notes ?? '';
            }

            clearStep5Error();
            toggleChecklistWarning(false);
            refreshSubmitButtonState();
        }

        function validateStep5() {
            const checkboxes = document.querySelectorAll('input[name="checklist[]"]:checked');
            if (checkboxes.length < 3) {
                showStep5Error('Eğitim İçeriği Kontrol Listesi\'ndeki tüm maddeleri işaretlemelisiniz.');
                toggleChecklistWarning(true);
                return false;
            }

            toggleChecklistWarning(false);
            clearStep5Error();
            return true;
        }

        const AUTHOR_ROLE_CONFIG = {
            responsible: { label: 'Sorumlu Katkıda Bulunan', badgeClass: 'bg-primary/10 text-primary', avatarBg: 'bg-primary/10', iconClass: 'text-primary' },
            author: { label: 'Katkıda Bulunan', badgeClass: 'bg-secondary/10 text-secondary', avatarBg: 'bg-secondary/10', iconClass: 'text-secondary' },
            translator: { label: 'Çevirmen', badgeClass: 'bg-info/10 text-info', avatarBg: 'bg-info/10', iconClass: 'text-info' },
        };

        const REQUIRED_FILE_LABELS = {
            full_text: 'Tam Metin',
            copyright_form: 'Telif Hakkı Formu',
        };

        const LANGUAGE_LABELS = {
            tr: 'Türkçe',
            en: 'İngilizce',
        };

        function resolvePublicationTypeLabel(data) {
            if (!data) return null;
            const directLabel = resolveFirst(data, [
                'publication_type_label',
                'content_type_name',
                'publication_type'
            ]);
            if (directLabel) return directLabel;

            const select = document.getElementById('publication_type');
            if (select) {
                const selectedOption = select.selectedOptions?.[0];
                const text = selectedOption?.textContent?.trim();
                if (text) return text;
            }

            return null;
        }

        function normalizeStepData(cache) {
            if (!cache) return null;
            if (cache.data) return cache.data;
            if (cache.payload) return cache.payload;
            if (cache.result) return cache.result;
            return cache;
        }

        function getLatestStepData(step, fallback) {
            const wizard = window.contentWizard;
            const cached = wizard?.getCached?.(step);
            const normalized = normalizeStepData(cached);
            if (normalized && Object.keys(normalized).length) {
                return normalized;
            }

            if (typeof fallback === 'function') {
                try {
                    const fallbackData = fallback();
                    if (fallbackData && Object.keys(fallbackData).length) {
                        return fallbackData;
                    }
                } catch (error) {
                    console.debug(`[Step 5] Fallback collector for step ${step} failed`, error);
                }
            }
            return normalized ?? null;
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function clean(value) {
            if (value === null || value === undefined) return '';
            return String(value).trim();
        }

        function fallbackText(value, empty = 'Belirtilmedi') {
            if (Array.isArray(value)) {
                const items = value
                    .map((item) => fallbackText(item, '').trim())
                    .filter(Boolean);
                return items.length ? items.join(', ') : empty;
            }
            if (typeof value === 'boolean') {
                return value ? 'Evet' : 'Hayır';
            }
            const cleaned = clean(value);
            return cleaned || empty;
        }

        function normalizeKeywords(value) {
            if (Array.isArray(value)) {
                return value.map((item) => clean(item)).filter(Boolean);
            }
            const cleaned = clean(value);
            if (!cleaned) return [];
            return cleaned.split(',').map((item) => item.trim()).filter(Boolean);
        }

        function normalizeTopics(value) {
            if (Array.isArray(value)) {
                return value
                    .map((item) => {
                        if (item && typeof item === 'object') {
                            return clean(item.label ?? item.name ?? item.title ?? '');
                        }
                        return clean(item);
                    })
                    .filter(Boolean);
            }
            const cleaned = clean(value);
            if (!cleaned) return [];
            return cleaned.split(',').map((item) => item.trim()).filter(Boolean);
        }

        function resolveFirst(source, keys) {
            if (!source) return null;
            for (const key of keys) {
                if (!key) continue;
                const value = source[key];
                if (Array.isArray(value) && value.length) return value;
                if (typeof value === 'boolean') return value;
                if (typeof value === 'number' && Number.isFinite(value) && value !== 0) return value;
                const cleaned = clean(value);
                if (cleaned) return value;
            }
            return null;
        }

        function setText(id, value, empty) {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = fallbackText(value, empty ?? 'Belirtilmedi');
        }

        function renderPlaceholder(container, message) {
            if (!container) return;
            container.innerHTML = `
                <div class="kt-card">
                    <div class="kt-card-content p-4">
                        <p class="text-sm text-muted-foreground">${escapeHtml(message)}</p>
                    </div>
                </div>`;
        }

        function buildDetailLine(icon, text) {
            const content = clean(text);
            if (!content) return '';
            return `
                <div class="flex items-center gap-2">
                    <i class="ki-filled ${icon} text-muted-foreground text-xs"></i>
                    <span class="text-xs text-muted-foreground">${escapeHtml(content)}</span>
                </div>`;
        }

        function renderAuthorCard(author, options = {}) {
            if (!author) return '';
            const roleKey = options.role
                || (author.type === 'translator' ? 'translator' : author.is_corresponding ? 'responsible' : 'author');
            const roleConfig = AUTHOR_ROLE_CONFIG[roleKey] ?? AUTHOR_ROLE_CONFIG.author;
            const fullName = fallbackText([author.first_name, author.last_name].filter(Boolean).join(' '));
            const orderLabel = typeof options.order === 'number'
                ? `<span class="text-xs text-muted-foreground">#${escapeHtml(String(options.order))}</span>`
                : '';

            const emailLine = buildDetailLine('ki-sms', author.email);
            const affiliationLine = buildDetailLine('ki-briefcase', author.affiliation);
            const orcidLine = buildDetailLine('ki-code', author.orcid ? `ORCID: ${author.orcid}` : '');
            const detailsHtml = [emailLine, affiliationLine, orcidLine].filter(Boolean).join('') || `
                <p class="text-xs text-muted-foreground">Ek bilgi girilmemiş.</p>`;

            return `
                <div class="kt-card">
                    <div class="kt-card-content p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 ${roleConfig.avatarBg} rounded-full flex items-center justify-center">
                                <i class="ki-filled ki-user ${roleConfig.iconClass} text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h5 class="text-sm font-semibold text-secondary">${escapeHtml(fullName)}</h5>
                                    <span class="px-2 py-1 rounded-full text-xs ${roleConfig.badgeClass}">${escapeHtml(roleConfig.label)}</span>
                                    ${orderLabel}
                                </div>
                                <div class="space-y-1">
                                    ${detailsHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function formatSize(bytes) {
            const size = Number(bytes);
            if (!Number.isFinite(size) || size <= 0) return '';
            if (size >= 1024 * 1024) return `${(size / (1024 * 1024)).toFixed(2)} MB`;
            if (size >= 1024) return `${(size / 1024).toFixed(2)} KB`;
            return `${size} B`;
        }

        function resolveRequiredKeyFromFile(file) {
            if (!file) return null;
            if (file.role && REQUIRED_FILE_LABELS[file.role]) return file.role;
            if (file.role) {
                const normalized = String(file.role).replace(/-/g, '_');
                if (REQUIRED_FILE_LABELS[normalized]) return normalized;
            }
            if (file.key && REQUIRED_FILE_LABELS[file.key]) return file.key;
            return null;
        }

        function renderFileCard(file, options = {}) {
            if (!file) return '';
            const label = options.label ?? fallbackText(file.name, 'Dosya');
            const name = fallbackText(file.name, 'Dosya adı belirtilmedi');
            const sizeLabel = formatSize(file.size);
            const notes = clean(options.description ?? file.notes);
            const iconClass = options.iconClass ?? 'text-primary';
            const bubbleClass = options.bubbleClass ?? 'bg-primary/10';

            return `
                <div class="kt-card">
                    <div class="kt-card-content">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 ${bubbleClass} rounded-lg flex items-center justify-center">
                                <i class="ki-filled ki-file-down ${iconClass} text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-sm font-semibold text-secondary">${escapeHtml(label)}</h5>
                                <p class="text-xs text-muted-foreground">${escapeHtml(name)}</p>
                                ${sizeLabel ? `<p class="text-xs text-muted-foreground">${escapeHtml(sizeLabel)}</p>` : ''}
                                ${notes ? `<p class="text-xs text-muted-foreground">${escapeHtml(notes)}</p>` : ''}
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-xs text-green-600 font-medium">Yüklendi</span>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function gatherFiles(data) {
            if (!data) return [];
            const files = [];
            if (Array.isArray(data.files)) {
                files.push(...data.files);
            }
            if (Array.isArray(data.required)) {
                files.push(...data.required);
            } else if (data.required && typeof data.required === 'object') {
                Object.values(data.required).forEach((file) => file && files.push(file));
            }
            if (Array.isArray(data.additional)) {
                files.push(...data.additional);
            }
            return files;
        }

        function renderStep1Data(data) {
            const ids = [
                'step1_publication_type',
                'step1_primary_language',
                'step1_topics',
                'step1_title_tr',
                'step1_short_title_tr',
                'step1_keywords_tr',
                'step1_abstract_tr',
                'step1_title_en',
                'step1_short_title_en',
                'step1_keywords_en',
                'step1_abstract_en',
            ];

            if (!data) {
                ids.forEach((id) => setText(id, null));
                return;
            }

            const publicationValue = resolvePublicationTypeLabel(data);
            setText('step1_publication_type', publicationValue);

            const languageValue = resolveFirst(data, ['primary_language_label', 'primary_language']);
            const languageKey = clean(languageValue).toLowerCase();
            const languageLabel = LANGUAGE_LABELS[languageKey] ?? fallbackText(languageValue);
            setText('step1_primary_language', languageLabel);

            const topicsValue = resolveFirst(data, ['topics_labels', 'topics_names', 'topics']);
            const topicsList = normalizeTopics(topicsValue);
            setText('step1_topics', topicsList.length ? topicsList.join(', ') : null);

            setText('step1_title_tr', data.title_tr);
            setText('step1_short_title_tr', data.short_title_tr);
            const keywordsTr = normalizeKeywords(resolveFirst(data, ['keywords_tr', 'keywords_tr_list']));
            setText('step1_keywords_tr', keywordsTr.length ? keywordsTr.join(', ') : null);
            setText('step1_abstract_tr', data.abstract_tr);

            setText('step1_title_en', data.title_en);
            setText('step1_short_title_en', data.short_title_en);
            const keywordsEn = normalizeKeywords(resolveFirst(data, ['keywords_en', 'keywords_en_list']));
            setText('step1_keywords_en', keywordsEn.length ? keywordsEn.join(', ') : null);
            setText('step1_abstract_en', data.abstract_en);
        }

        function renderStep2Data(data) {
            const responsibleContainer = document.getElementById('step2_responsible_container');
            const authorsContainer = document.getElementById('step2_authors_container');
            const translatorsContainer = document.getElementById('step2_translators_container');
            const authorsEmpty = document.getElementById('step2_authors_empty');
            const translatorsEmpty = document.getElementById('step2_translators_empty');
            const authorCount = document.getElementById('step2_author_count');
            const translatorCount = document.getElementById('step2_translator_count');

            if (responsibleContainer) responsibleContainer.innerHTML = '';
            if (authorsContainer) authorsContainer.innerHTML = '';
            if (translatorsContainer) translatorsContainer.innerHTML = '';
            if (authorCount) authorCount.textContent = '';
            if (translatorCount) translatorCount.textContent = '';
            if (authorsEmpty) authorsEmpty.classList.remove('hidden');
            if (translatorsEmpty) translatorsEmpty.classList.remove('hidden');

            const authors = Array.isArray(data?.authors) ? data.authors : [];
            if (!authors.length) {
                renderPlaceholder(responsibleContainer, 'Henüz sorumlu yazar eklenmedi.');
                return;
            }

            const sorted = [...authors].sort((a, b) => (a.order ?? 999) - (b.order ?? 999));
            const responsible = sorted.find((author) => author.type !== 'translator' && author.is_corresponding)
                || sorted.find((author) => author.type !== 'translator');

            if (responsible && responsibleContainer) {
                responsibleContainer.innerHTML = renderAuthorCard(responsible, { role: 'responsible', order: responsible.order });
            } else {
                renderPlaceholder(responsibleContainer, 'Henüz sorumlu yazar eklenmedi.');
            }

            const others = sorted.filter((author) => author !== responsible && author.type !== 'translator');
            if (authorsContainer && others.length) {
                authorsContainer.innerHTML = others
                    .map((author) => renderAuthorCard(author, { role: 'author', order: author.order }))
                    .join('');
                if (authorsEmpty) authorsEmpty.classList.add('hidden');
                if (authorCount) authorCount.textContent = `${others.length} yazar`;
            }

            const translators = sorted.filter((author) => author.type === 'translator');
            if (translatorsContainer && translators.length) {
                translatorsContainer.innerHTML = translators
                    .map((author, index) => renderAuthorCard(author, { role: 'translator', order: author.order ?? index + 1 }))
                    .join('');
                if (translatorsEmpty) translatorsEmpty.classList.add('hidden');
                if (translatorCount) translatorCount.textContent = `${translators.length} çevirmen`;
            }
        }

        function renderStep3Data(data) {
            const requiredList = document.getElementById('step3_required_list');
            const requiredEmpty = document.getElementById('step3_required_empty');
            const additionalList = document.getElementById('step3_additional_list');
            const additionalEmpty = document.getElementById('step3_additional_empty');

            if (requiredList) requiredList.innerHTML = '';
            if (additionalList) additionalList.innerHTML = '';
            if (requiredEmpty) requiredEmpty.classList.remove('hidden');
            if (additionalEmpty) additionalEmpty.classList.remove('hidden');

            const files = gatherFiles(data);
            if (!files.length) {
                return;
            }

            const requiredFiles = [];
            const additionalFiles = [];
            const seen = new Set();

            files.forEach((file) => {
                if (!file) return;
                const key = resolveRequiredKeyFromFile(file);
                const identifier = file.client_id || file.temp_id || file.stored_path || `${file.role}-${file.name}`;
                if (identifier && seen.has(identifier)) return;
                if (identifier) seen.add(identifier);

                if (key) {
                    requiredFiles.push({ file, key });
                } else {
                    additionalFiles.push(file);
                }
            });

            if (requiredFiles.length && requiredList) {
                requiredList.innerHTML = requiredFiles
                    .map(({ file, key }) => renderFileCard(file, {
                        label: REQUIRED_FILE_LABELS[key] ?? 'Zorunlu Dosya',
                        iconClass: key === 'copyright_form' ? 'text-secondary' : 'text-primary',
                        bubbleClass: key === 'copyright_form' ? 'bg-secondary/10' : 'bg-primary/10',
                    }))
                    .join('');
                if (requiredEmpty) requiredEmpty.classList.add('hidden');
            }

            if (additionalFiles.length && additionalList) {
                additionalList.innerHTML = additionalFiles
                    .map((file) => renderFileCard(file, {
                        label: fallbackText(resolveFirst(file, ['label', 'role', 'type']), fallbackText(file.name, 'Ek Dosya')),
                        iconClass: 'text-muted-foreground',
                        bubbleClass: 'bg-muted/10',
                        description: file.notes,
                    }))
                    .join('');
                if (additionalEmpty) additionalEmpty.classList.add('hidden');
            }
        }

        function renderStep4Data(data) {
            setText('step4_project_number', data?.project_number);

            const rows = Array.isArray(data?.rows) ? data.rows : [];
            const mapped = {};
            rows.forEach((row) => {
                const lang = clean(row?.lang ?? row?.language).toLowerCase();
                if (!lang) return;
                mapped[lang] = row;
            });

            const turkish = mapped.tr ?? {};
            const english = mapped.en ?? {};

            setText('step4_ethics_tr', turkish.ethics_declaration ?? turkish.ethics_statement);
            setText('step4_supporting_tr', turkish.supporting_institution);
            setText('step4_thanks_tr', turkish.thanks_description ?? turkish.acknowledgments);

            setText('step4_ethics_en', english.ethics_declaration ?? english.ethics_statement);
            setText('step4_supporting_en', english.supporting_institution);
            setText('step4_thanks_en', english.thanks_description ?? english.acknowledgments);
        }

        function renderStepData() {
            const wizard = window.contentWizard;
            if (!wizard) return;

            renderStep1Data(getLatestStepData(1, () => window.collectStep1Payload?.() ?? {}));
            renderStep2Data(getLatestStepData(2, () => window.__contentStep2?.getPayload?.() ?? {}));
            renderStep3Data(getLatestStepData(3, () => window.__contentStep3?.collect?.() ?? {}));
            renderStep4Data(getLatestStepData(4, () => window.collectStep4Payload?.() ?? {}));
        }

        function registerWithWizard() {
            if (!window.contentWizard) {
                console.warn('[Step 5] contentWizard henüz hazır değil, bekleniyor...');
                setTimeout(registerWithWizard, 100);
                return;
            }

            window.contentWizard.registerCollector(5, collectStep5Payload);
            window.contentWizard.registerValidator(5, validateStep5);
            
            // Verileri render et
            renderStepData();
        }

        // Global olarak da tanımla (fallback için)
        window.collectStep5Payload = collectStep5Payload;
        window.validateStep5 = validateStep5;
        window.renderStepData = renderStepData;
        window.__contentStep5 = {
            hydrate: (payload) => hydrateStep5Form(payload),
            collect: () => collectStep5Payload(),
            validate: () => validateStep5(),
            load: () => Promise.resolve(),
            submit: () => {
                if (!validateStep5()) {
                    return Promise.reject(new Error('Validasyon hatası'));
                }
                return Promise.resolve({ status: 'ok' });
            },
        };

        document.addEventListener('content-wizard:hydrate', (event) => {
            const step = event?.detail?.step;
            if ([1, 2, 3, 4].includes(step)) {
                renderStepData();
            }
        });

        document.addEventListener('content-wizard:step1-publication-change', () => {
            renderStepData();
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            registerWithWizard();
            if (IS_UPDATE_MODE) {
                const cached = window.contentWizard?.getCached?.(5);
                if (cached) {
                    hydrateStep5Form(cached.data ?? cached.payload ?? cached);
                }
            }
        });

        // Eğer sayfa zaten yüklenmişse hemen çalıştır
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            registerWithWizard();
            if (IS_UPDATE_MODE) {
                const cached = window.contentWizard?.getCached?.(5);
                if (cached) {
                    hydrateStep5Form(cached.data ?? cached.payload ?? cached);
                }
            }
        }
    })();
</script>
