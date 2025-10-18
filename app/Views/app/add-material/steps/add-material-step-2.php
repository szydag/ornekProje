<div class="kt-container-fixed p-0">
    <style>
        #responsibleRequiredBanner {
            border-color: rgba(245, 158, 11, 0.4);
            background-color: rgba(245, 158, 11, 0.08);
        }

        #responsibleRequiredBanner svg {
            color: #d97706;
        }
    </style>
    <!-- Form Content - Step 2 -->
    <form method="post" action="#" enctype="multipart/form-data" id="step2_form" style="width: 100%;">
        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5 w-full max-w-full px-1 sm:px-4 sm:max-w-4xl sm:mx-auto overflow-x-hidden">

            <!-- Step 2: Katkıda Bulunanlar -->
            <div class="kt-card pb-2.5">
                <div class="kt-card-header" id="step_2">
                    <h3 class="kt-card-title">
                        2. Katkıda Bulunanlar
                    </h3>
                </div>
                <div class="kt-card-content grid gap-3 sm:gap-5">
                    <div class="flex flex-col gap-3">

                        <div class="bg-blue-50 rounded-lg p-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div class="flex-shrink-0">
                                <div class="p-1 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="ki-filled ki-information-2 text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="text-gray-700 text-sm leading-relaxed">
                                Eğitim İçeriğiyi gönderen kişi sorumlu yazar olarak otomatik eklenir. Başka yazar eklemek için
                                bu alanı kullanabilirsiniz. Ekleyeceğiniz e-posta sistemde kayıtlı ise yazar ekranı size
                                açılacaktır. Kayıtlı değilse sizin ekleyeceğiniz e-posta adresine onay bildirimi
                                gidecek, yazar kabul ettiğinde içerik dergiye gönderilecektir.
                            </div>
                        </div>

                        <!-- Validation Error Display -->
                        <div id="authors-error" style="display: none; color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"></div>

                        <!-- Katkıda Bulunanlar Listesi -->
                        <div class="space-y-3 sm:space-y-4">
                            <!-- Sorumlu Katkıda Bulunan Kartı -->
                            <!-- Sorumlu Katkıda Bulunan -->
                            <div class="space-y-4">
                                <div id="responsible_author_card" class="space-y-4"></div>
                                        </div>

                            <!-- Diğer Katkıda Bulunanlar -->
                            <div id="authors_container" class="mt-3 sm:mt-5 space-y-3 sm:space-y-4"></div>

                        </div>

                        <!-- Katkıda Bulunan Ekleme -->
                        <div class="flex w-full flex-col gap-2.5 sm:flex-row sm:items-center sm:gap-2.5 mt-5 min-w-0">
                            <div class="w-full" style="width: 100%;">
                                <input class="kt-input w-full" name="author_email" type="email" style="width: 100%;"
                                    placeholder="Eklenecek Katkıda Bulunan E-Postası" />
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="kt-btn kt-btn-outline primary"
                                    data-kt-modal-toggle="#add_author_modal" data-author-type="author">
                                    <i class="ki-filled ki-profile-user me-1" style="color: #10b981;"></i>
                                    <span class="sm:hidden">Ekle</span>
                                    <span class="hidden sm:inline">Katkıda Bulunan Ekle</span>
                                </button>
                            </div>
                        </div>

                        <!-- Çeviri Katkıda Bulunanları (Çeviri seçildiğinde görünür) -->
                        <!-- Çeviri Katkıda Bulunanları -->
                        <!-- UNUTMAA -->
                        <div id="translation_authors" class="<?= "hidden" ? '' : 'hidden' ?> mt-5">
                            <div class="kt-card">
                                <div class="kt-card-header">
                                    <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-between min-w-0" style="display: flex; flex-direction: row; justify-content: space-between;">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                            <div
                                                class="flex size-10 items-center justify-center self-start rounded-full bg-info text-white sm:self-auto">
                                                <i class="ki-filled ki-translate text-sm"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <h4 class="kt-card-title text-sm">Çeviri Katkıda Bulunanları</h4>
                                                <p class="text-xs text-muted-foreground">Henüz çevirmen eklenmedi</p>
                                            </div>
                                        </div>
                                        <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-secondary"
                                            id="translator_count">
                                            0 Çevirmen
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Çevirmen Ekleme -->
                            <div class="flex w-full flex-col gap-2.5 sm:flex-row sm:items-center sm:gap-2.5 mt-3 min-w-0" style="display: flex; flex-direction: row; justify-content: space-between;">
                                <div class="flex-1 min-w-0 w-full sm:w-auto">
                                    <input class="kt-input w-full" name="translator_email" type="email"
                                        placeholder="Eklenecek Çevirmen E-Postası" />
                                </div>
                                <div class="flex-shrink-0 w-full sm:w-auto">
                                    <button type="button" class="kt-btn kt-btn-outline sm:w-auto"
                                        data-kt-modal-toggle="#add_author_modal" data-author-type="translator">
                                        <i class="ki-filled ki-plus text-sm"></i>
                                        <span class="sm:hidden">Ekle</span>
                                        <span class="hidden sm:inline">Çevirmen Ekle</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Yeni Eklenen Çevirmenler -->
                            <div id="translators_container" class="mt-3 space-y-3">
                                <!-- Yeni eklenen çevirmenler buraya kart olarak eklenecek -->
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
        const API_URL = '/apps/add-material/step-2';

        const state = {
            authors: [],
            modal: { mode: 'create', index: null, type: 'author' },
        };

        const dom = {
            form: document.getElementById('step2_form'),
            responsible: document.getElementById('responsible_author_card'),
            authors: document.getElementById('authors_container'),
            translators: document.getElementById('translators_container'),
            translatorCount: document.getElementById('translator_count'),
            translationBlock: document.getElementById('translation_authors'),
            addModal: document.getElementById('add_author_modal'),
            addModalTitle: document.getElementById('author_modal_title'),
            editModal: document.getElementById('edit_author_modal'),
            addModalInstance: null,
        };

        const jsonHeaders = {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        function clean(value) {
            if (value === null || value === undefined) return '';
            return String(value).trim();
        }

        const RESPONSIBLE_REQUIRED_FIELDS = [
            {
                key: 'affiliation',
                label: 'Kurum',
                selector: '[data-responsible-field="institution"]',
                isMissing: (author) => {
                    const value = clean(author.affiliation ?? author.affiliation_id ?? '');
                    return !value || value.toLowerCase() === 'kurum yok';
                },
            },
            {
                key: 'country',
                label: 'Ülke',
                selector: '[data-responsible-field="country"]',
                isMissing: (author) => {
                    const country = clean(author.country ?? '');
                    const countryCode = clean(author.country_code ?? author.country_id ?? '');
                    return !country && !countryCode;
                },
            },
            {
                key: 'orcid',
                label: 'ORCID',
                selector: '[data-responsible-field="orcid"]',
                isMissing: (author) => !clean(author.orcid ?? ''),
            },
            {
                key: 'phone',
                label: 'Telefon',
                selector: '[data-responsible-field="phone"]',
                isMissing: (author) => !clean(author.phone ?? ''),
            },
            {
                key: 'city',
                label: 'Şehir',
                selector: '[data-responsible-field="city"]',
                isMissing: (author) => !clean(author.city ?? ''),
            },
        ];

        function getMissingResponsibleFields(author) {
            if (!author) return [];
            return RESPONSIBLE_REQUIRED_FIELDS.filter((field) => {
                try {
                    return field.isMissing(author);
                } catch (error) {
                    console.warn('[Step2] Missing field check failed', field, error);
                    return false;
                }
            });
        }

        function formatMissingFieldList(fields) {
            if (!fields?.length) return '';
            const labels = fields.map((field) => field.label).filter(Boolean);
            if (!labels.length) return '';
            if (labels.length === 1) return labels[0];
            return `${labels.slice(0, -1).join(', ')} ve ${labels.at(-1)}`;
        }

        function normalizeStep1Data() {
            const cache = window.contentWizard?.getCached(1);
            if (!cache) return null;
            return cache.data ?? cache ?? null;
        }

        function isTranslationPublication() {
            const data = normalizeStep1Data();
            if (!data) return false;
            if (typeof data.is_translation_publication === 'boolean') {
                return data.is_translation_publication;
            }
            const label = clean(data.publication_type_label ?? data.content_type_name ?? data.publication_type ?? '');
            if (label) {
                const lowered = label.toLowerCase();
                if (lowered.includes('çeviri') || lowered.includes('ceviri') || lowered.includes('translation')) {
                    return true;
                }
            }
            const slug = clean(data.publication_type_slug ?? data.publication_type_code ?? data.publication_type_key ?? '');
            if (slug) {
                const loweredSlug = slug.toLowerCase();
                if (loweredSlug.includes('translation') || loweredSlug.includes('ceviri') || loweredSlug.includes('çeviri')) {
                    return true;
                }
            }
            const select = document.getElementById('publication_type');
            if (select) {
                const optionLabel = select.selectedOptions?.[0]?.textContent?.trim().toLowerCase() ?? '';
                if (optionLabel.includes('çeviri') || optionLabel.includes('ceviri') || optionLabel.includes('translation')) {
                    return true;
                }
            }
            return false;
        }

        function updateTranslatorVisibility() {
            const show = isTranslationPublication();
            if (!dom.translationBlock) return;
            dom.translationBlock.classList.toggle('hidden', !show);
            if (dom.translatorCount) {
                const translatorCount = state.authors.filter((author) => author.type === 'translator').length;
                dom.translatorCount.textContent = show ? `${translatorCount} Çevirmen` : '';
            }
        }

        function fetchJSON(url, options = {}) {
            const config = {
                method: options.method ?? 'GET',
                headers: options.headers ?? (options.body ? jsonHeaders : { 'X-Requested-With': 'XMLHttpRequest' }),
                body: options.body ?? null,
            };

            return fetch(url, config).then(async (response) => {
                let payload = null;
                try {
                    payload = await response.json();
                } catch (error) {
                    payload = null;
                }

                if (!response.ok) {
                    const message = payload?.error ?? payload?.message ?? `HTTP ${response.status}`;
                    throw new Error(message);
                }

                if (payload && payload.status && payload.status !== 'success' && payload.status !== 'ok') {
                    throw new Error(payload.error ?? payload.message ?? 'İstek sırasında hata oluştu.');
                }

                return payload ?? {};
            });
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function optionLabel(selectEl) {
            if (!selectEl) return '';
            const option = selectEl.options[selectEl.selectedIndex];
            return option ? option.textContent.trim() : (selectEl.value ?? '');
        }

        function setSelectValue(selectEl, value, label) {
            if (!selectEl) return;
            const normalized = value ?? '';
            const existing = Array.from(selectEl.options).find((opt) => opt.value === normalized);
            if (!existing && normalized !== '' && label) {
                const option = new Option(label, normalized, true, true);
                selectEl.add(option);
            }
            selectEl.value = normalized;
        }

        function normalizeAuthor(raw, index) {
            const type = String(raw?.type ?? 'author').toLowerCase() === 'translator' ? 'translator' : 'author';
            const firstName = raw?.first_name ?? raw?.name ?? '';
            const lastName = raw?.last_name ?? raw?.surname ?? '';
            const email = raw?.email ?? raw?.mail ?? '';
            const affiliation = raw?.affiliation ?? raw?.institution ?? raw?.organization ?? '';
            const affiliationId = raw?.affiliation_id ?? raw?.institution_id ?? null;
            const title = raw?.title ?? raw?.title_name ?? '';
            const titleId = raw?.title_id ?? null;
            const country = raw?.country ?? raw?.country_name ?? '';
            const countryCode = raw?.country_code ?? raw?.country_id ?? null;
            const city = raw?.city ?? raw?.city_name ?? '';
            const phone = raw?.phone ?? '';
            const orcid = raw?.orcid ?? '';
            const address = raw?.address ?? '';
            const userId = raw?.user_id ?? null;
            const isCorresponding = Boolean(raw?.is_corresponding ?? raw?.isCorresponding ?? (index === 0 && type === 'author'));
            const order = Number(raw?.order ?? raw?.order_number ?? raw?.position ?? index + 1) || index + 1;

            return {
                type,
                first_name: firstName,
                last_name: lastName,
                email,
                is_corresponding: isCorresponding,
                order,
                affiliation,
                affiliation_id: affiliationId,
                orcid,
                user_id: userId,
                title,
                title_id: titleId,
                phone,
                country,
                country_code: countryCode,
                city,
                address,
            };
        }

        function serializeAuthor(author, index) {
            const rawCountry = author.country_id ?? author.country_code ?? null;
            const countryId = rawCountry !== null && rawCountry !== '' ? Number(rawCountry) || null : null;

            return {
                type: author.type,
                first_name: author.first_name,
                last_name: author.last_name,
                email: author.email,
                is_corresponding: Boolean(author.is_corresponding),
                order: Number(author.order ?? index + 1) || index + 1,
                affiliation: author.affiliation ?? '',
                affiliation_id: author.affiliation_id ?? null,
                orcid: author.orcid ?? null,
                user_id: author.user_id ?? null,
                phone: author.phone ?? '',
                title_id: author.title_id ?? null,
                title: author.title ?? '',
                country_id: countryId,
                country_code: author.country_code ?? (countryId !== null ? String(countryId) : null),
                country: author.country ?? '',
                city: author.city ?? '',
                address: author.address ?? '',
            };
        }

        function reorderAuthors() {
            state.authors.sort((a, b) => {
                const typeScore = (a.type === 'translator') - (b.type === 'translator');
                if (typeScore !== 0) return typeScore;
                return (a.order ?? 0) - (b.order ?? 0);
            });

            let order = 1;
            state.authors.forEach((author) => {
                if (author.type !== 'translator') {
                    author.order = order++;
                }
            });
        }

        function placeholderCard(message) {
            return `
            <div class="kt-card">
                <div class="kt-card-content p-5">
                    <p class="text-sm text-muted-foreground">${escapeHtml(message)}</p>
                </div>
            </div>`;
        }

        function createAuthorCard(author, index, options = {}) {
            const orderNumber = options.order ?? author.order ?? index + 1;
            const fullName = `${author.first_name ?? ''} ${author.last_name ?? ''}`.trim() || 'Ad Soyad belirtilmedi';
            const badgeLabel = options.badgeLabel ?? (author.type === 'translator' ? 'Çevirmen' : author.is_corresponding ? 'Sorumlu' : 'Katkıda Bulunan');
            const badgeClass = author.type === 'translator' ? 'kt-badge-info' : author.is_corresponding ? 'kt-badge-success' : 'kt-badge-warning';
            const email = author.email || 'E-posta belirtilmedi';
            const institution = author.affiliation || 'Belirtilmedi';
            const title = author.title || 'Belirtilmedi';
            const country = author.country || 'Belirtilmedi';
            const phone = author.phone || 'Belirtilmedi';
            const city = author.city || 'Belirtilmedi';
            const orcid = author.orcid || 'Belirtilmedi';
            const disableDelete = options.disableDelete ?? false;
            const isResponsible = options.isResponsible ?? (author.type === 'author' && author.is_corresponding);
            const missingFields = isResponsible ? getMissingResponsibleFields(author) : [];
            const hasMissingFields = missingFields.length > 0;
            const missingLabels = formatMissingFieldList(missingFields);
            const missingSuffix = missingFields.length > 1 ? 'alanlarını' : 'alanını';
            const cardClasses = ['kt-card'];
            if (hasMissingFields) {
                cardClasses.push('border', 'border-warning/40', 'shadow-none');
            }

            const deleteButton = disableDelete
                ? ''
                : `
        <button type="button" class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-danger" onclick="step2Authors.remove(${index})">
            <i class="ki-filled ki-trash text-sm"></i>
            <span class="hidden sm:inline">Sil</span>
        </button>`;

            const editButtonClass = isResponsible && hasMissingFields
                ? 'kt-btn kt-btn-sm'
                : 'kt-btn kt-btn-sm kt-btn-ghost kt-btn-primary';

            const editButtonStyle = isResponsible && hasMissingFields
                ? 'style="background-color:#f59e0b;border-color:#f59e0b;color:white;"'
                : '';

            const editButtonLabel = isResponsible && hasMissingFields ? 'Bilgileri Tamamla' : 'Düzenle';

            const missingBadge = hasMissingFields
                ? '<span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-warning">Eksik Bilgi</span>'
                : '';

            return `
        <div class="${cardClasses.join(' ')}">
            <div class="kt-card-header">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-between min-w-0" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="flex size-10 items-center justify-center self-start rounded-full bg-muted text-sm font-semibold text-muted-foreground sm:self-auto">
                        ${escapeHtml(orderNumber)}
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-wrap items-center gap-2">
                            <h4 class="kt-card-title text-sm">${escapeHtml(fullName)}</h4>
                            <span class="kt-badge kt-badge-sm ${badgeClass}">${escapeHtml(badgeLabel)}</span>
                            ${missingBadge}
                            </div>
                        <p class="text-xs text-muted-foreground">${escapeHtml(email)}</p>
                        </div>
                    </div>
                <div class="flex flex-wrap items-center gap-2 sm:flex-nowrap sm:justify-end min-w-0">
                    <button type="button" class="${editButtonClass}" ${editButtonStyle} onclick="openAuthorModal('edit', ${index})">
                        <i class="ki-filled ki-notepad-edit text-sm"></i>
                        <span class="hidden sm:inline">${editButtonLabel}</span>
                        <span class="sm:hidden">Düzenle</span>
                    </button>
                    ${deleteButton}
                </div>
                </div>
            </div>
            <div class="kt-card-content">
            ${hasMissingFields ? `
                <div class="mb-3 p-3 border border-warning/40 bg-warning/10 rounded-lg flex flex-col gap-2">
                    <div class="flex items-start gap-3">
                        <span class="flex items-center justify-center size-7 rounded-full bg-warning/20 text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <path d="M12 9v4"></path>
                                <path d="M12 17h.01"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                            </svg>
                        </span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-warning">Eksik bilgiler</p>
                            <p class="text-xs text-muted-foreground">Sorumlu yazar için ${escapeHtml(missingLabels)} ${missingSuffix} tamamlayın.</p>
                        </div>
                        <div class="shrink-0">
                            <button type="button" class="kt-btn kt-btn-sm" style="background-color:#f59e0b;border-color:#f59e0b;color:white;" onclick="openAuthorModal('edit', ${index})">
                                Tamamla
                            </button>
                        </div>
                    </div>
                </div>
            ` : ''}
            <div class="grid grid-cols-1 gap-1.5 sm:gap-2 sm:grid-cols-2 xl:grid-cols-3 overflow-hidden">
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start text-foreground sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <path d="M4 21h16"></path>
                                <path d="M6 21V7l6-4 6 4v14"></path>
                                <path d="M10 21v-6h4v6"></path>
                                <path d="M10 11h4"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">Kurum</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(institution)}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start rounded-full bg-secondary/10 text-secondary sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <circle cx="12" cy="7" r="4"></circle>
                                <path d="M4.5 21a7.5 7.5 0 0 1 15 0"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">Ünvan</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(title)}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start rounded-full bg-success/10 text-success sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M3 12h18"></path>
                                <path d="M12 3a15 15 0 0 1 4.5 9 15 15 0 0 1-4.5 9A15 15 0 0 1 7.5 12 15 15 0 0 1 12 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">Ülke</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(country)}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start rounded-full bg-warning/10 text-warning sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.05-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">Telefon</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(phone)}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start rounded-full bg-info/10 text-info sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M7 12s2.5-4 5-4 5 4 5 4-2.5 4-5 4-5-4-5-4z"></path>
                                <circle cx="12" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">ORCID</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(orcid)}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 rounded-lg bg-accent/5 p-2 sm:flex-row sm:items-center sm:gap-3 sm:p-2.5 min-w-0">
                        <div class="flex size-8 items-center justify-center self-start rounded-full bg-purple-100 text-purple-500 sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" class="size-4" aria-hidden="true">
                                <path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 0 1 18 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-muted-foreground">Şehir</span>
                        <p class="text-sm font-medium text-foreground">${escapeHtml(city)}</p>
                        </div>
                    </div>
                </div>
            ${author.address ? `
            <div class="mt-3 p-3 rounded-lg border border-border bg-muted/30 text-sm text-muted-foreground">
                <strong class="block text-xs uppercase tracking-wide mb-1">Adres</strong>
                <span>${escapeHtml(author.address)}</span>
            </div>` : ''}
            </div>
    </div>`;
        }


        function renderResponsible(entry) {
            if (!dom.responsible) return;
            if (!entry) {
                dom.responsible.innerHTML = placeholderCard('Sorumlu yazar henüz eklenmedi.');
                return;
            }
            const disableDelete = state.authors.filter((author) => author.type === 'author').length <= 1;
            dom.responsible.innerHTML = createAuthorCard(entry.author, entry.index, {
                order: entry.author.order ?? 1,
                disableDelete,
                isResponsible: true,
            });
        }

        function renderRegularAuthors(entries) {
            if (!dom.authors) return;
            if (!entries.length) {
                dom.authors.innerHTML = placeholderCard('Henüz yardımcı yazar eklenmedi.');
            return;
        }
            dom.authors.innerHTML = entries
                .map((entry, idx) => createAuthorCard(entry.author, entry.index, { order: entry.author.order ?? idx + 1 }))
                .join('');
        }

        function renderTranslators(entries) {
            if (!dom.translators) return;
            if (!entries.length) {
                dom.translators.innerHTML = '';
                if (dom.translatorCount) dom.translatorCount.textContent = '0 Çevirmen';
                updateTranslatorVisibility();
                return;
            }
            dom.translators.innerHTML = entries
                .map((entry, idx) => createAuthorCard(entry.author, entry.index, { order: idx + 1 }))
                .join('');
            if (dom.translatorCount) dom.translatorCount.textContent = `${entries.length} Çevirmen`;
            updateTranslatorVisibility();
        }

        function ensureCorrespondingAuthor() {
            const regularAuthors = state.authors.filter((author) => author.type === 'author');
            if (!regularAuthors.length) return;
            if (!regularAuthors.some((author) => author.is_corresponding)) {
                regularAuthors[0].is_corresponding = true;
            }
        }

        function renderAuthors() {
            reorderAuthors();
            const entries = state.authors.map((author, index) => ({ author, index }));
            const corresponding = entries.find((entry) => entry.author.type !== 'translator' && entry.author.is_corresponding) ?? null;
            renderResponsible(corresponding);
            const others = entries.filter((entry) => entry !== corresponding && entry.author.type === 'author');
            renderRegularAuthors(others);
            const translators = entries.filter((entry) => entry.author.type === 'translator');
            renderTranslators(translators);
        }

        function collectAddModalValues() {
            const modal = dom.addModal;
            if (!modal) return null;

            const name = modal.querySelector('input[name="author_name"]')?.value.trim() ?? '';
            const surname = modal.querySelector('input[name="author_surname"]')?.value.trim() ?? '';
            const email = modal.querySelector('input[name="author_email_modal"]')?.value.trim() ?? '';
            const titleSelect = modal.querySelector('select[name="author_title"]');
            const institutionSelect = modal.querySelector('select[name="author_institution"]');
            const phone = modal.querySelector('input[name="author_phone"]')?.value.trim() ?? '';
            const orcid = modal.querySelector('input[name="orcid"]')?.value.trim() ?? '';
            const countrySelect = modal.querySelector('select[name="author_country"]');
            const cityInput = modal.querySelector('input[name="author_city"]') ?? modal.querySelector('select[name="author_city"]');
            const address = modal.querySelector('textarea[name="author_address"]')?.value.trim() ?? '';
            const isCorrespondingInput = modal.querySelector('input[name="author_is_corresponding"]');
            const noInstitutionCheckbox = modal.querySelector('#no_institution_checkbox');

            let affiliation = '';
            let affiliationId = null;

            if (noInstitutionCheckbox?.checked) {
                affiliation = 'Kurum Yok';
            } else if (institutionSelect) {
                affiliationId = institutionSelect.value || null;
                affiliation = optionLabel(institutionSelect);
            }

            return {
                type: state.modal.type ?? 'author',
                first_name: name,
                last_name: surname,
                email,
                title: optionLabel(titleSelect),
                title_id: titleSelect?.value ?? null,
                affiliation,
                affiliation_id: affiliationId,
                phone,
                orcid,
                country: optionLabel(countrySelect),
                country_code: countrySelect?.value ?? null,
                city: cityInput?.value?.trim() ?? '',
                address,
                is_corresponding: isCorrespondingInput ? isCorrespondingInput.checked : false,
            };
        }

        function collectEditModalValues(index) {
            const modal = dom.editModal;
            if (!modal) return null;

            const author = state.authors[index];
            if (!author) return null;

            const name = modal.querySelector('input[name="edit_author_name"]')?.value.trim() ?? '';
            const surname = modal.querySelector('input[name="edit_author_surname"]')?.value.trim() ?? '';
            const email = modal.querySelector('input[name="edit_author_email"]')?.value.trim() ?? '';
            const titleSelect = modal.querySelector('select[name="edit_author_title"]');
            const institutionSelect = modal.querySelector('select[name="edit_author_institution"]');
            const phone = modal.querySelector('input[name="edit_author_phone"]')?.value.trim() ?? '';
            const orcid = modal.querySelector('input[name="edit_author_orcid"]')?.value.trim() ?? '';
            const countrySelect = modal.querySelector('select[name="edit_author_country"]');
            const cityInput = modal.querySelector('input[name="edit_author_city"]') ?? modal.querySelector('select[name="edit_author_city"]');
            const address = modal.querySelector('textarea[name="edit_author_address"]')?.value.trim() ?? '';
            const isCorrespondingInput = modal.querySelector('input[name="edit_author_is_corresponding"]');
            const noInstitutionCheckbox = modal.querySelector('#edit_no_institution_checkbox') ?? modal.querySelector('#no_institution_checkbox');

            let affiliation = author.affiliation;
            let affiliationId = author.affiliation_id;

            if (noInstitutionCheckbox?.checked) {
                affiliation = 'Kurum Yok';
                affiliationId = null;
            } else if (institutionSelect) {
                affiliationId = institutionSelect.value || null;
                affiliation = optionLabel(institutionSelect);
            }

            return {
                first_name: name,
                last_name: surname,
                email,
                title: optionLabel(titleSelect),
                title_id: titleSelect?.value ?? null,
                affiliation,
                affiliation_id: affiliationId,
                phone,
                orcid,
                country: optionLabel(countrySelect),
                country_code: countrySelect?.value ?? null,
                city: cityInput?.value?.trim() ?? '',
                address,
                is_corresponding: author.type === 'author' ? (isCorrespondingInput ? isCorrespondingInput.checked : author.is_corresponding) : false,
            };
        }

        function resetAddModal() {
            const modal = dom.addModal;
            if (!modal) return;

            ['author_name', 'author_surname', 'author_email_modal', 'author_phone', 'author_orcid'].forEach((name) => {
                const input = modal.querySelector(`[name="${name}"]`);
                if (input) input.value = '';
            });

            ['author_title', 'author_institution', 'author_country', 'author_city'].forEach((name) => {
                const select = modal.querySelector(`[name="${name}"]`);
                if (select) select.value = '';
            });

            const address = modal.querySelector('textarea[name="author_address"]');
            if (address) address.value = '';

            const noInstitutionCheckbox = modal.querySelector('#no_institution_checkbox');
            if (noInstitutionCheckbox) {
                noInstitutionCheckbox.checked = false;
                noInstitutionCheckbox.dispatchEvent(new Event('change'));
            }

            const addInstitutionCheckbox = modal.querySelector('#add_institution_checkbox');
            if (addInstitutionCheckbox) {
                addInstitutionCheckbox.checked = false;
                addInstitutionCheckbox.dispatchEvent(new Event('change'));
            }

            const correspondingInput = modal.querySelector('input[name="author_is_corresponding"]');
            if (correspondingInput) {
                correspondingInput.disabled = state.modal.type === 'translator';
                correspondingInput.checked = state.modal.type === 'author' && !state.authors.some((author) => author.type === 'author' && author.is_corresponding);
            }
        }

        function openModal(modal) {
            if (!modal) return;
                modal.classList.add('kt-modal-open');
                modal.style.display = 'flex';
                document.body.classList.add('kt-modal-open');
        }

        function closeModal(modal) {
            if (!modal) return;
            if (modal.id === 'add_author_modal' && typeof window.closeAuthorModal === 'function') {
                window.closeAuthorModal();
                return;
            }
            if (modal.id === 'edit_author_modal' && typeof window.closeEditAuthorModal === 'function') {
                window.closeEditAuthorModal();
                return;
            }
            modal.classList.remove('kt-modal-open');
            modal.style.display = 'none';
            document.body.classList.remove('kt-modal-open');
        }

        const step2 = {
            hydrate(payload) {
                this.clearError();
                const list = payload?.data?.authors ?? payload?.data?.authors ?? payload?.data ?? payload?.authors ?? [];
                state.authors = list.map((row, index) => normalizeAuthor(row, index));
                ensureCorrespondingAuthor();
                renderAuthors();
                updateTranslatorVisibility();
                return payload;
            },
            async load() {
                try {
                    const payload = await fetchJSON(API_URL, { method: 'GET' });
                    this.hydrate(payload);
                } catch (error) {
                    console.warn('[Step2] Oturum verisi alınamadı', error);
                    state.authors = [];
                    renderAuthors();
                    updateTranslatorVisibility();
                }
            },
            getPayload() {
                return {
                    authors: state.authors.map((author, index) => serializeAuthor(author, index)),
                };
            },
            validate() {
                this.clearError();
                const regularAuthors = state.authors.filter((author) => author.type === 'author');
                
                if (!regularAuthors.length) {
                    this.showError('En az bir yazar eklemelisiniz.');
                    return false;
                }
                
                // Sorumlu yazar kontrolü
                const correspondingAuthor = regularAuthors.find((author) => author.is_corresponding);
                if (!correspondingAuthor) {
                    this.showError('Bir sorumlu yazar seçmelisiniz.');
                    return false;
                }
                
                // Sorumlu yazar bilgilerinin tamamlanmış olup olmadığını kontrol et
                const requiredFields = ['first_name', 'last_name', 'email'];
                const missingFields = requiredFields.filter(field => !correspondingAuthor[field] || correspondingAuthor[field].trim() === '');
                
                if (missingFields.length > 0) {
                    const fieldLabels = {
                        'first_name': 'Ad',
                        'last_name': 'Soyad', 
                        'email': 'E-posta'
                    };
                    const missingFieldLabels = missingFields.map(field => fieldLabels[field] || field);
                    this.showError(`Sorumlu yazarın ${missingFieldLabels.join(', ')} bilgileri eksik. Lütfen tamamlayınız.`);
                    return false;
                }
                
                // Sorumlu yazarın diğer önemli bilgilerini de kontrol et
                const additionalFields = ['affiliation', 'country', 'city'];
                const missingAdditionalFields = additionalFields.filter(field => !correspondingAuthor[field] || correspondingAuthor[field].trim() === '');
                
                if (missingAdditionalFields.length > 0) {
                    const fieldLabels = {
                        'affiliation': 'Kurum',
                        'country': 'Ülke',
                        'city': 'Şehir'
                    };
                    const missingFieldLabels = missingAdditionalFields.map(field => fieldLabels[field] || field);
                    this.showError(`Sorumlu yazarın ${missingFieldLabels.join(', ')} bilgileri eksik. Lütfen tamamlayınız.`);
                    return false;
                }
                
                return true;
            },
            showError(message) {
                const errorElement = document.getElementById('authors-error');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
            clearError() {
                const errorElement = document.getElementById('authors-error');
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.style.display = 'none';
                }
            },
            submit() {
                if (!this.validate()) {
                    return Promise.reject(new Error('Validasyon hatası'));
                }
                const payload = this.getPayload();
                return fetchJSON(API_URL, {
                    method: 'POST',
                    headers: jsonHeaders,
                    body: JSON.stringify(payload),
                });
            },
            addAuthorFromModal() {
                const data = collectAddModalValues();
                if (!data) return;

                if (!data.first_name || !data.last_name || !data.email) {
                    alert('Ad, soyad ve e-posta alanları zorunludur!');
                    return;
                }

                // Email kontrolü sadece ekleme modunda yap
                if (state.modal.mode !== 'edit' && data.type === 'author' && state.authors.some((author) => author.type === 'author' && author.email.toLowerCase() === data.email.toLowerCase())) {
                        alert('Bu e-posta adresiyle zaten bir yazar eklediniz.');
                        return;
                    }

                if (data.type === 'author' && data.is_corresponding) {
                    state.authors.forEach((author) => {
                        if (author.type === 'author') {
                            author.is_corresponding = false;
                        }
                    });
                }

                if (data.type === 'author' && !state.authors.some((author) => author.type === 'author' && author.is_corresponding)) {
                    data.is_corresponding = true;
                }

                const order = data.type === 'author'
                    ? state.authors.filter((author) => author.type === 'author').length + 1
                    : null;

                const authorData = {
                    type: data.type,
                        first_name: data.first_name,
                        last_name: data.last_name,
                        email: data.email,
                    is_corresponding: data.type === 'author' ? data.is_corresponding : false,
                    order,
                        affiliation: data.affiliation,
                        affiliation_id: data.affiliation_id,
                        orcid: data.orcid,
                    user_id: null,
                        title: data.title,
                        title_id: data.title_id,
                        phone: data.phone,
                        country: data.country,
                        country_code: data.country_code,
                        city: data.city,
                        address: data.address,
                };

                if (state.modal.mode === 'edit' && state.modal.index !== null) {
                    // Düzenleme modu
                    state.authors[state.modal.index] = authorData;
                    } else {
                    // Ekleme modu
                    state.authors.push(authorData);
                    }

                    ensureCorrespondingAuthor();
                    renderAuthors();
                closeAuthorModal();
                    resetAddModal();
            },
            updateAuthorFromModal() {
                const index = state.modal.index;
                if (index === null || index === undefined) return;
                const target = state.authors[index];
                if (!target) return;

                const updates = collectEditModalValues(index);
                if (!updates) return;

                if (!updates.first_name || !updates.last_name || !updates.email) {
                    alert('Ad, soyad ve e-posta alanları zorunludur!');
                    return;
                }

                if (updates.is_corresponding && target.type === 'author') {
                    state.authors.forEach((author, idx) => {
                        if (idx !== index && author.type === 'author') {
                            author.is_corresponding = false;
                        }
                    });
                }

                Object.assign(target, updates, { type: target.type });
                if (target.type === 'translator') {
                    target.is_corresponding = false;
                }

                ensureCorrespondingAuthor();
                renderAuthors();
                closeModal(dom.editModal);
            },
            openEdit(index) {
                const author = state.authors[index];
                if (!author) return;
                state.modal.mode = 'edit';
                state.modal.index = index;

                const modal = dom.editModal;
                if (!modal) return;
                openModal(modal);

                const setValue = (selector, value) => {
                    const el = modal.querySelector(selector);
                    if (el) el.value = value ?? '';
                };

                setValue('input[name="edit_author_name"]', author.first_name);
                setValue('input[name="edit_author_surname"]', author.last_name);
                setValue('input[name="edit_author_email"]', author.email);
                setValue('input[name="edit_author_phone"]', author.phone);
                setValue('input[name="edit_author_orcid"]', author.orcid);
                setValue('textarea[name="edit_author_address"]', author.address);
                setValue('input[name="edit_author_city"]', author.city);

                const titleSelect = modal.querySelector('select[name="edit_author_title"]');
                setSelectValue(titleSelect, author.title_id, author.title);

                const institutionSelect = modal.querySelector('select[name="edit_author_institution"]');
                setSelectValue(institutionSelect, author.affiliation_id, author.affiliation);

                const countrySelect = modal.querySelector('select[name="edit_author_country"]');
                setSelectValue(countrySelect, author.country_code, author.country);

                const correspondingInput = modal.querySelector('input[name="edit_author_is_corresponding"]');
                if (correspondingInput) {
                    correspondingInput.checked = Boolean(author.is_corresponding);
                    correspondingInput.disabled = author.type === 'translator';
                }

                const modalTitle = modal.querySelector('#edit_author_modal_title');
                if (modalTitle) {
                    modalTitle.textContent = author.type === 'translator' ? 'Çevirmen Düzenle' : 'Katkıda Bulunan Düzenle';
                }
            },
            remove(index) {
                const author = state.authors[index];
                if (!author) return;
                if (!confirm('Bu kişiyi listeden kaldırmak istediğinize emin misiniz?')) {
                    return;
                }
                state.authors.splice(index, 1);
                ensureCorrespondingAuthor();
                renderAuthors();
            },
            setModalType(type) {
                const normalized = type === 'translator' ? 'translator' : 'author';
                state.modal.type = normalized;
                if (dom.addModalTitle) {
                    dom.addModalTitle.textContent = normalized === 'translator' ? 'Çevirmen Ekle' : 'Katkıda Bulunan Ekle';
                }
                const correspondingInput = dom.addModal?.querySelector('input[name="author_is_corresponding"]');
                if (correspondingInput) {
                    correspondingInput.disabled = normalized === 'translator';
                    correspondingInput.checked = normalized === 'author' && !state.authors.some((author) => author.type === 'author' && author.is_corresponding);
                }
            },
        };

        function registerWizardIntegration() {
            if (!window.contentWizard) {
                setTimeout(registerWizardIntegration, 100);
                return;
            }
            window.contentWizard.registerHydrator(2, (payload) => step2.hydrate(payload));
            window.contentWizard.registerCollector(2, () => step2.getPayload());
            window.contentWizard.registerValidator(2, () => step2.validate());
        }

        function bindAddModalButtons() {
            document.querySelectorAll('[data-kt-modal-toggle="#add_author_modal"]').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    const type = button.dataset.authorType ?? 'author';
                    openAuthorModal('add', null, type);
                });
            });
        }

        function bindInstitutionToggles() {
            const addInstitutionCheckbox = document.getElementById('add_institution_checkbox');
            const noInstitutionCheckbox = document.getElementById('no_institution_checkbox');
            const newInstitutionFields = document.getElementById('new_institution_fields');
            const noInstitutionCheckboxGroup = document.getElementById('no_institution_checkbox_group');
            const addInstitutionCheckboxGroup = document.getElementById('add_institution_checkbox_group');

            const getSelects = () => document.querySelectorAll('select[name="author_institution"], select[name="edit_author_institution"]');

            const toggleSelects = (disabled) => {
                getSelects().forEach((select) => {
                    select.disabled = disabled;
                    select.classList.toggle('opacity-50', disabled);
                    select.classList.toggle('pointer-events-none', disabled);
                });
            };

            if (addInstitutionCheckbox) {
                addInstitutionCheckbox.addEventListener('change', () => {
                    const checked = addInstitutionCheckbox.checked;
                    toggleSelects(checked);
                    if (newInstitutionFields) newInstitutionFields.classList.toggle('hidden', !checked);
                    if (noInstitutionCheckbox) {
                        noInstitutionCheckbox.disabled = checked;
                        if (checked) noInstitutionCheckbox.checked = false;
                    }
                    if (noInstitutionCheckboxGroup) noInstitutionCheckboxGroup.classList.toggle('hidden', checked);
                });
            }

            if (noInstitutionCheckbox) {
                noInstitutionCheckbox.addEventListener('change', () => {
                    const checked = noInstitutionCheckbox.checked;
                    toggleSelects(checked);
                    if (addInstitutionCheckbox) {
                        addInstitutionCheckbox.disabled = checked;
                        if (checked) addInstitutionCheckbox.checked = false;
                    }
                    if (addInstitutionCheckboxGroup) addInstitutionCheckboxGroup.classList.toggle('hidden', checked);
                    if (newInstitutionFields) newInstitutionFields.classList.add('hidden');
                });
            }
        }

        // Form doldurma fonksiyonu
        function prefillAddModal(author) {
            const modal = document.getElementById('add_author_modal');
            if (!modal) {
                console.error('[Step2] Modal element bulunamadı!');
                return;
            }

            const setValue = (selector, value) => {
                const el = modal.querySelector(selector);
                if (!el) {
                    console.warn('[Step2] Element bulunamadı:', selector);
                    return;
                }
                if (el instanceof HTMLInputElement || el instanceof HTMLTextAreaElement) {
                    if (el.type === 'checkbox') {
                        el.checked = Boolean(value);
                    } else {
                        el.value = value ?? '';
                    }
                }
            };

            // Form alanlarını doldur
            setValue('input[name="author_order"]', author.order ?? '');
            setValue('input[name="author_name"]', author.first_name ?? author.name ?? '');
            setValue('input[name="author_surname"]', author.last_name ?? author.surname ?? '');
            setValue('input[name="author_email_modal"]', author.email ?? author.mail ?? '');
            setValue('input[name="author_phone"]', author.phone ?? '');
            setValue('input[name="orcid"]', author.orcid ?? '');
            setValue('textarea[name="author_address"]', author.address ?? '');
            setValue('input[name="author_city"]', author.city ?? '');

            // Select elementleri için
            const titleSelect = modal.querySelector('select[name="author_title"]');
            const institutionSelect = modal.querySelector('select[name="author_institution"]');
            const countrySelect = modal.querySelector('select[name="author_country"]');
            const cityInput = modal.querySelector('input[name="author_city"]');
            const citySelect = modal.querySelector('select[name="author_city"]');

            if (titleSelect) {
                titleSelect.value = author.title_id ?? '';
            }

            if (institutionSelect) {
                institutionSelect.value = author.affiliation_id ?? '';
            }

            if (countrySelect) {
                countrySelect.value = author.country_code ?? author.country_id ?? '';
            }

            // Şehir alanı için (hem input hem select olabilir)
            if (cityInput) {
                cityInput.value = author.city ?? '';
            } else if (citySelect) {
                citySelect.value = author.city ?? '';
            }
        }

        function clearResponsibleModalHighlights() {
            const modal = dom.addModal;
            if (!modal) return;

            modal.querySelectorAll('[data-responsible-highlight="true"]').forEach((wrapper) => {
                wrapper.removeAttribute('data-responsible-highlight');
                wrapper.querySelectorAll('.responsible-required-hint').forEach((hint) => hint.remove());
            });

            const banner = modal.querySelector('#responsibleRequiredBanner');
            if (banner) banner.remove();
        }

        function createResponsibleBanner(missingLabels, missingSuffix) {
            const banner = document.createElement('div');
            banner.id = 'responsibleRequiredBanner';
            banner.className = 'mb-4 p-3 rounded-lg border flex items-start gap-3';

            const iconWrap = document.createElement('span');
            iconWrap.className = 'flex items-center justify-center size-7 rounded-full bg-warning/20';
            iconWrap.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                    stroke-linejoin="round" class="size-4" aria-hidden="true">
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                </svg>
            `;

            const contentWrap = document.createElement('div');
            contentWrap.className = 'flex-1';

            const title = document.createElement('p');
            title.className = 'text-sm font-semibold text-warning';
            title.textContent = 'Sorumlu yazar bilgileri eksik';

            const description = document.createElement('p');
            description.className = 'text-xs text-muted-foreground';
            description.textContent = `Lütfen ${missingLabels} ${missingSuffix} doldurun. Bu bilgiler iletişim için zorunludur.`;

            contentWrap.appendChild(title);
            contentWrap.appendChild(description);

            banner.appendChild(iconWrap);
            banner.appendChild(contentWrap);

            return banner;
        }

        function applyResponsibleModalHighlights(fields) {
            const modal = dom.addModal;
            if (!modal || !fields?.length) return;

            const form = modal.querySelector('#addAuthorForm');
            if (form) {
                const existingBanner = modal.querySelector('#responsibleRequiredBanner');
                if (existingBanner) existingBanner.remove();

                const missingLabelsText = formatMissingFieldList(fields);
                const missingSuffix = fields.length > 1 ? 'alanlarını' : 'alanını';
                const banner = createResponsibleBanner(missingLabelsText, missingSuffix);
                form.insertBefore(banner, form.firstChild);
            }

            fields.forEach((field) => {
                const el = modal.querySelector(field.selector);
                if (!el) return;

                const wrapper = el.closest('.flex.flex-col') || el.closest('.kt-form-field') || el.parentElement;
                if (!wrapper) return;

                wrapper.setAttribute('data-responsible-highlight', 'true');
            });

            const firstField = modal.querySelector(fields[0]?.selector);
            if (firstField) {
                setTimeout(() => {
                    try {
                        firstField.focus();
                        firstField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } catch (error) {
                        console.warn('[Step2] Field focus failed', error);
                    }
                }, 200);
            }
        }

        // Form temizleme fonksiyonu
        function getAddAuthorModalInstance() {
            if (!dom.addModal) return null;
            if (dom.addModalInstance) return dom.addModalInstance;
            if (typeof window.KTModal !== 'undefined') {
                dom.addModalInstance = window.KTModal.getInstance(dom.addModal) || new window.KTModal(dom.addModal);
                return dom.addModalInstance;
            }
            return null;
        }

        // Form temizleme fonksiyonu
        function resetAddModal() {
            const modal = document.getElementById('add_author_modal');
            if (!modal) {
                console.error('[Step2] Modal element bulunamadı!');
                return;
            }

            // Form alanlarını temizle
            const inputs = modal.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            });

            // Modal başlığını ve buton metnini sıfırla
            const modalTitle = dom.addModalTitle || document.getElementById('author_modal_title');
            if (modalTitle) {
                modalTitle.textContent = state.modal.type === 'translator' ? 'Çevirmen Ekle' : 'Katkıda Bulunan Ekle';
            }

            const saveButton = modal.querySelector('[data-author-modal-submit]');
            if (saveButton) {
                saveButton.textContent = 'Kaydet';
            }

            clearResponsibleModalHighlights();
        }

        // Tek modal fonksiyonu - hem ekleme hem düzenleme için
        window.openAuthorModal = function(mode, index, type) {
            const modal = dom.addModal;
            if (!modal) {
                console.error('[Step2] add_author_modal bulunamadı');
                return;
            }

            const normalizedType = type || (mode === 'edit' && index !== null ? (state.authors[index]?.type ?? 'author') : 'author');
            state.modal.mode = mode;
            state.modal.index = index;
            state.modal.type = normalizedType;

            step2.setModalType(normalizedType);
            clearResponsibleModalHighlights();
            if (typeof window.clearAuthorAlerts === 'function') {
                window.clearAuthorAlerts();
            }

            if (mode === 'edit' && index !== null) {
                const author = state.authors[index];
                if (!author) {
                    alert('Katkıda Bulunan bulunamadı!');
                    return;
                }

                prefillAddModal(author);

                if (author.type === 'author' && author.is_corresponding) {
                    const missing = getMissingResponsibleFields(author);
                    if (missing.length) {
                        applyResponsibleModalHighlights(missing);
                    }
                }
            } else {
                resetAddModal();
            }

            const modalTitle = dom.addModalTitle;
            if (modalTitle) {
                modalTitle.textContent = normalizedType === 'translator'
                    ? (mode === 'edit' ? 'Çevirmen Düzenle' : 'Çevirmen Ekle')
                    : (mode === 'edit' ? 'Katkıda Bulunan Düzenle' : 'Katkıda Bulunan Ekle');
            }

            const submitButton = modal.querySelector('[data-author-modal-submit]');
            if (submitButton) {
                submitButton.textContent = mode === 'edit' ? 'Güncelle' : 'Kaydet';
            }

            const instance = getAddAuthorModalInstance();
            if (instance) {
                instance.show();
            } else {
                modal.classList.add('kt-modal-open');
                modal.style.display = 'flex';
                document.body.classList.add('kt-modal-open');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeAuthorModal = function() {
            const modal = dom.addModal;
            if (!modal) return;

            if (typeof window.clearAuthorAlerts === 'function') {
                window.clearAuthorAlerts();
            }
            clearResponsibleModalHighlights();

            const instance = getAddAuthorModalInstance();
            if (instance) {
                instance.hide();
            } else {
                modal.style.display = 'none';
                modal.classList.remove('kt-modal-open');
                document.body.classList.remove('kt-modal-open');
                document.body.style.overflow = '';
            }

            state.modal.mode = 'create';
            state.modal.index = null;
            state.modal.type = 'author';
            resetAddModal();
        };

        window.step2Authors = {
            edit: (index) => step2.openEdit(index),
            remove: (index) => step2.remove(index),
        };
        window.validateStep2 = () => step2.validate();
        window.submitStep2 = () => step2.submit();
        window.addArticleStep2SaveAuthor = () => step2.addAuthorFromModal();
        window.addArticleStep2UpdateAuthor = () => step2.updateAuthorFromModal();
        window.updateAuthor = window.addArticleStep2UpdateAuthor;
        window.openEditAuthorModal = (index) => step2.openEdit(index);
        window.removeAuthor = (index) => step2.remove(index);
        window.setModalTitle = (type) => step2.setModalType(type);
        window.closeEditAuthorModal = () => {
            if (!dom.editModal) return;
            dom.editModal.classList.remove('kt-modal-open');
            dom.editModal.style.display = 'none';
            document.body.classList.remove('kt-modal-open');
            document.querySelectorAll('.kt-modal-backdrop, [data-kt-modal-backdrop]').forEach((backdrop) => backdrop.remove());
            document.body.style.filter = '';
            document.body.style.backdropFilter = '';
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        };

        document.addEventListener('DOMContentLoaded', () => {
            dom.addModal = document.getElementById('add_author_modal');
            dom.addModalTitle = document.getElementById('author_modal_title');
            dom.editModal = document.getElementById('edit_author_modal');

            if (dom.addModal && typeof window.KTModal !== 'undefined') {
                dom.addModalInstance = window.KTModal.getInstance(dom.addModal) || new window.KTModal(dom.addModal);
                dom.addModal.addEventListener('hidden.kt.modal', () => {
                    if (typeof window.clearAuthorAlerts === 'function') {
                        window.clearAuthorAlerts();
                    }
                    clearResponsibleModalHighlights();
                    resetAddModal();
                    state.modal.mode = 'create';
                    state.modal.index = null;
                    state.modal.type = 'author';
                });
            }

            if (dom.form) dom.form.setAttribute('action', '#');
            registerWizardIntegration();
            bindAddModalButtons();
            bindInstitutionToggles();
            resetAddModal();
            step2.setModalType('author');
            step2.load();
            updateTranslatorVisibility();
        });

        window.__contentStep2State = state;
        window.__contentStep2 = step2;
        window.clearResponsibleModalHighlights = clearResponsibleModalHighlights;

        document.addEventListener('content-wizard:hydrate', (event) => {
            if (event?.detail?.step === 1) {
                updateTranslatorVisibility();
            }
        });

        document.addEventListener('content-wizard:step1-publication-change', () => {
            updateTranslatorVisibility();
        });
    })();
</script>
