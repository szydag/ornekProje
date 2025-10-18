<?php
declare(strict_types=1);
?>
<?= $this->include('app/add-material/steps/add-material-step-5') ?>

<script>
(() => {
    const root = document.getElementById('content_update_root');
    const CONTENT_ID = Number(root?.dataset?.learningMaterialId ?? 0) || 0;
    const STEP_ENDPOINT = '/apps/update-material/step-5';

    const requeue = () => {
        if (!window.contentUpdate || !window.__contentStep5) {
            setTimeout(requeue, 120);
            return;
        }

        const api = window.__contentStep5;

        const fetchStep5 = async () => {
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
            const merged = window.contentUpdate.merge({ ...current }, { approvals: data.approvals ?? {} });
            window.contentUpdate.setInitialPayload(merged);
            return data;
        };

        api.load = async () => {
            try {
                const payload = await fetchStep5();
                if (!payload) return;
                api.hydrate(payload.approvals ?? {});
            } catch (error) {
                console.error('[ArticleUpdate] Step5 load failed', error);
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
                body: JSON.stringify({ step5: payload })
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok || json.status !== 'success') {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            return json;
        };

        window.contentUpdate.registerStep(5, {
            hydrate(resource) {
                const approvals = resource?.approvals ?? resource ?? {};
                if (window.contentWizard?.setCached) {
                    window.contentWizard.setCached(5, { status: 'ok', data: approvals });
                    document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                        detail: { step: 5, payload: { data: approvals } }
                    }));
                }
                api.hydrate(approvals);
            },
            collect() {
                return { step5: api.collect() };
            },
        });

        if (CONTENT_ID) {
            fetchStep5().catch((error) => console.error('[ArticleUpdate] Step5 initial fetch failed', error));
        }
    };

    requeue();
})();
</script>
