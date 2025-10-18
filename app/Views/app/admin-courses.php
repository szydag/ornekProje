 <?= $this->extend('app/layouts/main') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="kt-container-fixed grow pb-5" id="content">
    <div class="kt-card kt-card-grid w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Kursler
            </h3>
            <div class="kt-card-toolbar">
                <div class="flex items-center gap-2">
                    <button class="kt-btn kt-btn-primary kt-btn-sm" data-kt-modal-toggle="#addEncyclopediaModal">
                        <i class="ki-filled ki-plus text-sm"></i>
                        Kurs Ekle
                    </button>
                </div>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="10">
                <!-- Desktop Table -->
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true" id="admin_courses_table">
                        <thead>
                            <tr>
                                <th class="min-w-[300px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Kurs Adı
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[150px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Başlangıç Tarihi
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[150px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Bitiş Tarihi
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="w-[120px]">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody id="courses-tbody">
                            <?php if (!empty($courses)): ?>
                                <?php foreach ($courses as $course): ?>
                                    <?php $encryptedId = App\Helpers\EncryptHelper::encrypt((string) $course['id']); ?>
                                    <tr>
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold text-mono"
                                                    title="<?= esc($course['title']) ?>">
                                                    <?= esc($course['title']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td><?= !empty($course['start_date']) ? date('d.m.Y', strtotime($course['start_date'])) : '-' ?></td>
                                        <td><?= !empty($course['end_date']) ? date('d.m.Y', strtotime($course['end_date'])) : 'Süresiz' ?></td>
                                        <td>
                                            <div class="flex items-center justify-center gap-1">
                                                <a class="kt-badge kt-badge-outline kt-badge-primary"
                                                    href="<?= base_url('admin/apps/courses/' . $encryptedId) ?>"
                                                    title="Detay">
                                                    Detay
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-8">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-sm text-muted-foreground">Henüz kurs bulunmuyor</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="kt-card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-secondary-foreground text-sm font-medium">
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
                        <span data-kt-datatable-info="true" id="pagination-info">
                            Showing 1 to <?= count($courses) ?> of <?= $total ?? count($courses) ?> entries
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

<?= $this->section('modals') ?>
<?= $this->include('app/modals/add-course-modal') ?>
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
                'admin_courses_table',
                'datatable_admin_courses_table',
                'kt_datatable_admin_courses_table'
            ];
            for (const key of possibleKeys) {
                if (window.localStorage.getItem(key) !== null) {
                    window.localStorage.removeItem(key);
                }
            }
        } catch (error) {
            console.debug('[AdminEncyclopedias] Datatable state reset skipped:', error);
        }
    })();

    // Modal'dan kurs eklendikten sonra sayfayı yenile
    function refreshEncyclopediaList() {
        // Sayfa yenilenerek güncel listeyi göster
        window.location.reload();
    }
</script>
<?= $this->endSection() ?>
