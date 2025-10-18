<div class="kt-container-fixed p-0">
    <form method="post" action="/app/add-material/step-3" enctype="multipart/form-data" id="step3_form"
        style="width: 100%;">
        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5 w-full max-w-full px-2 sm:px-4 sm:max-w-4xl sm:mx-auto">

            <!-- Step 3: Dosyalar -->
            <div class="kt-card pb-2.5">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">3. Dosyalar</h3>
                </div>
                <div class="kt-card-content grid gap-3 sm:gap-5">

                    <!-- Kaynakça Bilgilendirme Kartı -->
                    <div class="bg-blue-50 rounded-lg p-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="flex-shrink-0">
                            <div class="p-1 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="ki-filled ki-information-2 text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="text-gray-700 text-sm leading-relaxed">
                            Üst veri alanlarında yer alan kaynakça bölümü içerik kabul edildiğinde yayım süreci
                            aşamasında alınacaktır. Tam metin dosyasında kaynakçaya mutlaka yer verilmelidir.
                        </div>
                    </div>

                    <!-- Validation Error Display -->
                    <div id="files-error" style="display: none; color: #dc2626; font-size: 0.875rem; margin-bottom: 1rem; padding: 0.75rem; background: #fee2e2; border-radius: 0.5rem;"></div>

                    <!-- Zorunlu Dosyalar -->
                    <div class="grid gap-3 sm:gap-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <h4 class="text-md font-medium">Zorunlu Dosyalar</h4>
                            <span class="text-xs text-muted-foreground bg-muted px-2 py-1 rounded">Maksimum 100MB</span>
                        </div>

                        <!-- Tam Metin -->
                        <div class="kt-card">
                            <div class="kt-card-content p-5">
                                <div class="flex flex-col gap-3">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" style="display: flex; flex-direction: row; justify-content: space-between;">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                            <div
                                                class="flex size-10 items-center justify-center self-start rounded-lg bg-primary/10 sm:self-auto">
                                                <i class="ki-filled ki-document text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="text-sm font-medium">1. Tam Metin</h5>
                                                <p class="text-xs text-muted-foreground">PDF, DOC, DOCX formatında</p>
                                            </div>
                                        </div>
                                        <button type="button" class="kt-btn kt-btn-outline kt-btn-sm flex-shrink-0"
                                            data-kt-modal-toggle="#required_file_modal"
                                            onclick="setRequiredFileModalContent('full_text', 'Tam Metin', 'İmzalı Tam Metin Formu (.pdf, .doc, .docx, .odt, .rtf, .jpg, .jpeg, .png, .pptx, .xml)')">
                                            <i class="ki-filled ki-folder-up text-sm"></i>
                                            Dosya Seç
                                        </button>
                                        <input type="file" name="full_text"
                                            accept=".pdf,.doc,.docx,.odt,.rtf,.tex,.latex,.txt" class="hidden"
                                            onchange="updateFileStatus('full_text', this)" />
                                    </div>
                                    <!-- Dosya durumu gösterimi - Alt satırda -->
                                    <div id="full_text_status" class="hidden">
                                        <div
                                            class="file-status-card flex flex-col gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <i
                                                    class="ki-filled ki-check-circle text-green-600 text-sm flex-shrink-0"></i>
                                                <span class="file-name text-sm text-green-700 font-medium"
                                                    id="full_text_name">4Dosya seçildi</span>
                                            </div>
                                            <div id="full_text_description_display"
                                                class="file-description text-xs text-green-600 hidden">
                                                <div class="flex flex-col gap-1 sm:flex-row sm:items-start">
                                                    <i
                                                        class="ki-filled ki-information text-xs mt-0.5 flex-shrink-0"></i>
                                                    <span id="full_text_description_text" class="break-words"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Telif Hakkı Formu -->
                        <div class="kt-card">
                            <div class="kt-card-content p-5">
                                <div class="flex flex-col gap-3">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" style="display: flex; flex-direction: row; justify-content: space-between;">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                            <div
                                                class="flex size-10 items-center justify-center self-start rounded-lg bg-warning/10 sm:self-auto">
                                                <i class="ki-filled ki-shield-tick text-warning"></i>
                                            </div>
                                            <div>
                                                <h5 class="text-sm font-medium">2. Telif Hakkı Formu</h5>
                                                <p class="text-xs text-muted-foreground">İmzalı telif hakkı formu</p>
                                            </div>
                                        </div>
                                        <button type="button" class="kt-btn kt-btn-outline kt-btn-sm"
                                            data-kt-modal-toggle="#required_file_modal"
                                            onclick="setRequiredFileModalContent('copyright_form', 'Telif Hakkı Formu', 'İmzalı telif hakkı formu (.pdf, .doc, .docx, .odt, .rtf, .jpg, .jpeg, .png, .pptx, .xml)')">
                                            <i class="ki-filled ki-folder-up text-sm"></i>
                                            Dosya Seç
                                        </button>
                                        <input type="file" name="copyright_form"
                                            accept=".pdf,.doc,.docx,.odt,.rtf,.jpg,.jpeg,.png,.pptx,.xml" class="hidden"
                                            onchange="updateFileStatus('copyright_form', this)" />
                                    </div>
                                    <!-- Dosya durumu gösterimi - Alt satırda -->
                                    <div id="copyright_form_status" class="hidden">
                                        <div
                                            class="file-status-card flex flex-col gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <i
                                                    class="ki-filled ki-check-circle text-green-600 text-sm flex-shrink-0"></i>
                                                <span class="file-name text-sm text-green-700 font-medium"
                                                    id="copyright_form_name">5Dosya seçildi</span>
                                            </div>
                                            <div id="copyright_form_description_display"
                                                class="file-description text-xs text-green-600 hidden">
                                                <div class="flex flex-col gap-1 sm:flex-row sm:items-start">
                                                    <i
                                                        class="ki-filled ki-information text-xs mt-0.5 flex-shrink-0"></i>
                                                    <span id="copyright_form_description_text"
                                                        class="break-words"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ek Dosyalar -->
                    <div class="grid gap-3 sm:gap-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" style="display: flex; flex-direction: row; justify-content: space-between;">
                            <h4 class="text-md font-medium">Ek Dosyalar</h4>
                            <button type="button" class="kt-btn kt-btn-outline kt-btn-sm"
                                data-kt-modal-toggle="#add_file_modal">
                                <i class="ki-filled ki-plus text-sm"></i>
                                <span class="sm:hidden">Ekle</span>
                                <span class="hidden sm:inline">Ek Dosya Yükle</span>
                            </button>
                        </div>

                        <!-- Hata Mesajı Alanı -->
                        <div id="file_error_message" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                        <i class="ki-filled ki-cross text-white text-sm"></i>
                                    </div>
                                </div>
                                <div class="text-red-700 text-sm leading-relaxed">
                                    <span id="file_error_text"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Ek Dosyalar Tablosu -->
                        <div class="kt-card" id="additional_files_table_container">
                            <div class="kt-card-content p-0">
                                <!-- Desktop Table -->
                                <div class="hidden sm:block overflow-x-auto">
                                    <table class="kt-table table-auto w-full">
                                        <thead>
                                            <tr>
                                                <th class="p-4 text-left">ID</th>
                                                <th class="p-4 text-left">Dosya Adı</th>
                                                <th class="p-4 text-left">Dosya Türü</th>
                                                <th class="p-4 text-left">Açıklama</th>
                                                <th class="p-4 text-left">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody id="additional_files_table">
                                            <!-- Ek dosyalar dinamik olarak eklenecek -->
                                            <tr id="no_files_row">
                                                <td colspan="5" class="p-8 text-center text-muted-foreground">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <i
                                                            class="ki-filled ki-document text-4xl text-muted-foreground/50"></i>
                                                        <p class="text-sm">Henüz ek dosya yüklenmedi</p>
                                                        <p class="text-xs">"Ek Dosya Yükle" butonuna tıklayarak dosya
                                                            ekleyebilirsiniz</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Mobile Card View -->
                                <div class="sm:hidden space-y-3 p-4" id="additional_files_mobile">
                                    <!-- Mobile cards will be dynamically added here -->
                                    <div id="no_files_mobile" class="text-center text-muted-foreground py-8">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="ki-filled ki-document text-4xl text-muted-foreground/50"></i>
                                            <p class="text-sm">Henüz ek dosya yüklenmedi</p>
                                            <p class="text-xs">"Ek Dosya Yükle" butonuna tıklayarak dosya ekleyebilirsiniz</p>
                                        </div>
                                    </div>
                                </div>
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
        const API_STEP = '/apps/add-material/step-3';
        const API_UPLOAD = '/apps/add-material/step-3/upload';
        const MAX_UPLOAD_BYTES = 100 * 1024 * 1024;
        const ADDITIONAL_DEFAULT_ACCEPT = '.xlsx,.odt,.rtf,.rtx,.latex,.txt,.tex,.pdf,.docx,.doc,.xls,.jpeg,.png,.pptx,.xml';
        const ADDITIONAL_ACCEPT_MAP = {
            '1': '.pdf,.doc,.docx,.odt,.rtf,.tex,.latex,.txt',
            '2': '.jpeg,.jpg,.png,.gif,.bmp,.tiff',
            '3': '.xlsx,.xls,.csv',
            '4': '.zip,.rar,.7z,.pdf,.doc,.docx,.pptx,.xls,.xlsx',
            '5': '.pdf,.doc,.docx',
            '6': '.pdf,.doc,.docx,.txt',
            '7': '.pdf,.doc,.docx,.bib,.ris,.txt',
            '8': ADDITIONAL_DEFAULT_ACCEPT,
        };

        const ROLE_TO_FILE_TYPE = {
            full_text: 'tam_metin',
            copyright_form: 'telif_hakki',
        };

        const FILE_TYPE_TO_ROLE = Object.entries(ROLE_TO_FILE_TYPE).reduce((acc, [role, type]) => {
            acc[type] = role;
            return acc;
        }, {});

        const ADDITIONAL_FILE_TYPE = 'ek_dosya';
        FILE_TYPE_TO_ROLE[ADDITIONAL_FILE_TYPE] = ADDITIONAL_FILE_TYPE;

        const REQUIRED_FILES = {
            full_text: {
                role: 'full_text',
                label: 'Tam Metin',
                description: 'Eğitim İçeriğinin tam metni (.pdf, .doc, .docx, .odt, .rtf, .tex, .latex, .txt)',
                is_primary: true,
                language: null,
                accept: '.pdf,.doc,.docx,.odt,.rtf,.tex,.latex,.txt',
                file_type: ROLE_TO_FILE_TYPE.full_text,
                elements: {
                    status: 'full_text_status',
                    name: 'full_text_name',
                    descriptionWrapper: 'full_text_description_display',
                    descriptionText: 'full_text_description_text',
                },
            },
            copyright_form: {
                role: 'copyright_form',
                label: 'Telif Hakkı Formu',
                description: 'İmzalı telif hakkı formu (.pdf, .doc, .docx, .odt, .rtf, .jpg, .jpeg, .png, .pptx, .xml)',
                is_primary: false,
                language: null,
                accept: '.pdf,.doc,.docx,.odt,.rtf,.jpg,.jpeg,.png,.pptx,.xml',
                file_type: ROLE_TO_FILE_TYPE.copyright_form,
                elements: {
                    status: 'copyright_form_status',
                    name: 'copyright_form_name',
                    descriptionWrapper: 'copyright_form_description_display',
                    descriptionText: 'copyright_form_description_text',
                },
            },
        };

        const state = {
            required: {
                full_text: null,
                copyright_form: null,
            },
            additional: [],
        };
        document.addEventListener('step3:file-uploaded', (event) => {
            const detail = event.detail || {};
            const file = detail.file;
            if (!file) return;

            const normalizedFile = normalizeFileRecord(file);

            if (detail.context === 'required') {
                const key = resolveRequiredKeyFromFile(normalizedFile) ?? (normalizedFile.role || 'full_text');
                state.required[key] = normalizedFile;
                if (typeof renderRequiredFile === 'function') {
                    renderRequiredFile(key);               // Zorunlu dosya kartını yeniliyorsan bu fonksiyonu çağır
                }
            } else {
                state.additional.push(normalizedFile);
                if (typeof renderAdditional === 'function') {
                    renderAdditional();
                }
            }
        });


        const dom = {
            form: document.getElementById('step3_form'),
            requiredModal: document.getElementById('required_file_modal'),
            requiredFileInput: document.getElementById('required_file_input'),
            requiredFileDesc: document.getElementById('required_file_desc_input'),
            requiredSubmitBtn: document.querySelector('#required_file_modal .kt-modal-footer .kt-btn-primary'),
            additionalModal: document.getElementById('add_file_modal'),
            addFileForm: document.getElementById('addFileForm'),
            additionalType: document.getElementById('file_type_select'),
            additionalDesc: document.querySelector('#addFileForm input[name="file_description"]'),
            additionalInput: document.getElementById('additional_file_input'),
            additionalSubmitBtn: document.querySelector('#add_file_modal .kt-modal-footer .kt-btn-primary'),
            errorBox: document.getElementById('file_error_message'),
            errorText: document.getElementById('file_error_text'),
            additionalTable: document.getElementById('additional_files_table'),
            additionalTableContainer: document.getElementById('additional_files_table_container'),
            emptyRow: document.getElementById('no_files_row'),
            mobileContainer: document.getElementById('additional_files_mobile'),
        };

        function updateDomReferences() {
            dom.form = document.getElementById('step3_form');
            dom.requiredModal = document.getElementById('required_file_modal');
            dom.requiredFileInput = document.getElementById('required_file_input');
            dom.requiredFileDesc = document.getElementById('required_file_desc_input');
            dom.requiredSubmitBtn = document.querySelector('#required_file_modal .kt-modal-footer .kt-btn-primary');
            dom.additionalModal = document.getElementById('add_file_modal');
            dom.addFileForm = document.getElementById('addFileForm');
            dom.additionalType = document.getElementById('file_type_select');
            dom.additionalDesc = document.querySelector('#addFileForm input[name="file_description"]');
            dom.additionalInput = document.getElementById('additional_file_input');
            dom.additionalSubmitBtn = document.querySelector('#add_file_modal .kt-modal-footer .kt-btn-primary');
            dom.errorBox = document.getElementById('file_error_message');
            dom.errorText = document.getElementById('file_error_text');
            dom.additionalTable = document.getElementById('additional_files_table');
            dom.additionalTableContainer = document.getElementById('additional_files_table_container');
            dom.emptyRow = document.getElementById('no_files_row');
            dom.mobileContainer = document.getElementById('additional_files_mobile');
        }

        let currentRequiredKey = null;
        let currentRequiredRole = 'full_text'; // global scope’ta tanımla

        function initRequiredState() {
            Object.keys(REQUIRED_FILES).forEach((key) => {
                if (!Object.prototype.hasOwnProperty.call(state.required, key)) {
                    state.required[key] = null;
                }
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

        function formatSize(bytes) {
            const size = Number(bytes);
            if (!Number.isFinite(size) || size <= 0) return '';
            if (size >= 1024 * 1024) return `${(size / (1024 * 1024)).toFixed(2)} MB`;
            if (size >= 1024) return `${(size / 1024).toFixed(2)} KB`;
            return `${size} B`;
        }

        function inferFileTypeFromRole(role) {
            const key = typeof role === 'string' ? role.trim() : '';
            if (!key) return null;
            if (ROLE_TO_FILE_TYPE[key]) {
                return ROLE_TO_FILE_TYPE[key];
            }
            if (key === ADDITIONAL_FILE_TYPE) {
                return ADDITIONAL_FILE_TYPE;
            }
            return null;
        }

        function inferRoleFromFileType(fileType) {
            const key = typeof fileType === 'string' ? fileType.trim() : '';
            if (!key) return null;
            return FILE_TYPE_TO_ROLE[key] ?? null;
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

                if (payload?.status && payload.status !== 'success' && payload.status !== 'ok') {
                    throw new Error(payload.error ?? payload.message ?? 'İşlem sırasında hata oluştu.');
                }

                return payload ?? {};
            });
        }

        function ensureClientId(file) {
            if (!file.client_id) {
                file.client_id = file.temp_id ?? file.stored_path ?? `file_${Date.now()}_${Math.random().toString(16).slice(2)}`;
            }
            return file.client_id;
        }

        function resolveRequiredKeyFromFile(file) {
            if (!file) return null;
            const byRole = Object.entries(REQUIRED_FILES).find(([, cfg]) => cfg.role === file.role);
            if (byRole) return byRole[0];
            const byFileType = Object.entries(REQUIRED_FILES).find(([, cfg]) => cfg.file_type === file.file_type);
            if (byFileType) return byFileType[0];
            if (file.file_type) {
                const inferredRole = inferRoleFromFileType(file.file_type);
                if (inferredRole && REQUIRED_FILES[inferredRole]) {
                    return inferredRole;
                }
            }
            if (file.role) {
                const normalized = file.role.replace(/-/g, '_');
                if (REQUIRED_FILES[normalized]) return normalized;
            }
            if (file.key && REQUIRED_FILES[file.key]) return file.key;
            return null;
        }

        function normalizeFileRecord(file) {
            const record = { ...file };
            record.notes = record.notes ?? record.description ?? null;
            delete record.description;
            record.is_primary = Boolean(record.is_primary);
            if (!record.file_type) {
                const inferred = inferFileTypeFromRole(record.role);
                if (inferred) {
                    record.file_type = inferred;
                }
            }
            if (!record.role && record.file_type) {
                const inferredRole = inferRoleFromFileType(record.file_type);
                if (inferredRole) {
                    record.role = inferredRole;
                }
            }
            ensureClientId(record);
            return record;
        }

        function renderRequiredFile(key) {
            const config = REQUIRED_FILES[key];
            if (!config) return;

            const data = state.required[key];
            const statusEl = document.getElementById(config.elements.status);
            const nameEl = document.getElementById(config.elements.name);
            const descWrapper = document.getElementById(config.elements.descriptionWrapper);
            const descText = document.getElementById(config.elements.descriptionText);

            if (!statusEl || !nameEl) return;

            if (!data) {
                statusEl.classList.add('hidden');
                if (descWrapper) descWrapper.classList.add('hidden');
                if (descText) descText.textContent = '';
                return;
            }

            const sizeLabel = formatSize(data.size);
            nameEl.textContent = sizeLabel ? `${data.name} (${sizeLabel})` : data.name ?? 'Dosya yüklendi';
            statusEl.classList.remove('hidden');

            if (descWrapper && descText) {
                if (data.notes) {
                    descText.textContent = data.notes;
                    descWrapper.classList.remove('hidden');
                } else {
                    descText.textContent = '';
                    descWrapper.classList.add('hidden');
                }
            }
        }

        function renderAllRequired() {
            Object.keys(REQUIRED_FILES).forEach(renderRequiredFile);
        }

        function getAdditionalRoleLabel(value, fileType) {
            if (value) {
                const option = document.querySelector(`#file_type_select option[value="${value}"]`);
                if (option) {
                    return option.textContent.trim();
                }
                if (value === ADDITIONAL_FILE_TYPE) {
                    return 'Ek Dosya';
                }
            }
            if (fileType === ADDITIONAL_FILE_TYPE) {
                return 'Ek Dosya';
            }
            return 'Belirtilmedi';
        }

        function renderAdditional() {
            hideFileError();
            const tableBody = dom.additionalTable;
            const mobileContainer = document.getElementById('additional_files_mobile');
            const emptyRow = dom.emptyRow;
            const noFilesMobile = document.getElementById('no_files_mobile');
            
            if (!tableBody || !mobileContainer) return;

            // Clear existing rows
            tableBody.querySelectorAll('tr[data-row="file"]').forEach((row) => row.remove());
            mobileContainer.querySelectorAll('[data-mobile-file]').forEach((card) => card.remove());

            if (!state.additional.length) {
                if (emptyRow) emptyRow.style.display = '';
                if (noFilesMobile) noFilesMobile.style.display = 'block';
                return;
            }

            if (emptyRow) emptyRow.style.display = 'none';
            if (noFilesMobile) noFilesMobile.style.display = 'none';

            // Render desktop table
            const tableFragment = document.createDocumentFragment();
            state.additional.forEach((file, index) => {
                ensureClientId(file);
                const tr = document.createElement('tr');
                tr.dataset.row = 'file';
                tr.dataset.id = file.client_id;
                tr.innerHTML = `
                <td class="p-4">${index + 1}</td>
                <td class="p-4">
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-document text-primary"></i>
                        <span class="text-sm font-medium">${escapeHtml(file.name ?? 'Dosya')}</span>
                    </div>
                </td>
                <td class="p-4">
                    <span class="kt-badge kt-badge-outline kt-badge-primary">${escapeHtml(getAdditionalRoleLabel(file.role, file.file_type))}</span>
                </td>
                <td class="p-4">
                    ${file.notes
                        ? `<div class="max-w-xs text-sm text-secondary-foreground">${escapeHtml(file.notes)}</div>`
                        : '<span class="text-xs text-muted-foreground italic">Açıklama yok</span>'
                    }
                </td>
                <td class="p-4">
                    <button type="button" class="kt-btn kt-btn-sm kt-btn-outline kt-btn-danger" onclick="removeAdditionalFile('${escapeHtml(file.client_id)}')">
                        <i class="ki-filled ki-trash text-sm"></i>
                        Sil
                    </button>
                </td>
            `;
                tableFragment.appendChild(tr);
            });
            tableBody.appendChild(tableFragment);

            // Render mobile cards
            const mobileFragment = document.createDocumentFragment();
            state.additional.forEach((file, index) => {
                ensureClientId(file);
                const card = document.createElement('div');
                card.dataset.mobileFile = 'true';
                card.dataset.id = file.client_id;
                card.className = 'kt-card';
                card.innerHTML = `
                    <div class="kt-card-content p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ki-filled ki-document text-primary"></i>
                                <span class="text-sm font-medium">${escapeHtml(file.name ?? 'Dosya')}</span>
                            </div>
                            <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary">#${index + 1}</span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs text-muted-foreground">Dosya Türü:</span>
                                <span class="kt-badge kt-badge-outline kt-badge-primary ml-1">${escapeHtml(getAdditionalRoleLabel(file.role, file.file_type))}</span>
                            </div>
                            ${file.notes ? `
                                <div>
                                    <span class="text-xs text-muted-foreground">Açıklama:</span>
                                    <p class="text-sm text-secondary-foreground mt-1">${escapeHtml(file.notes)}</p>
                                </div>
                            ` : ''}
                        </div>
                        <div class="mt-3 pt-3 border-t border-border">
                            <button type="button" class="kt-btn kt-btn-sm kt-btn-outline kt-btn-danger sm:w-auto" onclick="removeAdditionalFile('${escapeHtml(file.client_id)}')">
                                <i class="ki-filled ki-trash text-sm"></i>
                                Dosyayı Sil
                            </button>
                        </div>
                    </div>
                `;
                mobileFragment.appendChild(card);
            });
            mobileContainer.appendChild(mobileFragment);
        }

        function hideFileError() {
            if (dom.errorBox) dom.errorBox.classList.add('hidden');
        }

        function showFileError(message) {
            if (!dom.errorBox || !dom.errorText) return;
            dom.errorText.textContent = message;
            dom.errorBox.classList.remove('hidden');
            dom.errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function setRequiredModal(key) {
            const config = REQUIRED_FILES[key];
            if (!config) return;

            updateDomReferences();
            currentRequiredKey = key;
            currentRequiredRole = config.role ?? key;

            if (dom.requiredModal) {
                dom.requiredModal.dataset.requiredKey = key;
                dom.requiredModal.dataset.requiredRole = currentRequiredRole;
                dom.requiredModal.dataset.requiredIsPrimary = String(Boolean(config.is_primary));
            }

            if (dom.requiredFileInput) {
                dom.requiredFileInput.value = '';
                dom.requiredFileInput.accept = config.accept ?? dom.requiredFileInput.accept;
            }

            if (dom.requiredFileDesc) {
                dom.requiredFileDesc.value = state.required[key]?.notes ?? '';
            }

            const titleEl = document.getElementById('required_file_title');
            if (titleEl) titleEl.textContent = config.label;

            const descriptionEl = document.getElementById('required_file_description');
            if (descriptionEl) descriptionEl.textContent = config.description ?? '';
        }

        function setRequiredModalLoading(isLoading) {
            updateDomReferences();
            const btn = dom.requiredSubmitBtn;
            if (!btn) return;

            if (isLoading) {
                btn.disabled = true;
                if (!btn.dataset.originalLabel) btn.dataset.originalLabel = btn.innerHTML;
                btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Yükleniyor';
            } else {
                btn.disabled = false;
                if (btn.dataset.originalLabel) {
                    btn.innerHTML = btn.dataset.originalLabel;
                    delete btn.dataset.originalLabel;
                }
            }
        }

        function setAdditionalModalLoading(isLoading) {
            updateDomReferences();
            const btn = dom.additionalSubmitBtn;
            if (!btn) return;

            if (isLoading) {
                btn.disabled = true;
                if (!btn.dataset.originalLabel) btn.dataset.originalLabel = btn.innerHTML;
                btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Yükleniyor';
            } else {
                btn.disabled = false;
                if (btn.dataset.originalLabel) {
                    btn.innerHTML = btn.dataset.originalLabel;
                    delete btn.dataset.originalLabel;
                }
            }
        }

        function closeModal(modal) {
            if (!modal) return;
            const dismissBtn = modal.querySelector('[data-kt-modal-dismiss="true"]');
            if (dismissBtn) {
                dismissBtn.click();
            } else {
                modal.classList.remove('kt-modal-open');
                modal.style.display = 'none';
                document.body.classList.remove('kt-modal-open');
            }
        }

        async function uploadFileViaAPI(file) {
            if (!file) throw new Error('Dosya bulunamadı.');
            if (file.size > MAX_UPLOAD_BYTES) throw new Error('Dosya boyutu 100MB\'dan büyük olamaz.');

            const formData = new FormData();
            formData.append('files[]', file);

            const payload = await fetchJSON(API_UPLOAD, { method: 'POST', body: formData });
            const uploadedList = payload?.files ?? payload?.data?.files ?? [];
            const uploaded = uploadedList[0];
            if (!uploaded) throw new Error('Dosya yüklemesi başarısız.');
            return uploaded;
        }

        async function performRequiredUpload(key, file, notes) {
            const config = REQUIRED_FILES[key];
            if (!config) throw new Error('Geçersiz dosya tipi.');

            const uploaded = await uploadFileViaAPI(file);

            const record = normalizeFileRecord({
                ...uploaded,
                role: config.role,
                file_type: config.file_type ?? inferFileTypeFromRole(config.role) ?? config.role,
                is_primary: config.is_primary,
                language: config.language,
                notes: notes ?? null,
            });

            state.required[key] = record;
            renderRequiredFile(key);
        }

        async function uploadRequiredFileHandler() {
            if (!currentRequiredKey) {
                alert('Yüklenecek dosya seçili değil.');
                return;
            }

            updateDomReferences();
            const fileInput = dom.requiredFileInput;
            const descInput = dom.requiredFileDesc;
            const file = fileInput?.files?.[0];
            if (!file) {
                alert('Lütfen bir dosya seçin.');
                return;
            }

            const notes = descInput?.value.trim() || null;

            setRequiredModalLoading(true);
            try {
                await performRequiredUpload(currentRequiredKey, file, notes);
                if (fileInput) fileInput.value = '';
                if (descInput) descInput.value = '';

                if (typeof closeRequiredFileModal === 'function') {
                    closeRequiredFileModal();
                } else {
                    closeModal(dom.requiredModal);
                }
            } catch (error) {
                alert(error.message ?? 'Dosya yüklenemedi.');
            } finally {
                setRequiredModalLoading(false);
            }
        }

        async function updateFileStatusInline(key, input) {
            if (!input?.files?.length) return;

            const normalizedKey = resolveRequiredKeyFromFile({ role: key }) ?? key;
            if (!REQUIRED_FILES[normalizedKey]) {
                alert('Geçersiz dosya tipi.');
                return;
            }

            currentRequiredKey = normalizedKey;
            const file = input.files[0];

            try {
                await performRequiredUpload(normalizedKey, file, state.required[normalizedKey]?.notes ?? null);
            } catch (error) {
                alert(error.message ?? 'Dosya yüklenemedi.');
            } finally {
                input.value = '';
            }
        }

        async function addAdditionalFile() {
            hideFileError();

            updateDomReferences();

            const type = dom.additionalType?.value ?? '';
            const description = dom.additionalDesc?.value.trim() || null;
            const file = dom.additionalInput?.files?.[0];

            if (!type) {
                showFileError('Dosya tipi seçmelisiniz.');
                return;
            }

            if (!file) {
                showFileError('Dosya seçmelisiniz.');
                return;
            }

            setAdditionalModalLoading(true);
            try {
                const uploaded = await uploadFileViaAPI(file);

                const record = normalizeFileRecord({
                    ...uploaded,
                    role: type,
                    file_type: ADDITIONAL_FILE_TYPE,
                    is_primary: false,
                    language: null,
                    notes: description,
                });

                state.additional.push(record);
                renderAdditional();
                dom.addFileForm?.reset();
                if (dom.additionalInput) dom.additionalInput.value = '';
                updateAdditionalFileAccept(type);

                if (typeof closeFileModal === 'function') {
                    closeFileModal();
                } else {
                    closeModal(dom.additionalModal);
                }
            } catch (error) {
                showFileError(error.message ?? 'Dosya yüklenemedi.');
            } finally {
                setAdditionalModalLoading(false);
            }
        }

        function removeAdditional(identifier) {
            if (!identifier) return;
            state.additional = state.additional.filter(
                (file) => file.client_id !== identifier && file.temp_id !== identifier && file.stored_path !== identifier
            );
            renderAdditional();
        }

        function updateAdditionalFileAccept(value) {
            updateDomReferences();
            if (!dom.additionalInput) return;
            dom.additionalInput.accept = ADDITIONAL_ACCEPT_MAP[String(value)] ?? ADDITIONAL_DEFAULT_ACCEPT;
        }

        function hydrateStep(payload) {
            initRequiredState();
            state.additional = [];
            Object.keys(state.required).forEach((key) => {
                state.required[key] = null;
            });

            const files = payload?.data?.files ?? payload?.files ?? [];
            files.forEach((raw) => {
                const record = normalizeFileRecord(raw);
                const key = resolveRequiredKeyFromFile(record);
                if (key && REQUIRED_FILES[key]) {
                    state.required[key] = record;
                } else {
                    state.additional.push(record);
                }
            });

            renderAllRequired();
            renderAdditional();
            return payload;
        }

        function serializeFile(file) {
            return {
                temp_id: file.temp_id ?? null,
                stored_path: file.stored_path ?? null,
                name: file.name ?? null,
                mime: file.mime ?? null,
                size: file.size ?? null,
                role: file.role ?? null,
                file_type: file.file_type ?? inferFileTypeFromRole(file.role) ?? null,
                is_primary: Boolean(file.is_primary),
                language: file.language ?? null,
                notes: file.notes ?? null,
            };
        }

        function collectPayload() {
            const requiredFiles = Object.entries(state.required)
                .filter(([, file]) => !!file)
                .map(([, file]) => serializeFile(file));

            const additionalFiles = state.additional.map((file) => serializeFile(file));

            return { files: [...requiredFiles, ...additionalFiles] };
        }

        const stepHandlers = {
            validate() {
                this.clearError();
                const missing = Object.entries(REQUIRED_FILES).find(([key]) => !state.required[key]);
                if (missing) {
                    const label = REQUIRED_FILES[missing[0]].label ?? missing[0];
                    this.showError(`Lütfen "${label}" dosyasını yükleyin.`);
                    return false;
                }
                return true;
            },
            showError(message) {
                const errorElement = document.getElementById('files-error');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
            clearError() {
                const errorElement = document.getElementById('files-error');
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.style.display = 'none';
                }
            },
            submit() {
                if (!this.validate()) {
                    return Promise.reject(new Error('Validasyon hatası'));
                }
                const payload = collectPayload();
                return fetchJSON(API_STEP, { method: 'POST', body: payload });
            },
        };

        function registerWizardIntegration() {
            if (!window.articleWizard) {
                setTimeout(registerWizardIntegration, 100);
                return;
            }
            window.articleWizard.registerHydrator(3, (payload) => hydrateStep(payload));
            window.articleWizard.registerCollector(3, () => collectPayload());
            window.articleWizard.registerValidator(3, () => stepHandlers.validate());
        }

        function bindEvents() {
            updateDomReferences();
            if (dom.form) dom.form.setAttribute('action', '#');
            if (dom.additionalType) {
                dom.additionalType.addEventListener('change', (event) => updateAdditionalFileAccept(event.target.value));
            }
            renderAllRequired();
            renderAdditional();
        }

        async function loadStepData() {
            try {
                const payload = await fetchJSON(API_STEP);
                hydrateStep(payload);
            } catch (error) {
                console.warn('[Step3] Oturum verisi alınamadı', error);
                initRequiredState();
                renderAllRequired();
                renderAdditional();
            }
        }

        const articleStep3Api = {
            hydrate: (payload) => hydrateStep(payload),
            collect: () => collectPayload(),
            validate: () => stepHandlers.validate(),
            load: () => loadStepData(),
            submit: () => stepHandlers.submit(),
        };

        window.__articleStep3State = state;
        window.__articleStep3 = articleStep3Api;

        window.setRequiredFileModalContent = function (key, title, description) {
            const normalizedKey = resolveRequiredKeyFromFile({ role: key }) ?? key;
            if (!REQUIRED_FILES[normalizedKey]) {
                console.warn('Bilinmeyen zorunlu dosya tipi:', key);
                return;
            }

            if (title) REQUIRED_FILES[normalizedKey].label = title;
            if (description) REQUIRED_FILES[normalizedKey].description = description;
            setRequiredModal(normalizedKey);
        };

        window.uploadRequiredFileHandler = uploadRequiredFileHandler;
        window.uploadRequiredFile = uploadRequiredFileHandler;

        window.updateFileStatus = function (key, input) {
            updateFileStatusInline(key, input);
        };

        window.addAdditionalFile = addAdditionalFile;
        window.addFile = addAdditionalFile;

        window.removeAdditionalFile = function (identifier) {
            removeAdditional(identifier);
        };

        window.validateStep3 = () => stepHandlers.validate();
        window.submitStep3 = () => stepHandlers.submit();

        document.addEventListener('DOMContentLoaded', () => {
            window.addAdditionalFile = addAdditionalFile;
            window.addFile = addAdditionalFile;
            initRequiredState();
            bindEvents();
            registerWizardIntegration();
            loadStepData();
        });

    })();
</script>
