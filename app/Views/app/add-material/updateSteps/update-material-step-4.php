<?php
declare(strict_types=1);
?>
<?= $this->include('app/add-material/steps/add-material-step-4') ?>

<script>
(() => {
    const root = document.getElementById('content_update_root');
    const CONTENT_ID = Number(root?.dataset?.learningMaterialId ?? 0) || 0;
    const STEP_ENDPOINT = '/apps/update-material/step-4';

    const toHydratePacket = (resource) => ({
        data: {
            project_number: resource?.project_number ?? null,
            rows: Array.isArray(resource?.extra) ? resource.extra : [],
        },
    });

    const requeue = () => {
        if (!window.contentUpdate || !window.__contentStep4) {
            setTimeout(requeue, 120);
            return;
        }

        const api = window.__contentStep4;

        const fetchStep4 = async () => {
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
            const merged = window.contentUpdate.merge({ ...current }, {
                extra: data.extra ?? [],
                project_number: data.project_number ?? null,
            });
            window.contentUpdate.setInitialPayload(merged);
            api.hydrate(toHydratePacket({
                project_number: data.project_number ?? null,
                extra: data.extra ?? [],
            }));
            return data;
        };

        api.load = async () => {
            try {
                const payload = await fetchStep4();
                if (payload) {
                    api.hydrate(toHydratePacket({
                        project_number: payload.project_number ?? null,
                        extra: payload.extra ?? [],
                    }));
                }
            } catch (error) {
                console.error('[ArticleUpdate] Step4 load failed', error);
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
                body: JSON.stringify({ step4: payload })
            });
            const json = await response.json().catch(() => ({}));
            if (!response.ok || json.status !== 'success') {
                throw new Error(json.error ?? `HTTP ${response.status}`);
            }
            return json;
        };

        window.contentUpdate.registerStep(4, {
            hydrate(resource) {
                const packet = toHydratePacket(resource);
                api.hydrate(packet);
                if (window.contentWizard?.setCached) {
                    window.contentWizard.setCached(4, { status: 'ok', data: packet.data });
                    document.dispatchEvent(new CustomEvent('content-wizard:hydrate', {
                        detail: { step: 4, payload: { data: packet.data } }
                    }));
                }
            },
            collect() {
                return { step4: api.collect() };
            },
        });

        if (CONTENT_ID) {
            fetchStep4().catch((error) => console.error('[ArticleUpdate] Step4 initial fetch failed', error));
        }
    };

    requeue();
})();
</script>
