<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>

<div class="kt-container-fixed grow pb-5" id="content">
    <div class="kt-card kt-card-grid w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Kurs Listesi
            </h3>
        </div>
        <div class="kt-card-content">
            <?php if (empty($courses)): ?>
                <div class="flex flex-col items-center justify-center text-center py-12 gap-4 pb-10">
                    <div class="size-16 rounded-full bg-accent/30 flex items-center justify-center">
                        <i class="ki-filled ki-folder text-2xl text-accent-foreground/70"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="text-base font-semibold text-mono">Henüz kurs eklenmemiş</h4>
                        <p class="text-sm text-muted-foreground max-w-sm">
                            Şu anda görüntüleyebileceğiniz bir kurs bulunmuyor. Yeni bir kurs eklemek için Kurs Ekle
                            bağlantısını kullanabilirsiniz.
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="10">
                    <!-- Desktop Table -->
                    <div class="kt-scrollable-x-auto">
                        <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true"
                            id="courses_table">
                            <thead>
                                <tr>
                                    <th class="min-w-[80px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                ID
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[300px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Kurs Başlığı
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[200px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Açıklama
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[100px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Durum
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[120px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Başlangıç Tarihi
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[100px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                İşlemler
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td>
                                            <div class="flex items-center">
                                                <span class="badge badge-light-primary"><?= esc($course['id']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-gray-900"><?= esc($course['title']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted"><?= esc($course['description']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $course['status'] == 1 ? 'success' : 'secondary' ?>">
                                                <?= $course['status'] == 1 ? 'Aktif' : 'Pasif' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-gray-700"><?= esc($course['start_date']) ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('apps/courses/' . $course['id']) ?>" 
                                               class="btn btn-sm btn-primary btn-icon" title="Detayları Görüntüle">
                                                <i class="ki-outline ki-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable if courses exist
    <?php if (!empty($courses)): ?>
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#courses_table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Turkish.json"
            },
            "pageLength": 10,
            "responsive": true,
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ]
        });
    }
    <?php endif; ?>
});
</script>
<?= $this->endSection() ?>
