<?= $this->extend('app/layouts/main') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    (() => {
        if (typeof window === 'undefined') return;

        const resolveNavType = () => {
            try {
                const entries = typeof performance?.getEntriesByType === 'function'
                    ? performance.getEntriesByType('navigation')
                    : [];
                if (entries && entries.length) {
                    return entries[0].type ?? 'navigate';
                }
                const legacyNav = performance?.navigation;
                if (legacyNav) {
                    switch (legacyNav.type) {
                        case legacyNav.TYPE_RELOAD:
                            return 'reload';
                        case legacyNav.TYPE_BACK_FORWARD:
                            return 'back_forward';
                        default:
                            return 'navigate';
                    }
                }
            } catch (_) {
                /* noop */
            }
            return 'navigate';
        };

        if (resolveNavType() === 'reload') {
            return;
        }

        try {
            const possibleKeys = [
                'admin_contents_table',
                'datatable_admin_contents_table',
                'kt_datatable_admin_contents_table'
            ];
            for (const key of possibleKeys) {
                if (window.localStorage.getItem(key) !== null) {
                    window.localStorage.removeItem(key);
                }
            }
        } catch (error) {
            console.debug('[AdminContents] Datatable state reset skipped:', error);
        }
    })();
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="kt-container-fixed grow pb-5" id="content">
    <div class="kt-card kt-card-grid w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Eğitim İçerikleri
            </h3>
        </div>
        <div class="kt-card-content">
            <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="10">
                <!-- Desktop Table -->
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true"
                        id="admin_contents_table">
                        <thead>
                            <tr>
                                <th class="min-w-[300px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            İçerik Başlığı
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[200px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Oluşturan Kullanıcı
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[120px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Durum
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[150px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Oluşturulma Tarihi
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[150px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Son Güncelleme
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="w-[120px]">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contents as $content): ?>
                                <?php $encryptedId = App\Helpers\EncryptHelper::encrypt((string) $content['id']); ?>
                                <tr>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-mono"
                                                title="<?= esc($content['title']) ?>">
                                                <?= esc($content['title']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-foreground">
                                                <?= esc($content['author_name']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center gap-1">
                                            <span
                                                class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?>">
                                                <?= esc($content['status_text']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td><?= esc($content['created_at'] ?? $content['updated_at']) ?></td>
                                    <td><?= esc($content['updated_at']) ?></td>
                                    <td>
                                        <div class="flex items-center justify-center gap-1">
                                            <a class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost kt-btn-primary"
                                                href="<?= base_url('admin/apps/materials/' . $encryptedId) ?>"
                                                title="Detay">
                                                <i class="ki-filled ki-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div
                    class="kt-card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-secondary-foreground text-sm font-medium">
                    <div class="per-page-selector flex items-center gap-2">
                        Show
                        <select class="kt-select w-16" data-kt-datatable-size="true" data-kt-select="" name="perpage">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        per page
                    </div>
                    <div class="pagination-info">
                        <span data-kt-datatable-info="true">
                            Showing 1 to <?= count($contents) ?> of <?= count($contents) ?> entries
                        </span>
                    </div>
                    <div class="pagination-controls">
                        <div class="kt-datatable-pagination" data-kt-datatable-pagination="true">
                            <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm" disabled>
                                <i class="ki-filled ki-black-left"></i>
                            </button>
                            <button class="kt-btn kt-btn-outline kt-btn-sm active">1</button>
                            <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm" disabled>
                                <i class="ki-filled ki-black-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>