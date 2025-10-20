<div class="kt-container-fixed p-0">
    <!-- Form Content - Step 1 -->
    <div class="flex flex-col items-stretch gap-5 lg:gap-7.5">

        <!-- Kurs Seçimi -->
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">
                    Kurs Seçimi <span class="text-danger">*</span>
                </h3>
            </div>
            <div class="kt-card-content">
                <div class="kt-form-field">
                    <label class="kt-form-label mb-2">
                        Hangi kursye içerik eklemek istiyorsunuz?
                    </label>
                    <select class="kt-select" data-kt-select="true" name="course" id="course_select"
                        data-kt-select-placeholder="Kurs seçiniz..." data-kt-select-enable-search="true"
                        data-kt-select-search-placeholder="Kurs ara...">
                        <option value="">Kurs seçiniz...</option>
                        <!-- Kursler JavaScript ile yüklenecek -->
                    </select>
                    <div class="kt-form-description text-2sm mt-1">
                        Eğitim içeriğinizi hangi kursye eklemek istediğinizi seçiniz
                    </div>
                    <div class="text-red-600 text-sm italic mt-1" id="course-error" style="display: none;"></div>
                </div>
            </div>
        </div>

        <!-- Step 1: Eğitim İçeriği Üst Verileri -->
        <div class="kt-card">
            <div class="kt-card-header" id="step_1">
                <h3 class="kt-card-title">
                    1. Eğitim İçeriği Üst Verileri
                </h3>
            </div>
            <div class="kt-card-content grid gap-5">
                <!-- İçerik Türü -->
                <div class="kt-form-field">
                    <label class="kt-form-label mb-2">
                        İçerik Türü Seç <span class="text-danger">*</span>
                    </label>
                    <select class="kt-select" data-kt-select="true" name="publication_type" id="publication_type"
                        data-kt-select-placeholder="Seçiniz">
                        <option value="">Seçiniz...</option>
                        <?php foreach ($contentTypes as $contentType): ?>
                            <option value="<?= $contentType['id'] ?>"><?= $contentType['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-red-600 text-sm italic mt-1" id="publication_type-error" style="display: none;">
                    </div>
                </div>

                <!-- Konular -->
                <div class="kt-form-field">
                    <label class="kt-form-label mb-2">
                        Konular <span class="text-danger">*</span>
                    </label>
                    <!-- Seçili konuları göster -->
                    <div id="selected_topics" class="mb-2 hidden">
                        <div class="flex flex-wrap gap-1"></div>
                    </div>

                    <!-- Dropdown container -->
                    <div class="relative">
                        <input type="text" class="kt-input" id="topics_search" placeholder="Konu arayın veya seçin..."
                            autocomplete="off" readonly onclick="toggleTopicsDropdown()">

                        <!-- Dropdown -->
                        <div id="topics_dropdown"
                            class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-64 overflow-auto">
                            <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                                <input type="text" class="kt-input" id="topics_filter" placeholder="Konu ara..."
                                    autocomplete="off" oninput="filterTopics()">
                            </div>
                            <div id="topicsList" class="p-2">
                                <?php if (isset($topics) && !empty($topics)): ?>
                                    <?php foreach ($topics as $topicId => $topicName): ?>
                                        <div class="topic-item flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer"
                                            data-value="<?= esc($topicId) ?>" data-topic="<?= esc($topicName) ?>"
                                            onclick="selectTopic('<?= esc($topicId) ?>', '<?= esc($topicName) ?>')">
                                            <span class="text-sm"><?= esc($topicName) ?></span>
                                        </div>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <p class="text-gray-500 text-center py-4">Konu bulunamadı</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="kt-form-description text-2sm mt-1">
                        En az bir konu seçiniz
                    </div>

                    <!-- Hidden input for selected topics -->
                    <input type="hidden" name="topics" id="topics_hidden" value="">
                    <div class="text-red-600 text-sm italic mt-1" id="topics-error" style="display: none;"></div>
                </div>

                <!-- Birinci Dil -->
                <div class="kt-form-field">
                    <label class="kt-form-label  mb-2">
                        Birinci Dil <span class="text-danger">*</span>
                    </label>
                    <div class="flex gap-6">
                        <label class="kt-checkbox-group"
                            style="display: flex; flex-direction: row; align-items: center; gap: 8px;">
                            <input class="kt-checkbox" name="language" type="checkbox" value="tr"
                                onchange="handleLanguageSelection(this)" />
                            <span class="kt-checkbox-label">Türkçe</span>
                        </label>
                        <label class="kt-checkbox-group"
                            style="display: flex; flex-direction: row; align-items: center; gap: 8px;">
                            <input class="kt-checkbox" name="language" type="checkbox" value="en"
                                onchange="handleLanguageSelection(this)" />
                            <span class="kt-checkbox-label">İngilizce</span>
                        </label>
                    </div>
                    <div class="text-red-600 text-sm italic mt-1" id="language-error" style="display: none;"></div>
                </div>

                <!-- Türkçe Bilgiler Kartı -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Türkçe Bilgiler</h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="flex flex-col gap-5">
                            <!-- Başlık Türkçe -->
                            <div class="kt-form-field mt-4">
                                <label class="kt-form-label mb-2">
                                    Başlık <span class="text-danger">*</span>
                                </label>
                                <input class="kt-input" name="title_tr" id="title_tr" type="text"
                                    placeholder="Eğitim İçeriği başlığını giriniz" />
                                <div class="text-red-600 text-sm italic mt-1" id="title_tr-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Kısa Başlık Türkçe -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Kısa Başlık
                                </label>
                                <input class="kt-input" name="short_title_tr" type="text"
                                    placeholder="Kısa başlık giriniz" />
                                <div class="text-red-600 text-sm italic mt-1" id="short_title_tr-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Anahtar Kelimeler Türkçe -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Anahtar Kelimeler <span class="text-danger">*</span>
                                </label>
                                <!-- Anahtar kelime kutucukları -->
                                <div id="keywords_tr_container" class="mb-2 hidden">
                                    <div class="flex flex-wrap gap-1"></div>
                                </div>

                                <!-- Input alanı -->
                                <input class="kt-input" id="keywords_tr_input" type="text"
                                    placeholder="Anahtar kelime girin ve Enter'a basın"
                                    onkeypress="handleKeywordInput(event, 'tr')" />

                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="keywords_tr" id="keywords_tr_hidden" />

                                <div class="kt-form-description text-2sm mt-1">
                                    En az 3 kelime giriniz, Enter ile ekleyin
                                </div>
                                <div class="text-red-600 text-sm italic mt-1" id="keywords_tr-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Öz Türkçe -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Öz <span class="text-danger">*</span>
                                </label>
                                <textarea class="kt-textarea" name="abstract_tr" id="abstract_tr" rows="6"
                                    placeholder="Eğitim İçeriği özünü giriniz" oninput="updateCharacterCount('abstract_tr', 50, 2000)"></textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <div class="kt-form-description text-2sm">
                                        En az 50, en fazla 2000 karakter
                                    </div>
                                    <div class="text-sm text-muted-foreground" id="abstract_tr_counter">
                                        <span id="abstract_tr_count">0</span>/2000
                                    </div>
                                </div>
                                <div class="text-red-600 text-sm italic mt-1" id="abstract_tr-error"
                                    style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İngilizce Bilgiler Kartı -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">İngilizce Bilgiler</h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="flex flex-col gap-5">
                            <!-- Başlık İngilizce -->
                            <div class="kt-form-field mt-4">
                                <label class="kt-form-label mb-2">
                                    Başlık <span class="text-danger">*</span>
                                </label>
                                <input class="kt-input" name="title_en" id="title_en" type="text"
                                    placeholder="Eğitim İçeriği başlığını İngilizce olarak giriniz" />
                                <div class="text-red-600 text-sm italic mt-1" id="title_en-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Kısa Başlık İngilizce -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Kısa Başlık
                                </label>
                                <input class="kt-input" name="short_title_en" type="text"
                                    placeholder="Kısa başlığı İngilizce olarak giriniz" />
                                <div class="text-red-600 text-sm italic mt-1" id="short_title_en-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Anahtar Kelimeler İngilizce -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Anahtar Kelimeler <span class="text-danger">*</span>
                                </label>
                                <!-- Anahtar kelime kutucukları -->
                                <div id="keywords_en_container" class="mb-2 hidden">
                                    <div class="flex flex-wrap gap-1"></div>
                                </div>

                                <!-- Input alanı -->
                                <input class="kt-input" id="keywords_en_input" type="text"
                                    placeholder="Anahtar kelimeleri İngilizce olarak girin ve Enter'a basın"
                                    onkeypress="handleKeywordInput(event, 'en')" />

                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="keywords_en" id="keywords_en_hidden" />

                                <div class="kt-form-description text-2sm mt-1">
                                    En az 3 İngilizce kelime giriniz, Enter ile ekleyin
                                </div>
                                <div class="text-red-600 text-sm italic mt-1" id="keywords_en-error"
                                    style="display: none;"></div>
                            </div>

                            <!-- Öz İngilizce -->
                            <div class="kt-form-field">
                                <label class="kt-form-label mb-2">
                                    Öz <span class="text-danger">*</span>
                                </label>
                                <textarea class="kt-textarea" name="abstract_en" id="abstract_en" rows="6"
                                    placeholder="Eğitim İçeriği özünü İngilizce olarak giriniz" oninput="updateCharacterCount('abstract_en', 50, 2000)"></textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <div class="kt-form-description text-2sm">
                                        En az 50, en fazla 2000 karakter
                                    </div>
                                    <div class="text-sm text-muted-foreground" id="abstract_en_counter">
                                        <span id="abstract_en_count">0</span>/2000
                                    </div>
                                </div>
                                <div class="text-red-600 text-sm italic mt-1" id="abstract_en-error"
                                    style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Etik Beyan -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Etik Beyan</h3>
                    </div>
                    <div class="kt-card-content">
                        <label class="kt-checkbox-group"
                            style="display: flex; flex-direction: row; align-items: center; gap: 8px;">
                            <input class="kt-checkbox" name="no_other_journal" id="no_other_journal" type="checkbox"
                                value="1" required />
                            <span class="kt-checkbox-label">
                                Eğitim İçeriğimi aynı anda değerlendirmek üzere başka bir dergiye göndermediğimi beyan ederim.
                            </span>
                        </label>
                        <div class="text-red-600 text-sm italic mt-1" id="no_other_journal-error"
                            style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function toggleTopicsDropdown() {
        const dropdown = document.getElementById('topics_dropdown');
        const filterInput = document.getElementById('topics_filter');
        if (!dropdown) return;

        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden') && filterInput) {
            setTimeout(() => filterInput.focus(), 100);
        }
    }

    function filterTopics() {
        const filterValue = document.getElementById('topics_filter').value.toLowerCase();
        const items = document.querySelectorAll('.topic-item');

        items.forEach(item => {
            const topicName = item.getAttribute('data-topic').toLowerCase();
            item.style.display = topicName.includes(filterValue) ? 'flex' : 'none';
        });
    }

    let selectedTopics = [];

    const step1SelectionCache = {
        course: null,
        contentType: null,
    };

    function rememberCourseSelection(value) {
        const normalized = value !== null && value !== undefined && value !== '' ? String(value) : null;
        step1SelectionCache.course = normalized;
    }

    function rememberPublicationTypeSelection(value) {
        const normalized = value !== null && value !== undefined && value !== '' ? String(value) : null;
        step1SelectionCache.contentType = normalized;
    }

    function applySelectValue(select, targetValue) {
        if (!select) return;
        const normalized = targetValue !== null && targetValue !== undefined && targetValue !== '' ? String(targetValue) : '';
        if (!normalized) {
            if (select.dataset) select.dataset.pendingValue = '';
            return;
        }

        const options = Array.from(select.options ?? []);
        const optionExists = options.some((option) => option.value === normalized);
        if (!optionExists) {
            if (select.dataset) select.dataset.pendingValue = normalized;
            return;
        }

        options.forEach((option) => {
            option.selected = option.value === normalized;
        });

        const changed = select.value !== normalized;
        select.value = normalized;
        if (select.dataset) {
            select.dataset.pendingValue = '';
            select.dataset.ktSelectValue = normalized;
        }
        select.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function applyStep1Selections() {
        const courseSelect = document.getElementById('course_select');
        const courseTarget = step1SelectionCache.course ?? courseSelect?.dataset?.pendingValue ?? null;
        applySelectValue(courseSelect, courseTarget);

        const publicationSelect = document.getElementById('publication_type');
        const publicationTarget = step1SelectionCache.contentType ?? publicationSelect?.dataset?.pendingValue ?? null;
        applySelectValue(publicationSelect, publicationTarget);
    }

    function selectTopic(value, label) {
        if (selectedTopics.find(topic => topic.value === value)) {
            removeTopicSelection(value);
            return;
        }

        selectedTopics.push({
            value,
            label
        });
        window.updateSelectedTopics();

        const topicItem = document.querySelector(`[data-value="${value}"]`);
        if (topicItem) {
            topicItem.style.display = 'none';
        }
    }

    window.updateSelectedTopics = function () {
        const selectedContainer = document.getElementById('selected_topics');
        const selectedDiv = selectedContainer.querySelector('div');
        const searchInput = document.getElementById('topics_search');
        const hiddenInput = document.getElementById('topics_hidden');

        selectedDiv.innerHTML = '';

        if (selectedTopics.length > 0) {
            selectedContainer.classList.remove('hidden');

            selectedTopics.forEach(topic => {
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center px-2 py-1 text-xs bg-primary/10 text-primary rounded-full';
                badge.innerHTML = `${topic.label} <button type="button" class="ml-1 text-primary hover:text-primary-dark" onclick="removeTopicSelection('${topic.value}')">×</button>`;
                selectedDiv.appendChild(badge);
            });

            searchInput.value = `${selectedTopics.length} konu seçildi`;
            hiddenInput.value = selectedTopics.map(topic => topic.value).join(',');
        } else {
            selectedContainer.classList.add('hidden');
            searchInput.value = '';
            hiddenInput.value = '';
        }
    };

    function removeTopicSelection(value) {
        selectedTopics = selectedTopics.filter(topic => topic.value !== value);
        window.updateSelectedTopics();

        const topicItem = document.querySelector(`[data-value="${value}"]`);
        if (topicItem) {
            topicItem.style.display = 'flex';
        }
    }

    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('topics_dropdown');
        const searchInput = document.getElementById('topics_search');
        if (!dropdown || !searchInput) return;

        if (!dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.classList.add('hidden');
        }
    });

    const keywords = {
        tr: [],
        en: []
    };

    function handleKeywordInput(event, language) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = event.target;
            const keyword = input.value.trim();

            if (keyword && !keywords[language].includes(keyword)) {
                window.addKeyword(keyword, language);
                input.value = '';
            }
        }
    }

    window.addKeyword = function (keyword, language) {
        keywords[language].push(keyword);
        updateKeywordDisplay(language);
        updateHiddenInput(language);
    };

    function removeKeyword(keyword, language) {
        const index = keywords[language].indexOf(keyword);
        if (index > -1) {
            keywords[language].splice(index, 1);
            updateKeywordDisplay(language);
            updateHiddenInput(language);
        }
    }

    function updateKeywordDisplay(language) {
        const container = document.getElementById(`keywords_${language}_container`);
        const innerDiv = container.querySelector('div');

        innerDiv.innerHTML = '';

        if (keywords[language].length > 0) {
            container.classList.remove('hidden');

            keywords[language].forEach(keyword => {
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center px-2 py-1 text-xs bg-primary/10 text-primary rounded-full';
                badge.innerHTML = `${keyword} <button type="button" class="ml-1 text-primary hover:text-primary-dark" onclick="removeKeyword('${keyword}', '${language}')" title="Kaldır">×</button>`;
                innerDiv.appendChild(badge);
            });
        } else {
            container.classList.add('hidden');
        }
    }

    function updateHiddenInput(language) {
        const hiddenInput = document.getElementById(`keywords_${language}_hidden`);
        hiddenInput.value = keywords[language].join(', ');
    }

    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.color = '#dc2626';
        }

        const inputElement = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
        if (inputElement) {
            inputElement.classList.add('border-red-600', '!border-red-600');
        }
    }

    function clearFieldError(fieldName) {
        const errorElement = document.getElementById(fieldName + '-error');
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }

        const inputElement = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
        if (inputElement) {
            inputElement.classList.remove('border-red-600', '!border-red-600', 'border-red-500', '!border-red-500');
        }
    }

    function clearAllErrors() {
        ['course', 'publication_type', 'topics', 'language', 'title_tr', 'short_title_tr', 'abstract_tr', 'title_en', 'short_title_en', 'abstract_en', 'no_other_journal', 'keywords_tr', 'keywords_en'].forEach(field => {
            clearFieldError(field);
        });
    }

    // Kurs verilerini çek
    async function loadCourses() {
        try {
            const response = await fetch('<?= site_url('app/courses') ?>?full=1', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const responseData = await response.json();

            // Response yapısını kontrol et
            const data = responseData.data || responseData;

            const courseSelect = document.getElementById('course_select');

            if (!courseSelect || !data || !Array.isArray(data)) {
                console.warn('Kurs select elementi bulunamadı veya veri geçersiz');
                console.warn('Data type:', typeof data);
                console.warn('Is array:', Array.isArray(data));
                return;
            }

            // Mevcut option'ları temizle (ilk option hariç)
            courseSelect.innerHTML = '<option value="">Kurs seçiniz...</option>';

            data.forEach((course, index) => {
                const option = document.createElement('option');
                option.value = course.id;
                option.textContent = course.title || course.name || `Kurs ${course.id}`;
                courseSelect.appendChild(option);
            });
            applyStep1Selections();

            // KT-Select'i yeniden initialize et
            setTimeout(() => {
                if (typeof KTSearch !== 'undefined' && KTSearch.getInstance(courseSelect)) {
                    KTSearch.getInstance(courseSelect).destroy();
                }

                if (typeof KTSearch !== 'undefined') {
                    new KTSearch(courseSelect);
                    applyStep1Selections();
                } else {
                    applyStep1Selections();
                }
            }, 100);
        } catch (error) {
            console.error('Kursler yüklenirken hata:', error);

            // Hata durumunda kullanıcıya bilgi ver
            const courseSelect = document.getElementById('course_select');
            if (courseSelect) {
                courseSelect.innerHTML = '<option value="">Kursler yüklenemedi</option>';
            }
        }
    }

    function updateCharacterCount(fieldId, minLength, maxLength) {
        const textarea = document.getElementById(fieldId);
        const countElement = document.getElementById(fieldId + '_count');
        const counterElement = document.getElementById(fieldId + '_counter');
        
        if (!textarea || !countElement || !counterElement) return;
        
        const currentLength = textarea.value.length;
        countElement.textContent = currentLength;
        
        // Renk değişimi
        if (currentLength < minLength) {
            counterElement.className = 'text-sm text-red-600';
        } else if (currentLength > maxLength) {
            counterElement.className = 'text-sm text-red-600';
        } else {
            counterElement.className = 'text-sm text-muted-foreground';
        }
        
        // Textarea border rengi
        if (currentLength < minLength) {
            textarea.classList.add('border-red-500');
            textarea.classList.remove('border-green-500');
        } else if (currentLength > maxLength) {
            textarea.classList.add('border-red-500');
            textarea.classList.remove('border-green-500');
        } else {
            textarea.classList.add('border-green-500');
            textarea.classList.remove('border-red-500');
        }
        
        // Hata mesajı göster/gizle
        if (currentLength > maxLength) {
            showFieldError(fieldId, `En fazla ${maxLength} karakter girebilirsiniz. Şu anda ${currentLength} karakter var.`);
        } else if (currentLength < minLength && currentLength > 0) {
            showFieldError(fieldId, `En az ${minLength} karakter girmelisiniz. Şu anda ${currentLength} karakter var.`);
        } else {
            clearFieldError(fieldId);
        }
    }

    function validateStep1() {
        clearAllErrors();

        let hasErrors = false;

        const validations = [{
            fieldName: 'course',
            condition: () => !document.querySelector('select[name="course"]')?.value,
            message: 'Kurs seçmelisiniz.',
            focus: 'course_select'
        },
        {
            fieldName: 'publication_type',
            condition: () => !document.querySelector('select[name="publication_type"]')?.value,
            message: 'Yayın türü seçmelisiniz.',
            focus: 'publication_type'
        },
        {
            fieldName: 'topics',
            condition: () => !document.getElementById('topics_hidden')?.value,
            message: 'En az bir konu seçmelisiniz.',
            focus: 'topics_search'
        },
        {
            fieldName: 'language',
            condition: () => !document.querySelector('input[name="language"]:checked'),
            message: 'Bir dil seçmelisiniz.'
        },
        {
            fieldName: 'title_tr',
            condition: () => !document.querySelector('input[name="title_tr"]')?.value.trim(),
            message: 'Türkçe başlık girmelisiniz.',
            focus: 'title_tr'
        },
        {
            fieldName: 'short_title_tr',
            condition: () => !document.querySelector('input[name="short_title_tr"]')?.value.trim(),
            message: 'Türkçe kısa başlık girmelisiniz.',
            focus: 'short_title_tr'
        },
        {
            fieldName: 'abstract_tr',
            condition: () => {
                const value = document.querySelector('textarea[name="abstract_tr"]')?.value.trim() || '';
                return !value || value.length < 50 || value.length > 2000;
            },
            message: 'Türkçe öz en az 50, en fazla 2000 karakter olmalıdır.',
            focus: 'abstract_tr'
        },
        {
            fieldName: 'title_en',
            condition: () => !document.querySelector('input[name="title_en"]')?.value.trim(),
            message: 'İngilizce başlık girmelisiniz.',
            focus: 'title_en'
        },
        {
            fieldName: 'short_title_en',
            condition: () => !document.querySelector('input[name="short_title_en"]')?.value.trim(),
            message: 'İngilizce kısa başlık girmelisiniz.',
            focus: 'short_title_en'
        },
        {
            fieldName: 'abstract_en',
            condition: () => {
                const value = document.querySelector('textarea[name="abstract_en"]')?.value.trim() || '';
                return !value || value.length < 50 || value.length > 2000;
            },
            message: 'İngilizce öz en az 50, en fazla 2000 karakter olmalıdır.',
            focus: 'abstract_en'
        },
        {
            fieldName: 'no_other_journal',
            condition: () => !document.querySelector('input[name="no_other_journal"]')?.checked,
            message: 'Etik Beyan\'ı kabul etmelisiniz.'
        },
        {
            fieldName: 'keywords_tr',
            condition: () => keywords.tr.length < 3,
            message: 'Türkçe en az 3 anahtar kelime girmelisiniz.'
        },
        {
            fieldName: 'keywords_en',
            condition: () => keywords.en.length < 3,
            message: 'İngilizce en az 3 anahtar kelime girmelisiniz.'
        }
        ];

        validations.forEach(validation => {
            if (validation.condition()) {
                showFieldError(validation.fieldName, validation.message);
                if (!hasErrors && validation.focus) {
                    const focusElement = document.getElementById(validation.focus) || document.querySelector(`[name="${validation.focus}"]`);
                    if (focusElement) focusElement.focus();
                }
                hasErrors = true;
            }
        });

        return !hasErrors;
    }

    function getPublicationTypeSelect() {
        return document.getElementById('publication_type');
    }

    function dispatchPublicationTypeChange() {
        const select = getPublicationTypeSelect();
        if (!select) return;
        const label = select.selectedOptions?.[0]?.textContent?.trim() ?? '';
        const value = select.value ?? '';
        const isTranslation = label.toLowerCase().includes('çeviri');
        document.dispatchEvent(new CustomEvent('content-wizard:step1-publication-change', {
            detail: {
                value,
                label,
                isTranslation,
            },
        }));
    }

    function collectStep1Payload() {
        dispatchPublicationTypeChange();
        const courseSelect = document.querySelector('select[name="course"]');
        const courseId = courseSelect ? parseInt(courseSelect.value, 10) || 0 : 0;

        const publicationSelect = getPublicationTypeSelect();
        const contentTypeId = publicationSelect ? parseInt(publicationSelect.value, 10) || 0 : 0;
        const contentTypeLabel = publicationSelect?.selectedOptions?.[0]?.textContent?.trim() ?? '';
        const isTranslationPublication = contentTypeLabel.toLowerCase().includes('çeviri');

        const topics = selectedTopics
            .map(topic => Number(topic.value))
            .filter(value => Number.isFinite(value) && value > 0);

        const primaryLanguageInput = document.querySelector('input[name="language"]:checked');
        const primaryLanguage = primaryLanguageInput ? primaryLanguageInput.value : '';

        return {
            course_id: courseId,
            content_type_id: contentTypeId,
            topics,
            primary_language: primaryLanguage,
            title_tr: document.querySelector('input[name="title_tr"]')?.value.trim() ?? '',
            short_title_tr: document.querySelector('input[name="short_title_tr"]')?.value.trim() ?? '',
            keywords_tr: keywords.tr.join(', '),
            abstract_tr: document.querySelector('textarea[name="abstract_tr"]')?.value.trim() ?? '',
            title_en: document.querySelector('input[name="title_en"]')?.value.trim() ?? '',
            short_title_en: document.querySelector('input[name="short_title_en"]')?.value.trim() ?? '',
            keywords_en: keywords.en.join(', '),
            abstract_en: document.querySelector('textarea[name="abstract_en"]')?.value.trim() ?? '',
            no_other_journal: !!document.querySelector('input[name="no_other_journal"]')?.checked,
            publication_type_label: contentTypeLabel,
            is_translation_publication: isTranslationPublication,
        };
    }

    function parseNumberList(value) {
        if (Array.isArray(value)) {
            return value.map(item => Number(item)).filter(Number.isFinite);
        }

        if (typeof value === 'string') {
            return value
                .split(',')
                .map(item => Number(item.trim()))
                .filter(Number.isFinite);
        }

        return [];
    }

    function applySelectedTopics(topicIds) {
        const list = parseNumberList(topicIds);
        const topicElements = document.querySelectorAll('.topic-item');

        topicElements.forEach(item => {
            item.style.display = 'flex';
        });

        selectedTopics = [];

        list.forEach(id => {
            const value = String(id);
            const topicItem = document.querySelector(`.topic-item[data-value="${value}"]`);
            const label = topicItem?.getAttribute('data-topic') ?? value;

            selectedTopics.push({
                value,
                label
            });

            if (topicItem) {
                topicItem.style.display = 'none';
            }
        });

        window.updateSelectedTopics();
    }

    function hydrateKeywords(language, rawValue) {
        const list = Array.isArray(rawValue) ?
            rawValue.map(item => String(item).trim()).filter(Boolean) :
            String(rawValue ?? '')
                .split(',')
                .map(item => item.trim())
                .filter(Boolean);

        keywords[language] = list;
        updateKeywordDisplay(language);
        updateHiddenInput(language);
    }

    function hydrateStep1(payload) {
        const data = payload?.data ?? {};
        if (!Object.keys(data).length) {
            return;
        }

        // Kurs seçimi
        const courseSelect = document.getElementById('course_select');
        const courseValue = data.course_id ?? data.course ?? null;
        rememberCourseSelection(courseValue);
        applySelectValue(courseSelect, step1SelectionCache.course);

        const publicationSelect = document.getElementById('publication_type');
        const publicationValue = data.content_type_id ?? data.publication_type ?? null;
        rememberPublicationTypeSelection(publicationValue);
        applySelectValue(publicationSelect, step1SelectionCache.contentType);
        dispatchPublicationTypeChange();

        if (data.topics) {
            applySelectedTopics(data.topics);
        }

        if (data.primary_language) {
            const languageCheckbox = document.querySelector(`input[name="language"][value="${data.primary_language}"]`);
            if (languageCheckbox) {
                languageCheckbox.checked = true;
                handleLanguageSelection(languageCheckbox);
            }
        }

        const assignValue = (selector, value) => {
            const element = document.querySelector(selector);
            if (element) {
                element.value = value ?? '';
            }
        };

        assignValue('input[name="title_tr"]', data.title_tr);
        assignValue('input[name="short_title_tr"]', data.short_title_tr);
        assignValue('textarea[name="abstract_tr"]', data.abstract_tr);
        assignValue('input[name="title_en"]', data.title_en);
        assignValue('input[name="short_title_en"]', data.short_title_en);
        assignValue('textarea[name="abstract_en"]', data.abstract_en);

        hydrateKeywords('tr', data.keywords_tr);
        hydrateKeywords('en', data.keywords_en);

        const ethicsCheckbox = document.querySelector('input[name="no_other_journal"]');
        if (ethicsCheckbox) {
            const raw = data.no_other_journal ?? data.noOtherJournal ?? false;
            ethicsCheckbox.checked = raw === true || raw === 1 || raw === '1' || raw === 'true';
        }
    }


    async function loadStep1SessionData() {
        try {
            const response = await fetch('/apps/add-material/step-1', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json();
            if (payload?.status === 'ok' || payload?.status === 'success') {
                hydrateStep1(payload);
            }
        } catch (error) {
            console.warn('[Step1] Oturum verisi alınamadı', error);
        }
    }

    let step1WizardBound = false;

    function registerStep1Integrations() {
        if (step1WizardBound) {
            return;
        }

        if (!window.contentWizard) {
            setTimeout(registerStep1Integrations, 100);
            return;
        }

        window.contentWizard.registerHydrator(1, hydrateStep1);
        window.contentWizard.registerCollector(1, collectStep1Payload);
        window.contentWizard.registerValidator(1, validateStep1);

        step1WizardBound = true;
    }

    function submitStep1() {
        return new Promise((resolve, reject) => {
            const payload = collectStep1Payload();

            fetch('/apps/add-material/step-1', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(payload),
            })
                .then(async response => {
                    let data = null;
                    try {
                        data = await response.json();
                    } catch (parseError) {
                        // JSON parse hatası
                    }

                    if (!response.ok) {
                        const message = data?.error ?? `HTTP ${response.status}`;
                        throw message;
                    }

                    if (!data || data.status !== 'success') {
                        throw (data?.error ?? 'Beklenmeyen bir hata oluştu.');
                    }

                    resolve(data);
                })
                .catch(error => {
                    reject(typeof error === 'string' ?
                        error :
                        'Form gönderilirken bir hata oluştu. Lütfen tekrar deneyin.');
                });
        });
    }

    function setupValidationListeners() {
        const courseSelect = document.getElementById('course_select');
        if (courseSelect) {
            courseSelect.addEventListener('change', () => clearFieldError('course'));
        }

        const pubType = document.getElementById('publication_type');
        if (pubType) {
            pubType.addEventListener('change', () => {
                clearFieldError('publication_type');
                dispatchPublicationTypeChange();
            });
            // İlk değer için de tetikle
            dispatchPublicationTypeChange();
        }

        const topicsHidden = document.getElementById('topics_hidden');
        if (topicsHidden) {
            const originalUpdateSelectedTopics = window.updateSelectedTopics;
            window.updateSelectedTopics = function () {
                originalUpdateSelectedTopics();
                clearFieldError('topics');
            };
        }

        document.querySelectorAll('input[name="language"]').forEach(input => {
            input.addEventListener('change', () => clearFieldError('language'));
        });

        const titleTr = document.getElementById('title_tr');
        if (titleTr) {
            titleTr.addEventListener('input', () => clearFieldError('title_tr'));
        }

        const shortTitleTr = document.querySelector('input[name="short_title_tr"]');
        if (shortTitleTr) {
            shortTitleTr.addEventListener('input', () => clearFieldError('short_title_tr'));
        }

        const abstractTr = document.getElementById('abstract_tr');
        if (abstractTr) {
            abstractTr.addEventListener('input', () => clearFieldError('abstract_tr'));
        }

        const titleEn = document.getElementById('title_en');
        if (titleEn) {
            titleEn.addEventListener('input', () => clearFieldError('title_en'));
        }

        const shortTitleEn = document.querySelector('input[name="short_title_en"]');
        if (shortTitleEn) {
            shortTitleEn.addEventListener('input', () => clearFieldError('short_title_en'));
        }

        const abstractEn = document.getElementById('abstract_en');
        if (abstractEn) {
            abstractEn.addEventListener('input', () => clearFieldError('abstract_en'));
        }

        const ethics = document.getElementById('no_other_journal');
        if (ethics) {
            ethics.addEventListener('change', () => clearFieldError('no_other_journal'));
        }

        const originalAddKeyword = window.addKeyword;
        window.addKeyword = function (keyword, language) {
            originalAddKeyword(keyword, language);
            if (keywords[language].length >= 3) {
                clearFieldError('keywords_' + language);
            }
        };
    }

    function handleLanguageSelection(clickedCheckbox) {
        const languageCheckboxes = document.querySelectorAll('input[name="language"]');

        if (clickedCheckbox.checked) {
            languageCheckboxes.forEach(box => {
                if (box !== clickedCheckbox) {
                    box.checked = false;
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Karakter sayacını başlat
        updateCharacterCount('abstract_tr', 50, 2000);
        updateCharacterCount('abstract_en', 50, 2000);
        
        setupValidationListeners();
        const courseSelect = document.getElementById('course_select');
        if (courseSelect) {
            courseSelect.addEventListener('change', () => {
                rememberCourseSelection(courseSelect.value);
                if (courseSelect.dataset) courseSelect.dataset.pendingValue = '';
            });
            if (courseSelect.value) {
                rememberCourseSelection(courseSelect.value);
            }
        }
        const publicationSelect = document.getElementById('publication_type');
        if (publicationSelect) {
            publicationSelect.addEventListener('change', () => {
                rememberPublicationTypeSelection(publicationSelect.value);
                if (publicationSelect.dataset) publicationSelect.dataset.pendingValue = '';
            });
            if (publicationSelect.value) {
                rememberPublicationTypeSelection(publicationSelect.value);
            }
        }
        loadCourses();
        loadStep1SessionData();
        registerStep1Integrations();

        setTimeout(() => {
            const selectboxes = document.querySelectorAll('select.kt-select');
            selectboxes.forEach(select => {
                if (typeof initCleanSelectbox === 'function') {
                    initCleanSelectbox(select);
                }
            });
            applyStep1Selections();
        }, 100);
    });
</script>
