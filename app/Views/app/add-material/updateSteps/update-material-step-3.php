<?php
declare(strict_types=1);
?>
<?= $this->include('app/add-material/steps/add-material-step-3') ?>

<script>
(() => {
    const root = document.getElementById('content_update_root');
    const CONTENT_ID = Number(root?.dataset?.learningMaterialId ?? 0) || 0;
    const STEP_ENDPOINT = '/apps/update-material/step-3';

    const requeue = () => {
        if (!window.contentUpdate || !window.__contentStep3 || !window.__contentStep3State) {
            setTimeout(requeue, 120);
            return;
        }

        const api = window.__contentStep3;
        const state = window.__contentStep3State;

        const fetchStep3 = async () => {
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
            const merged = window.contentUpdate.merge({ ...current }, { files: data.files ?? [] });
            window.contentUpdate.setInitialPayload(merged);
            return data;
        };

        state.__deleteIds = state.__deleteIds || new Set();

        api.load = async () => {
            try {
                const payload = await fetchStep3();
                if (payload) {
                    api.hydrate({ files: payload.files ?? [] });
                }
            } catch (error) {
                console.error('[ContentUpdate] Step3 load failed', error);
            }
        };

        api.submit = async () => {
            const payload = api.collect();
            const response = await fetch(`${STEP_ENDPOINT}?learning_material_id=${CONTENT_ID}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ step3: payload })
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok || json.status !== 'success') {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            return json;
        };

        if (!state.__wrappedDelete) {
            state.__wrappedDelete = true;

            const originalRemoveAdditional = window.removeAdditionalFile;
            window.removeAdditionalFile = (identifier) => {
                const target = (state.additional ?? []).find((file) => file.client_id === identifier || file.id === identifier);
                if (target?.id) {
                    state.__deleteIds.add(Number(target.id));
                }
                if (typeof originalRemoveAdditional === 'function') {
                    originalRemoveAdditional(identifier);
                }
            };
        }

        window.contentUpdate.registerStep(3, {
            hydrate(resource) {
                const files = Array.isArray(resource.files) ? resource.files : [];
                api.hydrate({ files });
                if (window.contentWizard?.setCached) {
                    window.contentWizard.setCached(3, { status: 'ok', data: { files } });
                    document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                        detail: { step: 3, payload: { data: { files } } }
                    }));
                }
            },
            collect() {
                return { step3: api.collect() };
            },
        });

        if (CONTENT_ID) {
            fetchStep3().catch((error) => console.error('[ContentUpdate] Step3 initial fetch failed', error));
        }
    };

    requeue();
})();
</script>
