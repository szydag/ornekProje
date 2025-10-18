<?= $this->extend('app/layouts/main') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="kt-container-fixed grow pb-5" id="content">
    <div class="kt-card kt-card-grid w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Eğitim İçeriği Listesi
            </h3>
        </div>
        <div class="kt-card-content">
            <?php if (empty($contents)): ?>
                <div class="flex flex-col items-center justify-center text-center py-12 gap-4 pb-10">
                    <div class="size-16 rounded-full bg-accent/30 flex items-center justify-center">
                        <i class="ki-filled ki-file-search text-2xl text-accent-foreground/70"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="text-base font-semibold text-mono">Eğitim İçeriği eklenmedi</h4>
                        <p class="text-sm text-muted-foreground max-w-sm">
                            Şu anda görüntüleyebileceğiniz bir içerik bulunmuyor. Yeni bir içerik eklemek için İçerik Ekle bağlantısını kullanabilirsiniz.
                        </p>
                    </div>
                </div>
            <?php else: ?>
            <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="10">
                <!-- Desktop Table -->
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true" id="contents_table">
                        <thead>
                            <tr>
                                <th class="min-w-[300px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Eğitim İçeriği Başlığı
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
                                            Son Güncelleme
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
                                <th class="w-[120px]">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contents as $content): ?>
                                <tr>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-mono" title="<?= esc($content['title']) ?>">
                                                <?= esc($content['title']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?>">
                                                <?= esc($content['status_text']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td><?= esc($content['updated_at']) ?></td>
                                    <td><?= esc($content['created_at'] ?? $content['updated_at']) ?></td>
                                    <?php
                                        $encryptedId = App\Helpers\EncryptHelper::encrypt((string) $content['id']);
                                    ?>
                                    <td>
                                        <div class="flex items-center justify-center gap-1">
                                            <a class="kt-badge kt-badge-outline kt-badge-primary" href="<?= base_url('apps/materials/' . $encryptedId) ?>" title="Detay">
                                                Detay
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
