<?php
declare(strict_types=1);

/**
 * Controller’dan $learningMaterialId opsiyonel gelebilir.
 * Gelmezse JS tarafında body[data-content-id] vb. fallback’ler çalışıyor.
 */
$learningMaterialId ??= null;
?>
<?= $this->include('app/add-material/steps/add-material-step-1') ?>

<script>
(() => {
    const root = document.getElementById('content_update_root');
    const CONTENT_ID = Number(root?.dataset?.learningMaterialId ?? 0) || 0;
    const STEP_ENDPOINT = '/apps/update-material/step-1';

    if (!window.contentUpdate) {
        const createManager = () => {
            const steps = new Map();
            let initialPayload = null;

            const merge = (target, source) => {
                if (!source || typeof source !== 'object') return target;
                Object.entries(source).forEach(([key, value]) => {
                    if (Array.isArray(value)) {
                        target[key] = value;
                    } else if (value && typeof value === 'object') {
                        target[key] = merge(target[key] ? { ...target[key] } : {}, value);
                    } else {
                        target[key] = value;
                    }
                });
                return target;
            };

            return {
                learningMaterialId: CONTENT_ID || null,
                registerStep(step, handlers) {
                    const numeric = Number(step);
                    steps.set(numeric, handlers);
                    if (initialPayload && typeof handlers?.hydrate === 'function') {
                        try {
                            handlers.hydrate(initialPayload);
                        } catch (error) {
                            console.error(`[ArticleUpdate] Step ${numeric} hydrate failed`, error);
                        }
                    }
                },
                setInitialPayload(payload) {
                    initialPayload = payload;
                    steps.forEach((handlers, step) => {
                        if (typeof handlers?.hydrate === 'function') {
                            try {
                                handlers.hydrate(initialPayload);
                            } catch (error) {
                                console.error(`[ArticleUpdate] Step ${step} hydrate failed`, error);
                            }
                        }
                    });
                    document.dispatchEvent(new CustomEvent('content-update:hydrated', {
                        detail: { payload: initialPayload }
                    }));
                },
                getInitialPayload() {
                    return initialPayload;
                },
                merge,
                collect() {
                    const collected = {};
                    steps.forEach((handlers, step) => {
                        if (typeof handlers?.collect === 'function') {
                            try {
                                merge(collected, handlers.collect());
                            } catch (error) {
                                console.error(`[ArticleUpdate] Step ${step} collect failed`, error);
                            }
                        }
                    });
                    return collected;
                },
                async submit({ learningMaterialId = this.learningMaterialId } = {}) {
                    if (!learningMaterialId) {
                        throw new Error('Eğitim İçeriği kimliği bulunamadı (submit).');
                    }
                    const payload = this.collect();
                    const response = await fetch(`/updates/materials/${learningMaterialId}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(payload)
                    });
                    const json = await response.json().catch(() => ({}));
                    if (!response.ok) {
                        throw new Error(json.error ?? `HTTP ${response.status}`);
                    }
                    return json;
                },
            };
        };

        window.contentUpdate = createManager();
    }

    if (CONTENT_ID && !window.contentUpdate.learningMaterialId) {
        window.contentUpdate.learningMaterialId = CONTENT_ID;
    }

    const toArray = (value) => {
        if (Array.isArray(value)) return value;
        if (typeof value === 'string') {
            try {
                const parsed = JSON.parse(value);
                if (Array.isArray(parsed)) return parsed;
            } catch (_ignored) {}
            return value
                .split(',')
                .map((item) => Number(item.trim()))
                .filter(Number.isFinite);
        }
        return [];
    };

    const buildStep1Data = (resource) => {
        const content = resource.content ?? {};
        const translations = Array.isArray(resource.translations)
            ? resource.translations.reduce((carry, row) => {
                if (row?.lang) carry[row.lang] = row;
                return carry;
            }, {})
            : {};

        const tr = translations.tr ?? {};
        const en = translations.en ?? {};
        const extra = Array.isArray(resource.extra) ? resource.extra : [];

        const firstLanguage = content.first_language ?? content.primary_language ?? 'tr';
        const topics = toArray(content.topics ?? content.topic_ids ?? []);

        const ethicsSlot = extra.find((row) => (row.lang ?? '').toLowerCase() === 'tr');
        const ethicsAccepted = Boolean(ethicsSlot?.ethics_declaration ?? ethicsSlot?.ethics_statement ?? false);

        return {
            course_id: content.course_id ?? content.course ?? '',
            content_type_id: content.content_type_id ?? content.publication_type ?? '',
            topics,
            primary_language: firstLanguage,
            title_tr: tr.title ?? '',
            short_title_tr: tr.short_title ?? '',
            keywords_tr: tr.keywords ?? '',
            abstract_tr: tr.self_description ?? '',
            title_en: en.title ?? '',
            short_title_en: en.short_title ?? '',
            keywords_en: en.keywords ?? '',
            abstract_en: en.self_description ?? '',
            no_other_journal: ethicsAccepted,
        };
    };

    const fetchStep1 = async () => {
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
        const merged = window.contentUpdate.merge({ ...current }, data);
        window.contentUpdate.setInitialPayload(merged);
        return data;
    };

    const assignOverrides = () => {
        if (typeof window.collectStep1Payload !== 'function' || typeof window.hydrateStep1 !== 'function') {
            setTimeout(assignOverrides, 60);
            return;
        }

        window.loadStep1SessionData = async function () {
            if (!CONTENT_ID) return;
            try {
                await fetchStep1();
            } catch (error) {
                console.error('[Update Step1] hydrate error', error);
            }
        };

        window.submitStep1 = async function () {
            if (!CONTENT_ID) {
                return Promise.reject(new Error('Eğitim İçeriği kimliği bulunamadı.'));
            }
            const payload = window.collectStep1Payload ? window.collectStep1Payload() : {};
            const response = await fetch(`${STEP_ENDPOINT}?learning_material_id=${CONTENT_ID}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ step1: payload })
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok || json.status !== 'success') {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            return json;
        };
    };

    window.contentUpdate.registerStep(1, {
        hydrate(resource) {
            if (typeof hydrateStep1 === 'function') {
                const data = buildStep1Data(resource);
                if (window.contentWizard?.setCached) {
                    window.contentWizard.setCached(1, { status: 'ok', data });
                    document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                        detail: { step: 1, payload: { data } }
                    }));
                }
                hydrateStep1({ data });
            }
        },
        collect() {
            return { step1: window.collectStep1Payload ? window.collectStep1Payload() : {} };
        },
    });

    assignOverrides();
    if (!window.contentUpdate.getInitialPayload() && CONTENT_ID) {
        fetchStep1().catch((error) => console.error('[ArticleUpdate] Step1 fetch failed', error));
    } else if (CONTENT_ID) {
        window.loadStep1SessionData?.();
    }
})();
</script>

