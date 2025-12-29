<?= $this->extend('app/layouts/main') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="grow pt-5" id="content" role="content">
    <!-- Container -->
    <?php
    // Kullanıcı/Katkıda Bulunan Dashboard - Kendi içeriklerini takip et
    $myContentsCount = 5;
    $publishedCount = 2;
    $inReviewCount = 2;
    $draftCount = 1;

    $userStats = [
        ['label' => 'Toplam İçerik', 'count' => $myContentsCount, 'color' => 'primary', 'icon' => 'ki-book'],
        ['label' => 'Yayında', 'count' => $publishedCount, 'color' => 'success', 'icon' => 'ki-check-circle'],
        ['label' => 'İncelemede', 'count' => $inReviewCount, 'color' => 'warning', 'icon' => 'ki-time'],
        ['label' => 'Taslak', 'count' => $draftCount, 'color' => 'secondary', 'icon' => 'ki-file-sheet'],
    ];

    $myContents = [
        [
            'id' => 1,
            'title' => 'Yapay Zeka Destekli Medikal Görüntüleme',
            'status_text' => 'Yayında',
            'status_color' => 'success',
            'submission_date' => '12.03.2024',
            'last_update' => '15.03.2024',
            'views' => 324,
            'current_stage' => 'Yayın aşamasında',
            'can_edit' => false,
        ],
        [
            'id' => 2,
            'title' => 'Derin Öğrenme ile Görüntü İşleme',
            'status_text' => 'Değerlendirici Değerlendirmesinde',
            'status_color' => 'warning',
            'submission_date' => '05.03.2024',
            'last_update' => '10.03.2024',
            'views' => 0,
            'current_stage' => 'Değerlendirici değerlendirmesi bekleniyor',
            'can_edit' => false,
        ],
        [
            'id' => 3,
            'title' => 'Makine Öğrenmesi ile Veri Analizi',
            'status_text' => 'Revizyon Gerekli',
            'status_color' => 'danger',
            'submission_date' => '28.02.2024',
            'last_update' => '08.03.2024',
            'views' => 0,
            'current_stage' => 'Değerlendirici önerileri doğrultusunda revizyon bekleniyor',
            'can_edit' => true,
            'revision_notes' => 'Metodoloji bölümü güçlendirilmeli, kaynakça güncellenmeli.',
        ],
        [
            'id' => 4,
            'title' => 'Nörobilimde Yapay Sinir Ağı Uygulamaları',
            'status_text' => 'Yayında',
            'status_color' => 'success',
            'submission_date' => '15.02.2024',
            'last_update' => '28.02.2024',
            'views' => 567,
            'current_stage' => 'Yayın aşamasında',
            'can_edit' => false,
        ],
        [
            'id' => 5,
            'title' => 'Blockchain Teknolojisinde Güvenlik Protokolleri',
            'status_text' => 'Taslak',
            'status_color' => 'secondary',
            'submission_date' => '10.10.2024',
            'last_update' => '14.10.2024',
            'views' => 0,
            'current_stage' => 'Henüz gönderilmedi - Taslak aşamasında',
            'can_edit' => true,
        ],
    ];

    $notifications = [
        [
            'title' => 'Revizyon Gerekli',
            'message' => 'İçerik #3 için değerlendirici önerileri geldi. Lütfen revizyonları yapınız.',
            'time' => '2 gün önce',
            'type' => 'warning',
            'icon' => 'ki-information-2',
            'action_url' => '#',
        ],
        [
            'title' => 'İçerik Yayında',
            'message' => 'İçerik #1 başarıyla yayınlandı ve erişime açıldı.',
            'time' => '1 hafta önce',
            'type' => 'success',
            'icon' => 'ki-check-circle',
            'action_url' => '#',
        ],
        [
            'title' => 'Değerlendirici Ataması Yapıldı',
            'message' => 'İçerik #2 için değerlendirici ataması tamamlandı. Değerlendirme süreci başladı.',
            'time' => '2 hafta önce',
            'type' => 'info',
            'icon' => 'ki-user',
            'action_url' => '#',
        ],
    ];

    $quickLinks = [
        [
            'title' => 'Yeni İçerik Gönder',
            'description' => 'Yeni bir içerik başvurusu yapın',
            'icon' => 'ki-file-added',
            'color' => 'primary',
            'url' => base_url('app/add-material'),
        ],
        [
            'title' => 'İçeriklerim',
            'description' => 'Tüm içeriklerinizi görüntüleyin',
            'icon' => 'ki-book-open',
            'color' => 'info',
            'url' => base_url('apps/my-materials'),
        ],
        [
            'title' => 'Profilim',
            'description' => 'Profil bilgilerinizi düzenleyin',
            'icon' => 'ki-user',
            'color' => 'success',
            'url' => base_url('app/my-profile'),
        ],
        [
            'title' => 'Yardım',
            'description' => 'İçerik gönderim rehberi',
            'icon' => 'ki-question-2',
            'color' => 'warning',
            'url' => '#',
        ],
    ];
    ?>

    <div class="kt-container-fixed space-y-7.5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-2">
                <h1 class="text-xl font-semibold text-mono">
                    Hoş Geldiniz, <?= esc(session('user_name') ?? 'Kullanıcı') ?>!
                </h1>
                <p class="text-sm text-secondary-foreground">Eğitim İçerikleriinizi yönetin ve yeni başvuru yapın.</p>
            </div>
        </div>

        <!-- İstatistik Kartları -->
        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4 mb-5 mt-5">
            <style>
                .channel-stats-bg {
                    background-image: url('assets/media/images/2600x1600/bg-3.png');
                }

                .dark .channel-stats-bg {
                    background-image: url('assets/media/images/2600x1600/bg-3-dark.png');
                }
            </style>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-book text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono"><?= esc($myContentsCount) ?></span>
                    <span class="text-sm font-medium text-secondary-foreground">Toplam İçerik</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-check-circle text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono"><?= esc($publishedCount) ?></span>
                    <span class="text-sm font-medium text-secondary-foreground">Yayında</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-time text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono"><?= esc($inReviewCount) ?></span>
                    <span class="text-sm font-medium text-secondary-foreground">İncelemede</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-file-sheet text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono"><?= esc($draftCount) ?></span>
                    <span class="text-sm font-medium text-secondary-foreground">Taslak</span>
                </div>
            </content>
        </section>

        <!-- İçerik Analizi -->
        <div class="lg:col-span-2 mb-5">
            <div class="kt-card h-full">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="ki-filled ki-chart-simple text-primary"></i>
                        İçerik Analizi
                    </h3>
                    <div class="flex gap-5">
                        <label class="flex items-center gap-2">
                            <input class="kt-switch" name="check" type="checkbox" value="1" />
                            <span class="kt-label">Sadece yayınlananlar</span>
                        </label>
                        <select class="kt-select w-36" data-kt-select="true"
                            data-kt-select-placeholder="Zaman aralığı seç" name="kt-select">
                            <option>Yok</option>
                            <option value="1">1 ay</option>
                            <option value="2">3 ay</option>
                            <option value="3">6 ay</option>
                            <option value="4">12 ay</option>
                        </select>
                    </div>
                </div>
                <div class="kt-card-content flex flex-col justify-end items-stretch grow px-3 py-1">
                    <div id="earnings_chart"></div>
                </div>
            </div>
        </div>

        <!-- Kullanıcı Yönetim Paneli -->
        <div class="grid gap-5 lg:grid-cols-2 mb-5">
            <!-- Hızlı Erişim -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="ki-filled ki-rocket text-primary"></i>
                        Hızlı Erişim
                    </h3>
                </div>
                <div class="kt-card-content">
                    <div class="space-y-3">
                        <a href="<?= base_url('app/add-material') ?>"
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-primary/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">Yeni İçerik Gönder</span>
                                <span class="text-xs text-secondary-foreground">Yeni bir içerik başvurusu yapın</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-primary">
                                <i class="ki-filled ki-plus"></i>
                            </button>
                        </a>
                        <a href="<?= base_url('apps/my-materials') ?>"
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-primary/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">İçeriklerim</span>
                                <span class="text-xs text-secondary-foreground">Tüm içeriklerinizi görüntüleyin</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-primary">
                                <i class="ki-filled ki-book"></i>
                            </button>
                        </a>
                        <a href="<?= base_url('app/my-profile') ?>"
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-primary/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">Profilim</span>
                                <span class="text-xs text-secondary-foreground">Profil bilgilerinizi düzenleyin</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-primary">
                                <i class="ki-filled ki-user"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bildirimler -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="ki-filled ki-notification text-primary"></i>
                        Bildirimler
                    </h3>
                </div>
                <div class="kt-card-content">
                    <div class="space-y-3">
                        <div
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-warning/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">Revizyon Gerekli</span>
                                <span class="text-xs text-secondary-foreground">İçerik #3 için değerlendirici önerileri
                                    geldi</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-warning">
                                <i class="ki-filled ki-pencil"></i>
                            </button>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-warning/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">İçerik Yayında</span>
                                <span class="text-xs text-secondary-foreground">İçerik #1 başarıyla yayınlandı</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-warning">
                                <i class="ki-filled ki-eye"></i>
                            </button>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-warning/5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-foreground">Değerlendirici Ataması</span>
                                <span class="text-xs text-secondary-foreground">İçerik #2 için değerlendirici ataması
                                    tamamlandı</span>
                            </div>
                            <button class="kt-btn kt-btn-sm kt-btn-warning">
                                <i class="ki-filled ki-user"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?= $this->endSection() ?>