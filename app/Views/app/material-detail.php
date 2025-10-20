<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>
<?php
$roleIds = session('role_ids') ?? [];
$roleIds = is_array($roleIds) ? $roleIds : [];
$isAdmin = in_array(1, $roleIds, true);
$isManager = in_array(2, $roleIds, true);
$canManageEditors = $isAdmin || $isManager;
?>
<script>
    // Set content ID as data attribute on body for modal access
    document.body.dataset.learningMaterialId = <?= (int) $content['id'] ?>;
</script>

<div class="kt-container-fixed grow pb-5 max-w-none px-2 sm:px-4" id="content">

    <style>
        .hero-bg {
            background-image: url('<?= base_url('/assets/media/images/2600x1200/bg-1.png') ?>');
        }

        .dark .hero-bg {
            background-image: url('<?= base_url('/assets/media/images/2600x1200/bg-1-dark.png') ?>');
        }


        .tab-content {
            display: none;
            margin-top: 2rem;
            position: relative;
            width: 100%;
        }

        .tab-content.active {
            display: block !important;
        }

        .kt-card-content p {
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
            hyphens: auto;
        }

        /* Responsive buton boyutları */
        @media (min-width: 768px) {
            #actionsBar .kt-btn {
                font-size: 0.875rem !important;
                padding: 0.375rem 0.75rem !important;
                min-height: 2rem !important;
            }
        }

        @media (max-width: 767px) {
            #actionsBar .kt-btn {
                font-size: 0.75rem !important;
                padding: 0.25rem 0.5rem !important;
                min-height: 1.75rem !important;
            }
        }
    </style>

    <div class="bg-center bg-cover bg-no-repeat hero-bg">
        <!-- Container -->
        <div class="kt-container-fixed max-w-none px-2 sm:px-4">
            <div class="flex flex-col items-start gap-2 lg:gap-3.5 py-3 sm:py-4 lg:pt-5 lg:pb-10">
                <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-1.5 w-full">
                    <div class="text-base sm:text-lg leading-5 font-semibold text-mono flex-1 min-w-0">
                        <?= esc($content['title']) ?>
                    </div>
                    <div
                        class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?? 'primary' ?> kt-badge-lg px-4 py-2">
                        <?= esc($content['status_label'] ?? $content['status'] ?? 'Bilinmiyor') ?>
                    </div>
                </div>
                <?php if (!empty($content['title_en']) && $content['title_en'] !== $content['title']): ?>
                    <div class="flex items-start gap-2 text-sm font-normal text-secondary-foreground">
                        <?= esc($content['title_en']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- End of Container -->
    </div>

    <!-- Container -->
    <div class="kt-container-fixed max-w-none px-2 sm:px-4">
        <div
            class="flex flex-col sm:flex-row sm:items-start lg:items-end justify-between border-b border-b-border gap-3 lg:gap-6 mb-5 lg:mb-10">
            <div class="grid">
                <div class="kt-scrollable-x-auto overflow-x-auto">
                    <div class="kt-menu gap-2 sm:gap-3 flex-nowrap" data-kt-menu="true">
                        <div class="kt-tab-item border-b-2 border-b-transparent kt-tab-active" data-role="">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('info')" data-role="">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    İçerik Bilgileri
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="authors">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('authors')"
                                data-role="authors">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Katkıda Bulunanlar
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="files">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('files')"
                                data-role="files">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Dosyalar
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="additional">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('additional')"
                                data-role="additional">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Ek Bilgiler
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="history">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('history')"
                                data-role="history">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    İşlem Geçmişi
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-start justify-end grow lg:grow-0 lg:pb-4 gap-2.5 mb-3 lg:mb-0" id="actionsBar" style="flex-wrap: wrap;">

            </div>
        </div>

        <!-- Tab İçerikleri -->
        <div class="kt-container-fixed">
            <div class="tab-content active" id="info-tab">
                <!-- İçerik Üst Verileri -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">İçerik Üst Verileri</h3>
                        <div class="kt-card-toolbar">
                            <span
                                class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?? 'primary' ?>">
                                <?= esc($content['status_label'] ?? $content['status'] ?? 'Bilinmiyor') ?>
                            </span>
                        </div>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-6">

                            <!-- İçerik Türü ve Genel Bilgiler -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="text-sm font-medium text-muted-foreground">Kurs</label>
                                    <p class="text-sm mt-1 font-medium">
                                        <?= esc($content['course']['title'] ?? 'Belirtilmedi') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="text-sm font-medium text-muted-foreground">İçerik Türü</label>
                                    <p class="text-sm mt-1 font-medium">
                                        <?= esc($content['publication_type'] ?? 'Belirtilmedi') ?>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Birinci Dil</label>
                                    <p class="text-sm mt-1 font-medium">
                                        <?= esc($content['primary_language'] ?? 'Belirtilmedi') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Çok Dilli Bilgiler -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Türkçe Bilgiler -->
                                <div class="kt-card">
                                    <div class="kt-card-content">
                                        <h4 class="text-sm font-semibold text-mono mb-4 flex items-center gap-2">
                                            <i class="ki-filled ki-flag text-primary"></i>
                                            Türkçe Bilgiler
                                        </h4>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Başlık</label>
                                                <h2 class="text-lg font-semibold text-mono mt-1">
                                                    <?= esc($content['title'] ?? 'Belirtilmedi') ?>
                                                </h2>
                                            </div>

                                            <?php if (!empty($content['keywords_tr'])): ?>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">Anahtar
                                                        Kelimeler</label>
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        <?php foreach (explode(',', $content['keywords_tr']) as $keyword): ?>
                                                            <span
                                                                class="kt-badge kt-badge-outline kt-badge-primary kt-badge-sm">
                                                                <?= trim(esc($keyword)) ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($content['abstract_tr'])): ?>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">Öz</label>
                                                    <div class="kt-card mt-2">
                                                        <div class="kt-card-content">
                                                            <p class="text-sm leading-relaxed">
                                                                <?= nl2br(esc($content['abstract_tr'])) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- İngilizce Bilgiler -->
                                <?php if (!empty($content['title_en']) || !empty($content['keywords_en']) || !empty($content['abstract_en'])): ?>
                                    <div class="kt-card">
                                        <div class="kt-card-content">
                                            <h4 class="text-sm font-semibold text-mono mb-4 flex items-center gap-2">
                                                <i class="ki-filled ki-flag text-secondary"></i>
                                                İngilizce Bilgiler
                                            </h4>

                                            <div class="space-y-4">
                                                <?php if (!empty($content['title_en'])): ?>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Başlık</label>
                                                        <h2 class="text-lg font-semibold text-mono mt-1">
                                                            <?= esc($content['title_en']) ?>
                                                        </h2>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($content['keywords_en'])): ?>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Anahtar
                                                            Kelimeler</label>
                                                        <div class="mt-2 flex flex-wrap gap-2">
                                                            <?php foreach (explode(',', $content['keywords_en']) as $keyword): ?>
                                                                <span
                                                                    class="kt-badge kt-badge-outline kt-badge-secondary kt-badge-sm">
                                                                    <?= trim(esc($keyword)) ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($content['abstract_en'])): ?>
                                                    <div>
                                                        <label class="text-sm font-medium text-muted-foreground">Öz</label>
                                                        <div class="kt-card mt-2">
                                                            <div class="kt-card-content">
                                                                <p class="text-sm leading-relaxed">
                                                                    <?= nl2br(esc($content['abstract_en'])) ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Katkıda Bulunanlar Sekmesi -->
        <div class="kt-container-fixed">
            <div class="tab-content" id="authors-tab">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Katkıda Bulunanlar</h3>
                        <?php if ($canManageEditors): ?>
                            <div class="kt-card-toolbar">
                                <div class="flex items-center gap-3">
                                    <button class="kt-btn kt-btn-primary kt-btn-sm" data-kt-modal-toggle="#addEditorModal"
                                        data-content-id="<?= (int) ($content['id'] ?? 0) ?>">
                                        <i class="ki-filled ki-user-plus text-sm"></i>
                                        Alan Editörü Ekle
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="kt-card-content">
                        <!-- Desktop Table View -->
                        <div class="hidden md:block kt-scrollable-x-auto">
                            <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true"
                                id="authors_table">
                                <thead>
                                    <tr>
                                        <th class="min-w-[50px]">
                                            <span class="kt-table-col">
                                                <span class="kt-table-col-label">
                                                    #
                                                </span>
                                                <span class="kt-table-col-sort"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[200px]">
                                            <span class="kt-table-col">
                                                <span class="kt-table-col-label">
                                                    Katkıda Bulunan Adı
                                                </span>
                                                <span class="kt-table-col-sort"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[200px]">
                                            <span class="kt-table-col">
                                                <span class="kt-table-col-label">
                                                    Kurum
                                                </span>
                                                <span class="kt-table-col-sort"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[150px]">
                                            <span class="kt-table-col">
                                                <span class="kt-table-col-label">
                                                    Ünvan
                                                </span>
                                                <span class="kt-table-col-sort"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[100px]">
                                            <span class="kt-table-col">
                                                <span class="kt-table-col-label">
                                                    Rol
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
                                    <?php foreach ($content['authors'] as $index => $author): ?>
                                        <tr>
                                            <td>
                                                <div
                                                    class="flex items-center justify-center size-8 rounded-full bg-primary/10 text-primary font-semibold text-sm">
                                                    <?= $index + 1 ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="flex flex-col">
                                                        <a class="text-sm font-semibold text-mono hover:text-primary"
                                                            href="#" title="<?= esc($author['name']) ?>">
                                                            <?= esc($author['name']) ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <i class="ki-filled ki-badge text-xs text-muted-foreground"></i>
                                                    <span class="text-sm text-foreground">
                                                        <?= esc($author['institution'] ?? $author['affiliation'] ?? 'Belirtilmedi') ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <i class="ki-filled ki-badge text-xs text-muted-foreground"></i>
                                                    <span class="text-sm text-foreground">
                                                        <?= esc($author['title']) ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center justify-center gap-1">
                                                    <?php if ($author['is_corresponding']): ?>
                                                        <span class="kt-badge kt-badge-outline kt-badge-success">
                                                            Sorumlu
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="kt-badge kt-badge-outline kt-badge-secondary">
                                                            Katkıda Bulunan
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center justify-center gap-1">
                                                    <a class="kt-badge kt-badge-outline kt-badge-primary" href="#"
                                                        title="Detay" onclick="viewAuthorDetail(<?= $author['id'] ?>)">
                                                        Detay
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Mobile Card View -->
                        <div class="block md:hidden space-y-3">
                            <?php foreach ($content['authors'] as $index => $author): ?>
                                <div class="kt-card">
                                    <div class="kt-card-content p-4">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center justify-center size-8 rounded-full bg-primary/10 text-primary font-semibold text-sm">
                                                    <?= $index + 1 ?>
                                                </div>
                                                <h4 class="text-sm font-medium"><?= esc($author['name']) ?></h4>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <?php if ($author['is_corresponding']): ?>
                                                    <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">
                                                        Sorumlu
                                                    </span>
                                                <?php else: ?>
                                                    <span class="kt-badge kt-badge-outline kt-badge-secondary kt-badge-sm">
                                                        Katkıda Bulunan
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-home text-xs text-muted-foreground"></i>
                                                <span class="text-xs text-muted-foreground">Kurum:</span>
                                                <span class="text-sm text-foreground"><?= esc($author['institution'] ?? $author['affiliation'] ?? 'Belirtilmedi') ?></span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-badge text-xs text-muted-foreground"></i>
                                                <span class="text-xs text-muted-foreground">Ünvan:</span>
                                                <span class="text-sm text-foreground"><?= esc($author['title']) ?></span>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-border">
                                            <a class="kt-btn kt-btn-sm kt-btn-outline kt-btn-primary w-full" href="#" title="Detay"
                                                onclick="viewAuthorDetail(<?= $author['id'] ?>)">
                                                Detay Görüntüle
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

                <?php if ($canManageEditors): ?>
                    <br>
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">Atanmış Alan Editörleri</h3>
                            <div class="kt-card-toolbar">
                                <?php if (!empty($content['editors'])): ?>
                                    <span class="kt-badge kt-badge-outline kt-badge-primary">
                                        <?= count($content['editors']) ?> atama
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="kt-card-content">
                            <?php if (empty($content['editors'])): ?>
                                <div class="py-6 text-sm text-muted-foreground">
                                    Bu içerik için henüz alan editörü atanmamış.
                                </div>
                            <?php else: ?>
                                <div class="kt-scrollable-x-auto">
                                    <table class="kt-table table-auto kt-table-border">
                                        <thead>
                                            <tr>
                                                <th class="min-w-[240px]">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">E-posta</span>
                                                    </span>
                                                </th>
                                                <th class="min-w-[160px]">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Durum</span>
                                                    </span>
                                                </th>
                                                <th class="min-w-[180px]">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Atanma Tarihi</span>
                                                    </span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($content['editors'] as $editor): ?>
                                                <tr>
                                                    <td>
                                                        <div class="flex flex-col">
                                                            <span class="text-sm font-medium text-foreground">
                                                                <?= esc($editor['email']) ?>
                                                            </span>
                                                            <?php if (!empty($editor['display_name'])): ?>
                                                                <span class="text-xs text-muted-foreground">
                                                                    <?= esc($editor['display_name']) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="flex items-center gap-2">
                                                            <?php if ($editor['is_registered']): ?>
                                                                <span class="kt-badge kt-badge-outline kt-badge-success">
                                                                    Kayıtlı Kullanıcı
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="kt-badge kt-badge-outline kt-badge-warning">
                                                                    Henüz Kayıtlı Değil
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-sm text-muted-foreground">
                                                            <?= esc($editor['assigned_at'] ? date('d.m.Y H:i', strtotime($editor['assigned_at'])) : '-') ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>



        <!-- Dosyalar Sekmesi -->
        <div class="kt-container-fixed">
            <div class="tab-content" id="files-tab">
                <?php if (!empty($content['files'])): ?>
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">Dosyalar</h3>
                            <div class="kt-card-toolbar">
                                <span class="kt-badge kt-badge-outline kt-badge-primary">
                                    <?= count($content['files']) ?> dosya
                                </span>
                            </div>
                        </div>
                        <div class="kt-card-content">
                            <div class="space-y-3">
                                <?php foreach ($content['files'] as $file): ?>
                                    <div
                                        class="flex items-center justify-between p-3 border border-border rounded-lg hover:bg-accent/5 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10">
                                                <?php
                                                $icon = 'ki-document';
                                                if (strpos($file['type'], 'PDF') !== false)
                                                    $icon = 'ki-file-pdf';
                                                elseif (strpos($file['type'], 'Word') !== false)
                                                    $icon = 'ki-file-word';
                                                elseif (strpos($file['type'], 'Excel') !== false)
                                                    $icon = 'ki-file-excel';
                                                elseif (strpos($file['type'], 'PowerPoint') !== false)
                                                    $icon = 'ki-file-powerpoint';
                                                ?>
                                                <i class="ki-filled <?= $icon ?> text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium"><?= esc($file['name']) ?></p>
                                                <p class="text-xs text-secondary-foreground">
                                                     <?= esc($file['size']) ?> •
                                                    <?= date('d.m.Y', strtotime($content['created_at'])) ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <?php 
                                            // Word dosyaları için önizleme butonunu gizle
                                            $isWordFile = in_array(strtolower($file['extension'] ?? ''), ['doc', 'docx']) || 
                                                         strpos(strtolower($file['type'] ?? ''), 'word') !== false ||
                                                         strpos(strtolower($file['mime'] ?? ''), 'word') !== false;
                                            ?>
                                            <?php if (!$isWordFile): ?>
                                                <button
                                                    onclick="previewFile(
                                                        this,
                                                        <?= (int) $file['id'] ?>,
                                                        '<?= esc($file['name'], 'js') ?>',
                                                        '<?= esc($file['type'] ?? '', 'js') ?>',
                                                        '<?= esc($file['mime'] ?? '', 'js') ?>',
                                                        '<?= esc($file['extension'] ?? '', 'js') ?>',
                                                        '<?= esc($file['size'] ?? '', 'js') ?>',
                                                        '<?= esc($file['download_url'] ?? base_url('download/' . $file['id']), 'js') ?>',
                                                        '<?= esc($file['preview_url'] ?? base_url('preview/' . $file['id']), 'js') ?>'
                                                    )"
                                                    class="kt-btn kt-btn-sm kt-btn-outline">
                                                    <i class="ki-filled ki-eye text-sm"></i>
                                                    Ön İzle
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?= esc($file['download_url'] ?? base_url('download/' . $file['id'])) ?>"
                                                class="kt-btn kt-btn-sm kt-btn-primary">
                                                <i class="ki-filled ki-download text-sm"></i>
                                                İndir
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="kt-card">
                        <div class="kt-card-content">
                            <div class="text-center py-8">
                                <div
                                    class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                                    <i class="ki-filled ki-document text-2xl text-primary"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-mono mb-2">Dosya Bulunamadı</h3>
                                <p class="text-sm text-secondary-foreground">
                                    Bu içerik için henüz dosya yüklenmemiş.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Ek Bilgiler Sekmesi -->
        <div class="kt-container-fixed">
            <div class="tab-content" id="additional-tab">
                <?php if (!empty($content['additional_info'])): ?>
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">Ek Bilgiler</h3>
                        </div>
                        <div class="kt-card-content">
                            <div class="space-y-6">
                                <!-- Proje Numarası -->
                                <?php if (!empty($content['additional_info']['project_number'])): ?>
                                    <div class="kt-card mb-8">
                                        <div class="kt-card-content">
                                            <label class="text-sm font-medium text-muted-foreground">Proje Numarası</label>
                                            <p class="text-sm font-medium mt-1">
                                                <?= esc($content['additional_info']['project_number']) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Çok Dilli Ek Bilgiler -->
                                <?php if (!empty($content['additional_info']['ethics_statement_tr']) || !empty($content['additional_info']['supporting_institution_tr']) || !empty($content['additional_info']['acknowledgments_tr']) || !empty($content['additional_info']['ethics_statement_en']) || !empty($content['additional_info']['supporting_institution_en']) || !empty($content['additional_info']['acknowledgments_en'])): ?>
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Türkçe Ek Bilgiler -->
                                        <?php if (!empty($content['additional_info']['ethics_statement_tr']) || !empty($content['additional_info']['supporting_institution_tr']) || !empty($content['additional_info']['acknowledgments_tr'])): ?>
                                            <div class="kt-card mb-8">
                                                <div class="kt-card-content">
                                                    <h4 class="text-sm font-semibold text-mono mb-4 flex items-center gap-2">
                                                        <i class="ki-filled ki-flag text-primary"></i>
                                                        Türkçe Ek Bilgiler
                                                    </h4>
                                                    <div class="space-y-4">
                                                        <?php if (!empty($content['additional_info']['ethics_statement_tr'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label class="text-sm font-medium text-muted-foreground">Etik
                                                                        Beyan</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['ethics_statement_tr']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($content['additional_info']['supporting_institution_tr'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label class="text-sm font-medium text-muted-foreground">Destekleyen
                                                                        Kurum</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['supporting_institution_tr']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($content['additional_info']['acknowledgments_tr'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label
                                                                        class="text-sm font-medium text-muted-foreground">Teşekkür</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['acknowledgments_tr']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- İngilizce Ek Bilgiler -->
                                        <?php if (!empty($content['additional_info']['ethics_statement_en']) || !empty($content['additional_info']['supporting_institution_en']) || !empty($content['additional_info']['acknowledgments_en'])): ?>
                                            <div class="kt-card mb-8">
                                                <div class="kt-card-content">
                                                    <h4 class="text-sm font-semibold text-mono mb-4 flex items-center gap-2">
                                                        <i class="ki-filled ki-flag text-secondary"></i>
                                                        İngilizce Ek Bilgiler
                                                    </h4>
                                                    <div class="space-y-4">
                                                        <?php if (!empty($content['additional_info']['ethics_statement_en'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label class="text-sm font-medium text-muted-foreground">Etik
                                                                        Beyan</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['ethics_statement_en']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($content['additional_info']['supporting_institution_en'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label class="text-sm font-medium text-muted-foreground">Destekleyen
                                                                        Kurum</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['supporting_institution_en']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($content['additional_info']['acknowledgments_en'])): ?>
                                                            <div class="kt-card">
                                                                <div class="kt-card-content">
                                                                    <label
                                                                        class="text-sm font-medium text-muted-foreground">Teşekkür</label>
                                                                    <p class="text-sm mt-1">
                                                                        <?= esc($content['additional_info']['acknowledgments_en']) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Editöre Notlar -->
                                <?php if (!empty($content['additional_info']['editor_notes'])): ?>
                                    <div class="kt-card ">
                                        <div class="kt-card-content">
                                            <label class="text-sm font-medium text-muted-foreground">Editöre Notlar</label>
                                            <p class="text-sm mt-1"><?= esc($content['additional_info']['editor_notes']) ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="kt-card">
                        <div class="kt-card-content">
                            <div class="text-center py-8">
                                <div
                                    class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                                    <i class="ki-filled ki-information text-2xl text-primary"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-mono mb-2">Ek Bilgi Bulunamadı</h3>
                                <p class="text-sm text-secondary-foreground">
                                    Bu içerik için henüz ek bilgi girilmemiş.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- İşlem Geçmişi Sekmesi -->
        <div class="kt-container-fixed">
            <div class="tab-content" id="history-tab">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">İşlem Geçmişi</h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-0 bg-white/50 rounded-lg p-4">
                            <div class="relative">
                                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                                <div class="space-y-0">
                                    <?php if (!empty($content['history'])): ?>
                                        <div class="grid gap-3 md:grid-cols-1">
                                            <?php foreach ($content['history'] as $item): ?>
                                                <?php
                                                    $statusKey = $item['status_code'] ?? ($item['status'] ?? '');
                                                    $historyClasses = \App\Support\LearningMaterialStatusFormatter::historyClasses($statusKey);
                                                    $badgeClass = $historyClasses['badge'] ?? 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20';
                                                    $badgeStyle = $historyClasses['style'] ?? '';
                                                    ?>
                                                <div
                                                    class="relative rounded-xl px-4 py-4 border border-border bg-white shadow-sm">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class="space-y-1">
                                                                <h4 class="text-sm font-semibold text-mono">
                                                                    <?= esc($item['title']) ?>
                                                                </h4>
                                                                <div class="flex flex-wrap items-center gap-2">
                                                                    <span class="<?= esc($badgeClass) ?>" style="<?= esc($badgeStyle, 'attr') ?>">
                                                                        <?= esc($item['status']) ?>
                                                                    </span>
                                                                    <?php if (!empty($item['actor'])): ?>
                                                                        <span class="text-xs text-muted-foreground">•
                                                                            <?= esc($item['actor']) ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-xs text-muted-foreground whitespace-nowrap">
                                                            <?= esc(date('d.m.Y H:i', strtotime($item['created_at']))) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div
                                            class="rounded-xl border border-dashed px-4 py-6 text-center text-sm text-muted-foreground">
                                            Henüz işlem kaydı bulunmuyor.
                                        </div>
                                    <?php endif; ?>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <?= $this->include('app/modals/file-preview-modal') ?>

        <!-- Confirmation Dialog Modal -->
        <?= $this->include('app/modals/confirmation-modal') ?>
        <?= view('app/processModals/ActionModal') ?>
        <script>
            window.contentFiles = <?= json_encode($content['files'] ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
            window.downloadBaseUrl = '<?= rtrim(base_url('download'), '/') ?>';

            // Tab switching functionality
            function switchTab(tabName) {
                // Hide ALL tabs by removing active class
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Remove active from menu items
                document.querySelectorAll('.kt-tab-item').forEach(item => {
                    item.classList.remove('kt-tab-active');
                });

                // Show selected tab by adding active class
                const selectedTab = document.getElementById(tabName + '-tab');
                if (selectedTab) {
                    selectedTab.classList.add('active');
                }

                // Add active to menu item
                const menuItem = document.querySelector("[onclick=\"switchTab('" + tabName + "')\"]");
                if (menuItem) {
                    menuItem.closest('.kt-tab-item').classList.add('kt-tab-active');
                }
            }

            function editContent(learningMaterialId) {
                // TODO: İçerik düzenleme sayfasına yönlendir
                window.location.href = '<?= base_url('admin/apps/materials/') ?>' + learningMaterialId;
            }

            function downloadContent(learningMaterialId) {
                const files = Array.isArray(window.contentFiles) ? window.contentFiles : [];
                if (!files.length) {
                    if (typeof showPageAlert === 'function') {
                        showPageAlert('warning', 'Bu içerikye ait indirilebilir bir dosya bulunamadı.', 'Dosya Bulunamadı');
                    }
                    return;
                }

                const targetFile = files.find(file => file && typeof file.download_url === 'string' && file.download_url) ||
                    files[0];

                if (!targetFile || !targetFile.download_url) {
                    if (typeof showPageAlert === 'function') {
                        showPageAlert('warning', 'Bu içerikye ait indirilebilir bir dosya bulunamadı.', 'Dosya Bulunamadı');
                    }
                    return;
                }

                const downloadUrl = `${window.downloadBaseUrl}/${targetFile.id}`;
                const tempLink = document.createElement('a');
                tempLink.href = downloadUrl;
                tempLink.rel = 'noopener';
                tempLink.style.display = 'none';

                if (targetFile.name) {
                    tempLink.download = targetFile.name;
                } else {
                    tempLink.setAttribute('download', '');
                }

                document.body.appendChild(tempLink);
                tempLink.click();
                tempLink.remove();
            }

            function submitContent(learningMaterialId) {
                // TODO: Eğitim içeriği gönderme işlemi
                alert('Eğitim içeriği gönderme özelliği yakında eklenecek! İçerik ID: ' + learningMaterialId);
            }

            function deleteContent(learningMaterialId) {
                // TODO: Eğitim içeriği silme işlemi
                alert('Eğitim içeriği silme özelliği yakında eklenecek! İçerik ID: ' + learningMaterialId);
            }

            function viewAuthorDetail(authorId) {
                // TODO: Katkıda Bulunan detay modalı aç
                alert('Katkıda Bulunan detay özelliği yakında eklenecek! Katkıda Bulunan ID: ' + authorId);
            }

            function reviewContent(learningMaterialId) {
                // TODO: Eğitim içeriği inceleme işlemi
                alert('Eğitim içeriği inceleme özelliği yakında eklenecek! İçerik ID: ' + learningMaterialId);
            }

            function approveContent(learningMaterialId) {
                // Dosya ve açıklama verilerini al
                const actionData = window.currentActionData || {};
                const file = actionData.file || null;
                const description = actionData.description || '';

                // TODO: API'ye gönder
                showPageAlert('success', 'Eğitim içeriği başarıyla onaylandı!', 'İşlem Başarılı');

                // Veriyi temizle
                window.currentActionData = null;
            }

            function rejectContent(learningMaterialId) {
                // Dosya ve açıklama verilerini al
                const actionData = window.currentActionData || {};
                const file = actionData.file || null;
                const description = actionData.description || '';

                // TODO: API'ye gönder
                showPageAlert('destructive', 'Eğitim içeriği reddedildi!', 'İşlem Tamamlandı');

                // Veriyi temizle
                window.currentActionData = null;
            }

            function revisionContent(learningMaterialId) {
                // Dosya ve açıklama verilerini al
                const actionData = window.currentActionData || {};
                const file = actionData.file || null;
                const description = actionData.description || '';
                // TODO: API'ye gönder
                showPageAlert('warning', 'Eğitim içeriği revizyon için gönderildi!', 'Revizyon İsteği');

                // Veriyi temizle
                window.currentActionData = null;
            }

            // Listen for modal close events - same as add-course-modal
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('confirmationModal');

                // Modal dışına tıklandığında kapatma
                document.addEventListener('click', function (e) {
                    if (modal && e.target === modal) {
                        // Metronic will handle this automatically
                    }
                });

                // ESC tuşu ile modal kapatma
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        // Metronic will handle this automatically
                    }
                });
            });
        </script>
        <script>
            window.contentFiles = <?= json_encode($content['files'] ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
            window.downloadBaseUrl = window.downloadBaseUrl || '<?= rtrim(base_url('download'), '/') ?>';

            function switchTab(tabName) {
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.kt-tab-item').forEach(item => item.classList.remove('kt-tab-active'));

                const selectedTab = document.getElementById(`${tabName}-tab`);
                if (selectedTab) selectedTab.classList.add('active');

                const menuItem = document.querySelector(`[onclick="switchTab('${tabName}')"]`);
                if (menuItem) menuItem.closest('.kt-tab-item').classList.add('kt-tab-active');
            }

            function editContent_duplicate(learningMaterialId) {
                window.location.href = '<?= base_url('admin/apps/materials/') ?>' + learningMaterialId;
            }

            function downloadContent_duplicate(learningMaterialId) {
                const files = Array.isArray(window.contentFiles) ? window.contentFiles : [];
                if (!files.length) {
                    showPageAlert?.('warning', 'Bu içerikye ait indirilebilir bir dosya bulunamadı.', 'Dosya Bulunamadı');
                    return;
                }
                const firstFile = files[0];
                const url = `${window.downloadBaseUrl}/${firstFile.id}`;
                const link = document.createElement('a');
                link.href = url;
                link.download = firstFile.file_name ?? 'Egitim-Icerigi-Dosyasi';
                document.body.appendChild(link);
                link.click();
                link.remove();
            }
        </script>

        <script>
            window.CURRENT_USER = {
                id: <?= (int) (session('user_id') ?? 0) ?>,
                role_id: <?= (int) (session('role_id') ?? 0) ?>
            };
        </script>
        <script>
            window.CONTENT_REVIEW_META = <?= json_encode($content['reviewers'] ?? ['total' => 0, 'pending' => 0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{ "total": 0, "pending": 0 }' ?>;
        </script>

        <script>
            const CONTENT_ID = <?= (int) $content['id'] ?>;
            window.CONTENT_ID = CONTENT_ID;
            let CURRENT_STATE = null;
            let UI_ACTIONS = [];

            async function fetchUIActions() {
                const headers = {
                    'Accept': 'application/json',
                    'X-User-Id': (window.CURRENT_USER?.id || '').toString(),
                    'X-Role-Id': (window.CURRENT_USER?.role_id || '').toString(),
                };

                let resp = await fetch(`/api/materials/${CONTENT_ID}/ui-actions`, {
                    headers
                });
                if (resp.ok) {
                    const json = await safeJson(resp);
                    if (json?.success) {
                        CURRENT_STATE = json.data.state;
                        UI_ACTIONS = json.data.actions || [];
                        return;
                    }
                }

                const [stateResp, actionsResp] = await Promise.all([
                    fetch(`/api/materials/${CONTENT_ID}/state`, {
                        headers
                    }),
                    fetch(`/api/materials/${CONTENT_ID}/actions`, {
                        headers
                    }),
                ]);

                const stateJson = await safeJson(stateResp);
                const actionsJson = await safeJson(actionsResp);

                if (!stateJson?.success) throw new Error(stateJson?.error || 'State alınamadı');
                if (!actionsJson?.success) throw new Error(actionsJson?.error || 'Actions alınamadı');

                CURRENT_STATE = stateJson.data.state;
                UI_ACTIONS = (actionsJson.data.actions || []).map(code => ({
                    type: 'process',
                    code,
                    label: labelFor(code),
                }));
            }

            function renderActionButtons() {
                const container = document.getElementById('actionsBar');
                if (!container) return;

                container.innerHTML = '';
                let hasActions = false;

                const reviewMeta = window.CONTENT_REVIEW_META || {};
                const activeAssignments = Number(reviewMeta.pending || reviewMeta.total || 0);
                const hasOpenReviewerTasks = activeAssignments > 0;

                if (UI_ACTIONS.length) {
                    hasActions = true;
                    UI_ACTIONS.forEach(action => {
                        const btn = buttonEl(
                            action.label || labelFor(action.code),
                            styleFor(action.code),
                            () => {
                                if (action.type === 'redirect') {
                                    window.location.href = action.url;
                                    return;
                                }
                                openActionModal(action.code);
                            },
                            action.code
                        );
                        container.appendChild(btn);
                    });
                }

                const roleId = Number(window.CURRENT_USER?.role_id || 0);
                const isAdmin = [1, 2].includes(roleId);

                if (
                    CURRENT_STATE === 'kordeğerlendiricilik'
                    && isAdmin
                    && typeof openAssignReviewersModal === 'function'
                    && !hasOpenReviewerTasks
                ) {
                    hasActions = true;
                    const assignBtn = document.createElement('button');
                    assignBtn.type = 'button';
                    assignBtn.className = 'kt-btn kt-btn-outline flex items-center gap-1.5';
                    assignBtn.style.cssText = 'border-color: #3b82f6; color: #3b82f6; font-weight: bold;';
                    assignBtn.setAttribute('data-kt-modal-toggle', '#assignReviewersModal');
                    assignBtn.innerHTML = `<i class="ki-filled ki-user-plus" style="color: #3b82f6;"></i>Değerlendirici Ata`;
                    assignBtn.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        openAssignReviewersModal();
                    });
                    container.appendChild(assignBtn);
                }

                if (!hasActions) {
                    container.innerHTML = '<span class="text-sm text-muted-foreground">Bu aşamada işlem yok.</span>';
                }
            }
            window.renderActionButtons = renderActionButtons;
            window.fetchUIActions = fetchUIActions;



            function buttonEl(text, className, onClick, code) {
                const button = document.createElement('button');
                button.className = className;
                button.textContent = text;
                button.type = 'button';
                if (code) {
                    button.setAttribute('data-kt-modal-toggle', '#actionModal');
                    button.setAttribute('data-content-action', code);
                }
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    if (typeof onClick === 'function') {
                        onClick(event);
                    }
                });

                // Inline style ekle
                if (code) {
                    button.style.cssText = getButtonStyle(code);
                }

                return button;
            }

            function labelFor(code) {
                const map = {
                    onay: 'Onayla',
                    red: 'Reddet',
                    revizyon: 'Düzeltme İste',
                    onizleme: 'Önizleme',
                    yayinla: 'Yayına Al',
                    revizyonok: 'Revizyonu Gönder',
                    // Olası diğer kodlar
                    'REVIZYON': 'Düzeltme İste',
                    'RED': 'Reddet',
                    'ONAY': 'Onayla',
                };
                const result = map[code] || code.toUpperCase();
                return result;
            }

            function styleFor(code) {
                // Onay butonları - yeşil
                if (['onay', 'yayinla', 'revizyonok'].includes(code)) {
                    return 'kt-btn kt-btn-outline kt-btn-sm';
                }
                // Red butonu - kırmızı
                if (code === 'red') {
                    return 'kt-btn kt-btn-outline kt-btn-sm';
                }
                // Revizyon butonu - turuncu/sarı
                if (code === 'revizyon') {
                    return 'kt-btn kt-btn-outline kt-btn-sm';
                }
                // Diğer butonlar - mavi
                return 'kt-btn kt-btn-outline kt-btn-sm';
            }

            function getButtonStyle(code) {
                // Onay butonları - yeşil
                if (['onay', 'yayinla', 'revizyonok'].includes(code)) {
                    return 'border-color: #10b981; color: #10b981; font-weight: bold;';
                }
                // Red butonu - kırmızı
                if (code === 'red') {
                    return 'border-color: #ef4444; color: #ef4444; font-weight: bold;';
                }
                // Revizyon butonu - turuncu/sarı
                if (code === 'revizyon') {
                    return 'border-color: #f59e0b; color: #f59e0b; font-weight: bold;';
                }
                // Diğer butonlar - mavi
                return 'border-color: #3b82f6; color: #3b82f6; font-weight: bold;';
            }

            async function safeJson(resp) {
                try {
                    return await resp.json();
                } catch {
                    return null;
                }
            }

            (async () => {
                try {
                    await fetchUIActions();
                    renderActionButtons();
                    switchTab('info');
                } catch (error) {
                    console.error(error);
                    showPageAlert?.('destructive', 'Aksiyonlar alınamadı', 'Hata');
                }
            })();

            // Content state değişikliklerini dinle
            window.addEventListener('contentStateChanged', async (event) => {
                try {
                    await fetchUIActions();
                    renderActionButtons();
                } catch (error) {
                    console.error('State değişikliği sonrası güncelleme hatası:', error);
                } finally {
                    setTimeout(() => {
                        window.location.reload();
                    }, 400);
                }
            });
        </script>
        <script>
            async function submitProcessAction(code) {
                // Modal’dan gelen veri (varsa)
                const actionData = window.currentActionData || {};
                const description = actionData.description || '';
                const file = actionData.file || null;

                const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-User-Id': (window.CURRENT_USER?.id || '').toString(),
                    'X-Role-Id': (window.CURRENT_USER?.role_id || '').toString(),
                };

                // NOT: Eğer dosya upload’ı zorunluysa FormData kullanın (aşağıda örnek var).
                const body = JSON.stringify({
                    action: code, // 'onay' | 'red' | 'revizyon' | 'revizyonok' ...
                    note: description
                });

                const resp = await fetch(`/api/materials/${CONTENT_ID}/action`, {
                    method: 'POST',
                    headers,
                    body
                });

                const json = await safeJson(resp);
                if (!resp.ok || !json?.success) {
                    throw new Error(json?.error || 'İşlem başarısız');
                }

                // Backend’in döndürdüğü yeni state & actions’ı baz al
                CURRENT_STATE = json.data?.state || CURRENT_STATE;
                const nextActions = json.data?.actions || [];
                UI_ACTIONS = nextActions.map(action => {
                    if (typeof action === 'string') {
                        return {
                            type: 'process',
                            code: action,
                            label: labelFor(action),
                        };
                    }
                    return {
                        type: action.type || 'process',
                        code: action.code,
                        label: action.label || labelFor(action.code),
                        url: action.url,
                    };
                });

                if (json.data?.reviewers) {
                    window.CONTENT_REVIEW_META = {
                        total: Number(json.data.reviewers.total) || 0,
                        pending: Number(json.data.reviewers.pending) || 0,
                    };
                }

                // UI’ı tazele
                renderActionButtons();

                // Bilgi mesajı
                const msgMap = {
                    onay: 'Eğitim içeriği onaylandı',
                    red: 'Eğitim içeriği reddedildi',
                    revizyon: 'Revizyon istendi',
                    revizyonok: 'Revizyon gönderildi'
                };
                showPageAlert?.('success', msgMap[code] || 'İşlem başarılı', 'İşlem Tamam');

                if (code === 'onay') {
                    setTimeout(() => {
                        window.location.reload();
                    }, 600);
                }

                // Temizlik
                window.currentActionData = null;
            }

            // Eğer dosyayla birlikte göndermek gerekirse bu versiyonu kullanın:
            async function submitProcessActionWithFile(code) {
                const actionData = window.currentActionData || {};
                const description = actionData.description || '';
                const file = actionData.file || null;

                const headers = {
                    'Accept': 'application/json',
                    'X-User-Id': (window.CURRENT_USER?.id || '').toString(),
                    'X-Role-Id': (window.CURRENT_USER?.role_id || '').toString(),
                };

                const fd = new FormData();
                fd.append('action', code);
                fd.append('note', description);
                if (file) fd.append('file', file);

                const resp = await fetch(`/api/materials/${CONTENT_ID}/action`, {
                    method: 'POST',
                    headers,
                    body: fd
                });

                const json = await safeJson(resp);
                if (!resp.ok || !json?.success) throw new Error(json?.error || 'İşlem başarısız');

                CURRENT_STATE = json.data?.state || CURRENT_STATE;
                const fileActions = json.data?.actions || [];
                UI_ACTIONS = fileActions.map(action => {
                    if (typeof action === 'string') {
                        return {
                            type: 'process',
                            code: action,
                            label: labelFor(action),
                        };
                    }
                    return {
                        type: action.type || 'process',
                        code: action.code,
                        label: action.label || labelFor(action.code),
                        url: action.url,
                    };
                });

                if (json.data?.reviewers) {
                    window.CONTENT_REVIEW_META = {
                        total: Number(json.data.reviewers.total) || 0,
                        pending: Number(json.data.reviewers.pending) || 0,
                    };
                }

                renderActionButtons();
                showPageAlert?.('success', 'İşlem başarılı', 'İşlem Tamam');
                window.currentActionData = null;
            }

            // Eski fonksiyonları bu yardımcıya yönlendirin:
            async function approveContent_old(learningMaterialId) {
                try {
                    await submitProcessAction('onay');
                } catch (e) {
                    showPageAlert?.('destructive', e.message || 'Onay başarısız', 'Hata');
                }
            }
            async function rejectContent_old(learningMaterialId) {
                try {
                    await submitProcessAction('red');
                } catch (e) {
                    showPageAlert?.('destructive', e.message || 'Red başarısız', 'Hata');
                }
            }
            async function revisionContent_old(learningMaterialId) {
                try {
                    await submitProcessAction('revizyon');
                } catch (e) {
                    showPageAlert?.('destructive', e.message || 'Revizyon başarısız', 'Hata');
                }
            }

            // showPageAlert fonksiyonu
            function showPageAlert(type, message, title = null) {
                let pageAlertContainer = document.getElementById('pageAlertContainer');
                if (!pageAlertContainer) {
                    pageAlertContainer = document.createElement('div');
                    pageAlertContainer.id = 'pageAlertContainer';
                    pageAlertContainer.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 10000;
                    max-width: 400px;
                    width: 100%;
                `;
                    document.body.appendChild(pageAlertContainer);
                }

                const alertId = 'pageAlert_' + Date.now();
                const alertClass = `kt-alert-${type}`;
                const alertTitle = title || getDefaultTitle(type);

                const alertHTML = `
                <div class="kt-alert kt-alert-light ${alertClass} mb-3" id="${alertId}" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div class="kt-alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                    </div>
                    <div class="kt-alert-title">${alertTitle}</div>
                    <div class="kt-alert-toolbar">
                        <div class="kt-alert-actions">
                            <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

                pageAlertContainer.insertAdjacentHTML('beforeend', alertHTML);

                setTimeout(() => {
                    const alert = document.getElementById(alertId);
                    if (alert) {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateX(100%)';
                        alert.style.transition = 'all 0.3s ease';
                        setTimeout(() => {
                            alert.remove();
                            if (pageAlertContainer.children.length === 0) {
                                pageAlertContainer.remove();
                            }
                        }, 300);
                    }
                }, 4000);
            }
            window.showPageAlert = showPageAlert;

            function getDefaultTitle(type) {
                const titles = {
                    success: 'Başarılı!',
                    primary: 'Bilgi',
                    info: 'Bilgi',
                    warning: 'Uyarı',
                    destructive: 'Hata'
                };
                return titles[type] || 'Bilgi';
            }
        </script>


        <?= $this->endSection() ?>

        <?= $this->section('modals') ?>
        <?php if ($canManageEditors): ?>
            <?= $this->include('app/modals/add-editor-modal', ['learningMaterialId' => $content['id'] ?? 0]) ?>
        <?php endif; ?>
        <?= $this->include('app/processModals/AssignReviewersModal') ?>
        <?= $this->endSection() ?>
