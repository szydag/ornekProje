<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>

<?php
$roleIds = session('role_ids') ?? [];
$roleIds = is_array($roleIds) ? $roleIds : [];
$isAdmin = in_array(1, $roleIds, true);
$hasManagementAccess = $isAdmin;
?>


<div class="kt-container-fixed grow pb-5 max-w-none px-2 sm:px-4" id="content">

    <style>
        .hero-bg {
            background-image: url('assets/media/images/2600x1200/bg-1.png');
        }

        .dark .hero-bg {
            background-image: url('assets/media/images/2600x1200/bg-1-dark.png');
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
    </style>
    <div class="bg-center bg-cover bg-no-repeat hero-bg">
        <!-- Container -->
        <div class="kt-container-fixed max-w-none px-2 sm:px-4">
            <div class="flex flex-col items-start gap-2 lg:gap-3.5 py-3 sm:py-4 lg:pt-5 lg:pb-10">
                <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-1.5 w-full">
                    <div class="text-base sm:text-lg leading-5 font-semibold text-mono flex-1 min-w-0" id="course-title">
                        <?= esc($course['title'] ?? 'Kurs') ?>
                    </div>
                </div>
                </img>
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
                                    Kurs Bilgileri
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="editors">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('editors')"
                                data-role="editors">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Yöneticiler
                                </span>
                            </a>
                        </div>
                        <div class="kt-tab-item border-b-2 border-b-transparent" data-role="contents">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-1 sm:px-2" onclick="switchTab('contents')"
                                data-role="contents">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Eğitim İçerikleri
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-start justify-end grow lg:grow-0 lg:pb-4 gap-2.5 mb-3 lg:mb-0">
                <button class="kt-btn kt-btn-outline sm:w-auto" style="border-color: #3b82f6; color: #3b82f6; font-weight: bold;"
                    onclick="openEncyclopediaEditModal()" data-kt-modal-toggle="#editEncyclopediaModal">
                    <i class="ki-filled ki-pencil me-1" style="color: #3b82f6;"></i>
                    Düzenle
                </button>
                <?php if ($hasManagementAccess): ?>
                    <button class="kt-btn kt-btn-outline sm:w-auto" style="border-color: #10b981; color: #10b981; font-weight: bold;"
                        data-kt-modal-toggle="#addManagerModal">
                        <i class="ki-filled ki-users me-1" style="color: #10b981;"></i>
                        Yönetici Ekle
                    </button>
                    <button class="kt-btn kt-btn-outline sm:w-auto" style="border-color: #ef4444; color: #ef4444; font-weight: bold;"
                        data-kt-modal-toggle="#confirmationModal"
                        onclick="setConfirmationData('delete', <?= $course['id'] ?>)">
                        <i class="ki-filled ki-trash me-1" style="color: #ef4444;"></i>
                        Sil
                    </button>
                <?php endif; ?>
                <!-- işlem eklenirse  açabiliriz
                <div data-kt-dropdown="true" data-kt-dropdown-placement="bottom-end"
                    data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
                    <button class="kt-dropdown-toggle kt-btn kt-btn-icon kt-btn-outline" data-kt-dropdown-toggle="true">
                        <i class="ki-filled ki-dots-vertical">
                        </i>
                    </button>
                    
                    <div class="kt-dropdown-menu w-full max-w-[220px]" data-kt-dropdown-menu="true">
                        <ul class="kt-dropdown-menu-sub">
                            <li>
                                <button class="kt-dropdown-menu-link" data-kt-dropdown-dismiss="true" data-kt-modal-toggle="#share_profile_modal">
                                    <i class="ki-filled ki-coffee">
                                    </i>
                                    Share Profile
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                    -->
            </div>
        </div>
    </div>

    <!-- Tab İçerikleri -->
    <div class="tab-content active" id="info-tab">
        <!-- Kurs Temel Bilgileri -->
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Temel Bilgiler</h3>
            </div>
            <div class="kt-card-content">
                <div class="space-y-6">
                    <!-- Temel Bilgiler Grid -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="kt-card">
                            <div class="kt-card-content">
                                <h4 class="text-sm font-semibold text-mono mb-3 flex items-center gap-2">
                                    <i class="ki-filled ki-book text-primary"></i>
                                    Kurs Bilgileri
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-muted-foreground">Başlık</label>
                                        <h2 class="text-lg font-semibold text-mono mt-1" id="detail-title">
                                            <?= esc($course['title'] ?? 'Kurs') ?>
                                        </h2>
                                    </div>

                                    <?php if (!empty($course['description'])): ?>
                                        <div id="description-section">
                                            <label class="text-sm font-medium text-muted-foreground">Açıklama</label>
                                            <div class="kt-card mt-2">
                                                <div class="kt-card-content">
                                                    <p class="text-sm leading-relaxed" id="detail-description">
                                                        <?= esc($course['description']) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <label class="text-sm font-medium text-muted-foreground">Başlangıç
                                            Tarihi</label>
                                        <p class="text-sm font-medium mt-1" id="detail-start-date">
                                            <?= !empty($course['start_date']) ? date('d.m.Y', strtotime($course['start_date'])) : '-' ?>
                                        </p>
                                    </div>

                                    <?php if (!empty($course['end_date'])): ?>
                                        <div id="end-date-section">
                                            <label class="text-sm font-medium text-muted-foreground">Bitiş Tarihi</label>
                                            <p class="text-sm font-medium mt-1" id="detail-end-date">
                                                <?= date('d.m.Y', strtotime($course['end_date'])) ?>
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <div id="unlimited-section">
                                            <label class="text-sm font-medium text-muted-foreground">Durum</label>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">
                                                    Süresiz Kurs
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yöneticiler Sekmesi -->
    <div class="tab-content" id="editors-tab">
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Kurs Yöneticileri</h3>
            </div>
            <div class="kt-card-content">
                <?php if (!empty($course['editors'])): ?>
                    <!-- Desktop Table View -->
                    <div class="hidden md:block kt-scrollable-x-auto">
                        <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true"
                            id="editors_table">
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
                                                Yönetici Adı
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
                                    <th class="min-w-[200px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                E-posta
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[150px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Kurum
                                            </span>
                                            <span class="kt-table-col-sort"></span>
                                        </span>
                                    </th>
                                    <th class="min-w-[100px]">
                                        <span class="kt-table-col">
                                            <span class="kt-table-col-label">
                                                Ülke
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
                                <?php foreach ($course['editors'] as $index => $editor): ?>
                                    <tr>
                                        <td>
                                            <div class="flex items-center justify-center gap-1">
                                                <span class="kt-badge kt-badge-outline kt-badge-primary">
                                                    <?= $index + 1 ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col">
                                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#"
                                                        title="<?= esc($editor['name']) ?>">
                                                        <?= esc($editor['name']) ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-badge text-xs text-muted-foreground"></i>
                                                <span class="text-sm text-foreground">
                                                    <?= esc($editor['title'] ?? '-') ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-sms text-xs text-muted-foreground"></i>
                                                <span class="text-sm text-foreground">
                                                    <?= esc($editor['email']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-home text-xs text-muted-foreground"></i>
                                                <span class="text-sm text-foreground">
                                                    <?= esc($editor['institution'] ?? '-') ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-geolocation text-xs text-muted-foreground"></i>
                                                <span class="text-sm text-foreground">
                                                    <?= esc($editor['country'] ?? '-') ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center justify-center gap-1">
                                                <span class="kt-badge kt-badge-outline kt-badge-success">
                                                    <?= esc($editor['role'] ?? 'Yönetici') ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center justify-center gap-1">
                                                <a class="kt-badge kt-badge-outline kt-badge-primary" href="#" title="Detay"
                                                    onclick="viewEditorDetail(<?= $editor['id'] ?>)">
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
                        <?php foreach ($course['editors'] as $index => $editor): ?>
                            <div class="kt-card">
                                <div class="kt-card-content p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary">#<?= $index + 1 ?></span>
                                            <h4 class="text-sm font-medium"><?= esc($editor['name'] . ' ' . ($editor['surname'] ?? '')) ?></h4>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <i class="ki-filled ki-user text-xs text-muted-foreground"></i>
                                            <span class="text-xs text-muted-foreground">Ünvan:</span>
                                            <span class="text-sm text-foreground"><?= esc($editor['title'] ?? '-') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ki-filled ki-sms text-xs text-muted-foreground"></i>
                                            <span class="text-xs text-muted-foreground">E-posta:</span>
                                            <span class="text-sm text-foreground"><?= esc($editor['email']) ?></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ki-filled ki-home text-xs text-muted-foreground"></i>
                                            <span class="text-xs text-muted-foreground">Kurum:</span>
                                            <span class="text-sm text-foreground"><?= esc($editor['institution'] ?? '-') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ki-filled ki-geolocation text-xs text-muted-foreground"></i>
                                            <span class="text-xs text-muted-foreground">Ülke:</span>
                                            <span class="text-sm text-foreground"><?= esc($editor['country'] ?? '-') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-muted-foreground">Rol:</span>
                                            <span class="kt-badge kt-badge-outline kt-badge-success">
                                                <?= esc($editor['role'] ?? 'Yönetici') ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-border">
                                        <a class="kt-btn kt-btn-sm kt-btn-outline kt-btn-primary sm:w-auto" href="#" title="Detay"
                                            onclick="viewEditorDetail(<?= $editor['id'] ?>)">
                                            Detay Görüntüle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                            <i class="ki-filled ki-profile-user text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-mono mb-2">Yönetici Bulunamadı</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            Bu kursye henüz yönetici atanmamış.
                        </p>
                        <?php if ($hasManagementAccess): ?>
                            <button class="kt-btn kt-btn-primary" data-kt-modal-toggle="#addEncyclopediaModal"
                                onclick="openAddEditorModal(<?= $course['id'] ?>)">
                                <i class="ki-filled ki-user-plus me-2"></i>
                                Yönetici Ekle
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Eğitim İçerikleri Sekmesi -->
    <div class="tab-content" id="contents-tab">
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Kurs Eğitim İçeriklerii</h3>
                <div class="kt-card-toolbar">
                    <span class="kt-badge kt-badge-outline kt-badge-primary">
                        <?= count($course['contents'] ?? []) ?> içerik
                    </span>
                </div>
            </div>
            <div class="kt-card-content">
                <?php if (!empty($course['contents'])): ?>
                    <div class="space-y-4">
                        <?php foreach ($course['contents'] as $content): ?>
                            <?php $encryptedArticleId = App\Helpers\EncryptHelper::encrypt((string) $content['id']); ?>
                            <div class="kt-card">
                                <div class="kt-card-content">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="flex items-center justify-center size-10 rounded-full bg-primary/10">
                                                    <i class="ki-filled ki-document text-primary"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-mono truncate">
                                                        <?= esc($content['title']) ?>
                                                    </h4>
                                                    <p class="text-xs text-secondary-foreground">
                                                        <?= esc($content['authors'][0]['name'] ?? 'Katkıda Bulunan bilinmiyor') ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4 text-xs text-secondary-foreground mb-2">
                                                <span class="flex items-center gap-1">
                                                    <i class="ki-filled ki-calendar"></i>
                                                    <?= date('d.m.Y', strtotime($content['created_at'])) ?>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="ki-filled ki-eye"></i>
                                                    <?= number_format($content['views'] ?? 0) ?>
                                                </span>
                                                <span
                                                    class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?? 'primary' ?> kt-badge-sm">
                                                    <?= esc($content['status'] ?? 'Bilinmiyor') ?>
                                                </span>
                                            </div>

                                            <p class="text-xs text-secondary-foreground line-clamp-2">
                                                <?= esc($content['abstract']) ?>
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button class="kt-btn kt-btn-sm kt-btn-outline"
                                                onclick="viewArticleDetail('<?= $encryptedArticleId ?>')">
                                                <i class="ki-filled ki-eye text-sm"></i>
                                                Detay
                                            </button>
                                            <button class="kt-btn kt-btn-sm kt-btn-outline kt-btn-danger"
                                                data-kt-modal-toggle="#confirmationModal"
                                                onclick="setConfirmationData('removeArticle', <?= $content['id'] ?>)">
                                                <i class="ki-filled ki-trash text-sm"></i>
                                                Sil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                            <i class="ki-filled ki-document text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-mono mb-2">İçerik Bulunamadı</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            Bu kursye henüz içerik eklenmemiş.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<?= $this->include('app/modals/add-course-modal') ?>

<!-- Edit Course Modal -->
<?= $this->include('app/modals/edit-course-modal') ?>

<!-- Confirmation Dialog Modal -->
<?= $this->include('app/modals/confirmation-modal') ?>

<script>
    // Global değişken - kurs verisini sakla (PHP'den gelen veri ile başlat)
    let currentEncyclopedia = <?= json_encode($course) ?>;
    let currentEncyclopediaId = <?= $course['id'] ?? 0 ?>;
    const addManagerUrl = <?= isset($course['id'])
                                ? json_encode(base_url('admin/api/encyclopedias/' . $course['id'] . '/managers'))
                                : 'null' ?>;

    // Sayfa yüklendiğinde - PHP'den gelen veriyi kullan, gereksiz AJAX çağrısı YOK!
    document.addEventListener('DOMContentLoaded', function() {});

    // ============================================
    // Yardımcı Fonksiyonlar (Modal ve diğer işlemler için gerekli)
    // ============================================

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('tr-TR');
    }

    function numberFormat(number) {
        return new Intl.NumberFormat('tr-TR').format(number);
    }

    // Tab switching functionality
    function switchTab(tabName) {
        // Hide ALL tabs by removing active class
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // Remove active from menu i                                                                tems
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

    // Kurs düzenleme modalını aç
    function openEncyclopediaEditModal() {
        if (!currentEncyclopedia) {
            alert('Kurs verisi yüklenmedi. Lütfen sayfayı yenileyin.');
            return false;
        }

        // Yöneticileri yükle
        if (typeof loadEditManagers === 'function') {
            loadEditManagers();
        }

        // Hataları temizle
        if (typeof clearEditAlerts === 'function') {
            clearEditAlerts();
        }
        if (typeof clearAllEditErrors === 'function') {
            clearAllEditErrors();
        }

        // Modal açıldıktan sonra form doldur
        setTimeout(() => {
            const idField = document.getElementById('edit_course_id');
            const nameField = document.getElementById('edit_encyclopedia_name-input');
            const descField = document.getElementById('edit_encyclopedia_description-input');
            const startDateField = document.getElementById('edit_start_date-input');
            const endDateField = document.getElementById('edit_end_date-input');
            const unlimitedCheckbox = document.getElementById('edit_unlimited-checkbox');

            // Form alanlarını doldur
            if (idField) idField.value = currentEncyclopedia.id || '';
            if (nameField) nameField.value = currentEncyclopedia.title || '';
            if (descField) descField.value = currentEncyclopedia.description || '';

            // Başlangıç tarihi
            if (startDateField && currentEncyclopedia.start_date) {
                const startDate = new Date(currentEncyclopedia.start_date);
                startDateField.value = startDate.toISOString().split('T')[0];
            }

            // Bitiş tarihi veya süresiz
            const isUnlimited = currentEncyclopedia.indefinite == 1 ||
                currentEncyclopedia.indefinite === true ||
                currentEncyclopedia.indefinite === '1' ||
                currentEncyclopedia.unlimited == 1 ||
                currentEncyclopedia.unlimited === true ||
                currentEncyclopedia.unlimited === '1' ||
                !currentEncyclopedia.end_date;

            if (isUnlimited) {
                if (unlimitedCheckbox) unlimitedCheckbox.checked = true;
                if (endDateField) {
                    endDateField.disabled = true;
                    endDateField.value = '';
                }
            } else if (endDateField && currentEncyclopedia.end_date) {
                const endDate = new Date(currentEncyclopedia.end_date);
                endDateField.value = endDate.toISOString().split('T')[0];
                endDateField.disabled = false;
                if (unlimitedCheckbox) unlimitedCheckbox.checked = false;
            } else {
                if (unlimitedCheckbox) unlimitedCheckbox.checked = true;
                if (endDateField) {
                    endDateField.disabled = true;
                    endDateField.value = '';
                }
            }

            // Yönetici seçimini yap
            setTimeout(() => {
                if (typeof selectCurrentManager === 'function') {
                    selectCurrentManager(currentEncyclopedia);
                }
            }, 1000);

        }, 250);

        return true;
    }

    function openAddEditorModal(courseId) {
        // Modal başlığını güncelle
        const modalTitle = document.querySelector('#addEncyclopediaModal .kt-modal-header h3');
        if (modalTitle) {
            modalTitle.textContent = 'Yönetici Ekle';
        }

        // Modal ikonunu güncelle
        const modalIcon = document.querySelector('#addEncyclopediaModal .kt-modal-header i');
        if (modalIcon) {
            modalIcon.className = 'ki-filled ki-users text-primary text-xl';
        }

        // Form'u temizle
        const form = document.getElementById('addEncyclopediaForm');
        if (form) {
            form.reset();
        }

        // Kaydet butonunu güncelle
        const saveButton = document.querySelector('#addEncyclopediaModal .kt-modal-footer button:last-child');
        if (saveButton) {
            saveButton.textContent = 'Yönetici Ekle';
            saveButton.onclick = function() {
                addEditorToEncyclopedia(courseId);
            };
        }
    }

    function addEditorToEncyclopedia(courseId) {
        const form = document.getElementById('addEncyclopediaForm');
        if (!form) return;

        const formData = new FormData(form);

        // Modal'ı kapat
        const dismissButton = document.querySelector('#addEncyclopediaModal [data-kt-modal-dismiss="true"]');
        if (dismissButton) {
            dismissButton.click();
        }

        // Başarı mesajı göster
        showPageAlert('success', 'Yönetici başarıyla eklendi!', 'İşlem Başarılı');
    }

    function deleteEncyclopedia(courseId) {
        // TODO: Kurs silme işlemi
        showPageAlert('destructive', 'Kurs başarıyla silindi!', 'İşlem Tamamlandı');
    }

    function viewEditorDetail(editorId) {
        // TODO: Yönetici detay modalı veya sayfası aç
        showPageAlert('primary', 'Yönetici detay sayfasına yönlendiriliyor...', 'Yönlendiriliyor');
    }

    function viewArticleDetail(encryptedArticleId) {
        window.location.href = '<?= base_url('admin/apps/materials/') ?>' + encryptedArticleId;
    }

    function removeContent(learningMaterialId) {
        // TODO: İçerik çıkarma işlemi
        showPageAlert('destructive', 'İçerik kurstan çıkarıldı!', 'İşlem Tamamlandı');
    }
</script>

<!-- Yönetici Ekleme Modal'ı -->
<?= $this->include('app/modals/add-manager') ?>

<?= $this->endSection() ?>