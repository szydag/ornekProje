<?php
declare(strict_types=1);
?>
<?= $this->include('app/add-material/steps/add-material-step-2') ?>

<script>
(() => {
    const root = document.getElementById('content_update_root');
    const CONTENT_ID = Number(root?.dataset?.learningMaterialId ?? 0) || 0;
    const STEP_ENDPOINT = '/apps/update-material/step-2';

    const requeue = () => {
        if (!window.contentUpdate || !window.__contentStep2 || !window.__contentStep2State) {
            setTimeout(requeue, 120);
            return;
        }

        const step2Api = window.__contentStep2;
        const step2State = window.__contentStep2State;

        const fetchStep2 = async () => {
            if (!CONTENT_ID) return null;
            const response = await fetch(`${STEP_ENDPOINT}?learning_material_id=${CONTENT_ID}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok) {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            const data = json.data ?? {};
            const current = window.contentUpdate.getInitialPayload() ?? {};
            const merged = window.contentUpdate.merge({ ...current }, { authors: data.authors ?? [] });
            window.contentUpdate.setInitialPayload(merged);
            return data;
        };

        step2State.__deletedIds = step2State.__deletedIds || new Set();

        const originalRemove = window.step2Authors?.remove;
        if (window.step2Authors && !window.step2Authors.__wrappedForUpdate && typeof originalRemove === 'function') {
            window.step2Authors.remove = (index) => {
                const target = step2State.authors?.[index];
                if (target?.id) {
                    step2State.__deletedIds.add(Number(target.id));
                }
                return originalRemove(index);
            };
            window.step2Authors.__wrappedForUpdate = true;
        }

        step2Api.load = async () => {
            try {
                const payload = await fetchStep2();
                if (payload) {
                    step2Api.hydrate({ data: { authors: payload.authors ?? [] } });
                }
            } catch (error) {
                console.error('[ArticleUpdate] Step2 load failed', error);
            }
        };

        step2Api.validate = () => {
            step2Api.clearError();
            const regularAuthors = step2State.authors.filter((author) => author.type === 'author');
            
            if (!regularAuthors.length) {
                step2Api.showError('En az bir yazar eklemelisiniz.');
                return false;
            }
            
            // Sorumlu yazar kontrolü
            const correspondingAuthor = regularAuthors.find((author) => author.is_corresponding);
            if (!correspondingAuthor) {
                step2Api.showError('Bir sorumlu yazar seçmelisiniz.');
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
                step2Api.showError(`Sorumlu yazarın ${missingFieldLabels.join(', ')} bilgileri eksik. Lütfen tamamlayınız.`);
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
                step2Api.showError(`Sorumlu yazarın ${missingFieldLabels.join(', ')} bilgileri eksik. Lütfen tamamlayınız.`);
                return false;
            }
            
            return true;
        };

        step2Api.showError = (message) => {
            const errorElement = document.getElementById('authors-error');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        };

        step2Api.clearError = () => {
            const errorElement = document.getElementById('authors-error');
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        };

        step2Api.submit = async () => {
            if (!step2Api.validate()) {
                return Promise.reject(new Error('Validasyon hatası'));
            }
            const payload = step2Api.getPayload() ?? { authors: [] };
            const response = await fetch(`${STEP_ENDPOINT}?learning_material_id=${CONTENT_ID}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ step2: payload })
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok || json.status !== 'success') {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            return json;
        };

        const normalizeIncoming = (rawAuthors) => {
            if (!Array.isArray(rawAuthors)) return [];
            return rawAuthors.map((row, index) => {
                const type = String(row.type ?? 'author').toLowerCase() === 'translator' ? 'translator' : 'author';
                const rawCountry = row.country_id ?? row.countryId ?? row.country_code ?? row.countryCode ?? null;
                const countryId = rawCountry !== null && rawCountry !== '' ? Number(rawCountry) || null : null;
                const rawTitle = row.title_id ?? row.titleId ?? null;
                const titleId = rawTitle !== null && rawTitle !== '' ? Number(rawTitle) || null : null;

                return {
                    id: row.id ?? row.author_id ?? null,
                    type,
                    first_name: row.first_name ?? row.name ?? '',
                    last_name: row.last_name ?? row.surname ?? '',
                    email: row.email ?? row.mail ?? '',
                    is_corresponding: ['1', 1, true, 'true', 'yes', 'evet'].includes(
                        (row.is_corresponding ?? row.isCorresponding ?? (index === 0 ? 1 : 0))?.toString().toLowerCase()
                    ),
                    order: Number(row.order ?? row.order_number ?? row.position ?? index + 1) || index + 1,
                    affiliation: row.affiliation ?? row.institution ?? '',
                    affiliation_id: row.affiliation_id ?? row.institution_id ?? null,
                    orcid: row.orcid ?? null,
                    user_id: row.user_id ?? null,
                    phone: row.phone ?? '',
                    country_id: countryId,
                    country: row.country ?? '',
                    country_code: countryId !== null ? String(countryId) : null,
                    city: row.city ?? '',
                    title_id: titleId,
                    title: row.title ?? '',
                    address: row.address ?? '',
                };
            });
        };

        const applyIdsBack = (normalized, incoming) => {
            return normalized.map((author, index) => ({
                ...author,
                id: incoming[index]?.id ?? author.id ?? null,
            }));
        };

        window.contentUpdate.registerStep(2, {
            hydrate(resource) {
                const authors = normalizeIncoming(resource.authors ?? []);
                step2Api.hydrate({ data: { authors } });

                if (Array.isArray(step2State.authors)) {
                    step2State.authors = applyIdsBack(step2State.authors, authors);
                }
                if (!authors.some((author) => author.is_corresponding)) {
                    const first = step2State.authors?.find((author) => author.type === 'author');
                    if (first) first.is_corresponding = true;
                }
                if (window.contentWizard?.setCached) {
                    window.contentWizard.setCached(2, { status: 'ok', data: { authors } });
                    document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                        detail: { step: 2, payload: { data: { authors } } }
                    }));
                }
            },
            collect() {
                const payload = step2Api.getPayload() ?? { authors: [] };
                const authored = Array.isArray(payload.authors) ? payload.authors : [];

                const withIds = authored.map((author, index) => ({
                    ...author,
                    id: step2State.authors?.[index]?.id ?? author.id ?? null,
                }));

                const deletions = Array.from(step2State.__deletedIds ?? new Set());
                deletions.forEach((id) => {
                    if (!withIds.some((author) => Number(author.id) === Number(id))) {
                        withIds.push({ id: Number(id), delete: true });
                    }
                });

                return {
                    step2: {
                        authors: withIds,
                    },
                };
            },
        });

        if (CONTENT_ID) {
            fetchStep2().catch((error) => console.error('[ArticleUpdate] Step2 initial fetch failed', error));
        }
    };

    requeue();
})();
</script>
