<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>

<main class="grow pt-5" id="content" role="content">
    <?php
    // Staff Dashboard - Optimized version
    $session = session();
    $roleIds = $session->get('role_ids') ?? [];
    $roleIds = is_array($roleIds) ? $roleIds : array_filter([$roleIds]);

    // Optimized role detection
    $isAdmin = in_array(1, $roleIds, true);
    $isManager = in_array(2, $roleIds, true);
    $isSecretary = in_array(3, $roleIds, true);
    $isEditor = in_array(5, $roleIds, true);

    // Optimized role-based configuration
    $roleConfig = [
        1 => ['title' => 'Yönetici Paneli', 'desc' => 'Sistem genelinde tüm işlemleri yönetin ve raporları görüntüleyin.'],
        2 => ['title' => 'Yönetici Paneli', 'desc' => 'Departmanınızı yönetin ve içerik süreçlerini takip edin.'],
        3 => ['title' => 'Sekreterya Paneli', 'desc' => 'Eğitim içeriği başvurularını ve idari işlemleri yönetin.'],
        5 => ['title' => 'Editör Paneli', 'desc' => 'Eğitim İçeriklerii kontrol edin ve yayınlama kararları verin.']
    ];

    $currentRoleId = array_intersect($roleIds, [1, 2, 3, 5])[0] ?? 0;
    $config = $roleConfig[$currentRoleId] ?? ['title' => 'Personel Paneli', 'desc' => 'Sistem işlemlerini yönetin.'];

    // Enhanced role-based data configuration with improved metrics
    $roleData = [
        1 => [ // Admin - Enhanced with system metrics
            'stats' => [
                ['label' => 'Toplam Kullanıcı', 'count' => 252, 'color' => 'primary', 'icon' => 'ki-user'],
                ['label' => 'Son 24 Saat', 'count' => 45, 'color' => 'success', 'icon' => 'ki-user-check'],
                ['label' => 'Sistem Yükü', 'count' => '23%', 'color' => 'info', 'icon' => 'ki-chart-line'],
                ['label' => 'Kritik Uyarı', 'count' => 2, 'color' => 'danger', 'icon' => 'ki-warning'],
            ],
            'systemAlerts' => [
                ['type' => 'warning', 'message' => 'Disk kullanımı %85\'e ulaştı', 'time' => '2 saat önce'],
                ['type' => 'info', 'message' => 'Yedekleme başarıyla tamamlandı', 'time' => '4 saat önce'],
            ],
            'recentActivity' => [
                ['user' => 'Dr. Ayşe Demir', 'action' => 'Yeni içerik gönderdi', 'time' => '15 dakika önce'],
                ['user' => 'Prof. Mehmet Kaya', 'action' => 'Eğitim içeriği revizyonu tamamladı', 'time' => '32 dakika önce'],
                ['user' => 'Elif Yıldız', 'action' => 'Sistem girişi yaptı', 'time' => '1 saat önce'],
            ]
        ],
        2 => [ // Manager - Enhanced with performance metrics
            'stats' => [
                ['label' => 'Departman Eğitim İçeriklerii', 'count' => 89, 'color' => 'primary', 'icon' => 'ki-book'],
                ['label' => 'Değerlendirici Performansı', 'count' => '8.5/10', 'color' => 'success', 'icon' => 'ki-star'],
                ['label' => 'Hedef vs Gerçek', 'count' => '95%', 'color' => 'info', 'icon' => 'ki-target'],
                ['label' => 'Kalite Trendi', 'count' => '+12%', 'color' => 'success', 'icon' => 'ki-trending-up'],
            ],
            'categoryAnalysis' => [
                ['category' => 'Teknoloji', 'count' => 35, 'percentage' => 39],
                ['category' => 'Sağlık', 'count' => 28, 'percentage' => 31],
                ['category' => 'Çevre', 'count' => 18, 'percentage' => 20],
                ['category' => 'Diğer', 'count' => 8, 'percentage' => 9],
            ],
            'reviewerWorkload' => [
                ['name' => 'Dr. Ahmet Yılmaz', 'assigned' => 8, 'completed' => 6, 'pending' => 2],
                ['name' => 'Prof. Zeynep Özkan', 'assigned' => 6, 'completed' => 5, 'pending' => 1],
                ['name' => 'Doç. Burak Karaca', 'assigned' => 7, 'completed' => 4, 'pending' => 3],
            ]
        ],
        3 => [ // Secretary - Enhanced with communication metrics
            'stats' => [
                ['label' => 'Yeni Başvurular', 'count' => 8, 'color' => 'primary', 'icon' => 'ki-file-added'],
                ['label' => 'Başvuru Trendi', 'count' => '+15%', 'color' => 'success', 'icon' => 'ki-trending-up'],
                ['label' => 'Belge Eksikliği', 'count' => 15, 'color' => 'warning', 'icon' => 'ki-file-sheet'],
                ['label' => 'İletişim Bekleyen', 'count' => 8, 'color' => 'info', 'icon' => 'ki-message-text'],
            ],
            'applications' => [
                ['id' => '#MAK-2411', 'title' => 'Yeni Nesil Blockchain Teknolojileri', 'author' => 'Dr. Ali Veli', 'submittedAt' => '15.03.2024', 'status' => 'İlk Kontrol', 'priority' => 'high', 'documents' => 3, 'missing' => 1],
                ['id' => '#MAK-2412', 'title' => 'Makine Öğrenmesi ile Finansal Analiz', 'author' => 'Prof. Ayşe Yılmaz', 'submittedAt' => '14.03.2024', 'status' => 'Belge Kontrolü', 'priority' => 'medium', 'documents' => 4, 'missing' => 0],
                ['id' => '#MAK-2413', 'title' => 'Sürdürülebilir Enerji Çözümleri', 'author' => 'Elif Demir', 'submittedAt' => '13.03.2024', 'status' => 'Format Kontrolü', 'priority' => 'low', 'documents' => 2, 'missing' => 2],
            ],
            'communicationLog' => [
                ['author' => 'Dr. Ali Veli', 'subject' => 'Belge eksikliği hakkında', 'status' => 'Yanıt bekliyor', 'time' => '2 saat önce'],
                ['author' => 'Prof. Ayşe Yılmaz', 'subject' => 'Eğitim içeriği durumu sorgusu', 'status' => 'Yanıtlandı', 'time' => '4 saat önce'],
                ['author' => 'Elif Demir', 'subject' => 'Format düzeltmeleri', 'status' => 'İşlemde', 'time' => '6 saat önce'],
            ]
        ],
        5 => [ // Editor - Enhanced with quality metrics
            'stats' => [
                ['label' => 'Onay Bekleyen', 'count' => 12, 'color' => 'warning', 'icon' => 'ki-time'],
                ['label' => 'Değerlendirici Kalitesi', 'count' => '8.2/10', 'color' => 'success', 'icon' => 'ki-star'],
                ['label' => 'Eğitim İçeriği Kalitesi', 'count' => '7.8/10', 'color' => 'info', 'icon' => 'ki-book'],
                ['label' => 'Onay Oranı', 'count' => '78%', 'color' => 'success', 'icon' => 'ki-check-circle'],
            ],
            'contents' => [
                ['id' => 1, 'title' => 'Yapay Zeka Destekli Medikal Görüntüleme', 'author_name' => 'Dr. Ayşe Demir', 'status_text' => 'Editör Kontrolü', 'status_color' => 'warning', 'referee_status' => '2/2 Değerlendirici Onayı', 'submission_date' => '12.03.2024', 'updated_at' => '15.03.2024', 'priority' => 'high', 'quality_score' => 8.5, 'reviewer_agreement' => 'Yüksek'],
                ['id' => 2, 'title' => 'Kuantum Algoritmalarında Optimizasyon', 'author_name' => 'Prof. Mehmet Kaya', 'status_text' => 'Editör Kontrolü', 'status_color' => 'warning', 'referee_status' => '2/2 Değerlendirici Onayı', 'submission_date' => '11.03.2024', 'updated_at' => '14.03.2024', 'priority' => 'medium', 'quality_score' => 7.2, 'reviewer_agreement' => 'Orta'],
                ['id' => 3, 'title' => 'İklim Modelleme Çalışmalarında Yeni Yaklaşımlar', 'author_name' => 'Elif Yıldız', 'status_text' => 'Editör Kontrolü', 'status_color' => 'warning', 'referee_status' => '1/2 Değerlendirici Revizyonu', 'submission_date' => '10.03.2024', 'updated_at' => '13.03.2024', 'priority' => 'low', 'quality_score' => 6.8, 'reviewer_agreement' => 'Düşük'],
            ],
            'qualityMetrics' => [
                ['metric' => 'Ortalama Değerlendirici Skoru', 'value' => '8.2/10', 'trend' => '+0.3'],
                ['metric' => 'Değerlendirici Uyumsuzluğu', 'value' => '3 içerik', 'trend' => '-1'],
                ['metric' => 'Revizyon Gereken', 'value' => '8 içerik', 'trend' => '+2'],
                ['metric' => 'Kalite Artışı', 'value' => '+5%', 'trend' => '+2%'],
            ]
        ]
    ];

    $currentData = $roleData[$currentRoleId] ?? ['stats' => []];

    // Shared data - cached
    $completionTrend = [['label' => 'Eki', 'value' => 9], ['label' => 'Kas', 'value' => 8], ['label' => 'Ara', 'value' => 7], ['label' => 'Oca', 'value' => 6.5], ['label' => 'Şub', 'value' => 6], ['label' => 'Mar', 'value' => 5.4]];
    $maxCompletionValue = 9;

    $latestContents = [
        ['id' => '#EGT-2410', 'title' => 'Yapay Zeka Destekli Medikal Görüntüleme', 'author' => 'Dr. Ayşe Demir', 'submittedAt' => '12.03.2024'],
        ['id' => '#EGT-2409', 'title' => 'Kuantum Algoritmalarında Optimizasyon', 'author' => 'Prof. Mehmet Kaya', 'submittedAt' => '11.03.2024'],
        ['id' => '#EGT-2408', 'title' => 'İklim Modelleme Çalışmalarında Yeni Yaklaşımlar', 'author' => 'Elif Yıldız', 'submittedAt' => '10.03.2024'],
        ['id' => '#EGT-2407', 'title' => 'Sürdürülebilir Tarım İçin Veri Odaklı Modeller', 'author' => 'Doç. Burak Karaca', 'submittedAt' => '09.03.2024'],
        ['id' => '#EGT-2406', 'title' => 'Blockchain Teknolojisinde Güvenlik Protokolleri', 'author' => 'Dr. Zeynep Özkan', 'submittedAt' => '08.03.2024'],
    ];

    // Enhanced quick links configuration with better descriptions
    $quickLinksConfig = [
        1 => [
            ['title' => 'Kullanıcı Yönetimi', 'desc' => '252 kullanıcıyı yönetin', 'icon' => 'ki-user', 'color' => 'primary', 'url' => base_url('app/users')],
            ['title' => 'Sistem Monitörü', 'desc' => 'CPU, RAM, Disk durumu', 'icon' => 'ki-chart-line', 'color' => 'info', 'url' => '#'],
            ['title' => 'Güvenlik Logları', 'desc' => 'Son 24 saat aktiviteler', 'icon' => 'ki-shield-check', 'color' => 'success', 'url' => '#'],
            ['title' => 'Sistem Ayarları', 'desc' => 'Konfigürasyon yönetimi', 'icon' => 'ki-setting-2', 'color' => 'warning', 'url' => '#']
        ],
        2 => [
            ['title' => 'Eğitim İçeriği Yönetimi', 'desc' => '89 departman içeriksi', 'icon' => 'ki-book', 'color' => 'primary', 'url' => base_url('app/contents')],
            ['title' => 'Değerlendirici Ataması', 'desc' => '12 bekleyen atama', 'icon' => 'ki-user', 'color' => 'info', 'url' => '#'],
            ['title' => 'Performans Analizi', 'desc' => '8.5/10 değerlendirici skoru', 'icon' => 'ki-star', 'color' => 'success', 'url' => '#'],
            ['title' => 'Kategori Raporu', 'desc' => 'Teknoloji %39, Sağlık %31', 'icon' => 'ki-chart-simple', 'color' => 'warning', 'url' => '#']
        ],
        3 => [
            ['title' => 'Başvuru Merkezi', 'desc' => '8 yeni başvuru', 'icon' => 'ki-file-added', 'color' => 'primary', 'url' => '#'],
            ['title' => 'Belge Kontrolü', 'desc' => '15 eksik belge', 'icon' => 'ki-file-sheet', 'color' => 'warning', 'url' => '#'],
            ['title' => 'İletişim Paneli', 'desc' => '8 bekleyen mesaj', 'icon' => 'ki-message-text', 'color' => 'info', 'url' => '#'],
            ['title' => 'Toplantı Takvimi', 'desc' => '3 planlanmış toplantı', 'icon' => 'ki-calendar', 'color' => 'success', 'url' => '#']
        ],
        5 => [
            ['title' => 'Eğitim İçeriği Kontrolü', 'desc' => '12 onay bekleyen', 'icon' => 'ki-eye', 'color' => 'warning', 'url' => '#'],
            ['title' => 'Kalite Analizi', 'desc' => '8.2/10 değerlendirici skoru', 'icon' => 'ki-star', 'color' => 'success', 'url' => '#'],
            ['title' => 'Yayın Kararları', 'desc' => '%78 onay oranı', 'icon' => 'ki-check-circle', 'color' => 'primary', 'url' => '#'],
            ['title' => 'Uyumsuzluk Raporu', 'desc' => '3 değerlendirici uyumsuzluğu', 'icon' => 'ki-warning', 'color' => 'danger', 'url' => '#']
        ]
    ];

    $quickLinks = $quickLinksConfig[$currentRoleId] ?? [];
    ?>
    <div class="kt-container-fixed space-y-7.5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-2">
                <h1 class="text-xl font-semibold text-mono">
                    Hoş Geldiniz, <?= esc(session('user_name') ?? 'Kullanıcı') ?>!
                </h1>
                <p class="text-sm text-secondary-foreground"><?= esc($config['desc']) ?></p>
            </div>
        </div>

        <!-- Genel Sistem İstatistikleri -->
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
                <i class="ki-filled ki-user text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono">1,247</span>
                    <span class="text-sm font-medium text-secondary-foreground">Toplam Kullanıcı</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-book text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono">3,456</span>
                    <span class="text-sm font-medium text-secondary-foreground">Toplam Eğitim İçeriği</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-book text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono">89</span>
                    <span class="text-sm font-medium text-secondary-foreground">Kurs Sayısı</span>
                </div>
            </content>

            <content class="kt-card channel-stats-bg flex flex-col justify-between gap-6 bg-cover bg-no-repeat p-5">
                <i class="ki-filled ki-user text-2xl text-primary"></i>
                <div class="flex flex-col gap-1">
                    <span class="text-3xl font-semibold text-mono">156</span>
                    <span class="text-sm font-medium text-secondary-foreground">Aktif Değerlendirici</span>
                </div>
            </content>
        </section>

        <?php if ($currentRoleId === 2): ?>
            <!-- Manager için Değerlendirici İş Yükü -->
            <div class="grid gap-5 lg:grid-cols-2 mb-5">
                <!-- Değerlendirici İş Yükü -->
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-chart-simple text-primary"></i>
                            Kategori Analizi
                        </h3>
                    </div>
                    <div class="kt-card-content flex items-center justify-center">
                        <div id="category_chart" style="width: 300px; height: 300px;"></div>
                    </div>
                </div>

                <!-- Değerlendirici İş Yükü -->
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-user text-primary"></i>
                            Değerlendirici İş Yükü
                        </h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-3">
                            <?php foreach ($currentData['reviewerWorkload'] as $reviewer): ?>
                                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-info/5">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-medium text-foreground"><?= esc($reviewer['name']) ?></span>
                                        <span class="text-xs text-secondary-foreground"><?= esc($reviewer['assigned']) ?> atama • <?= esc($reviewer['completed']) ?> tamamlandı</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="text-xs px-2 py-1 bg-success/10 text-success rounded"><?= esc($reviewer['completed']) ?></span>
                                        <span class="text-xs px-2 py-1 bg-warning/10 text-warning rounded"><?= esc($reviewer['pending']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($currentRoleId === 3): ?>
            <!-- Secretary enhanced content -->
            <div class="grid gap-5 lg:grid-cols-2 mb-5">
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-file-added text-primary"></i>
                            Yeni Başvurular
                        </h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-3">
                            <?php foreach ($currentData['applications'] as $app): ?>
                                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-primary/5">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-medium text-foreground"><?= esc($app['title']) ?></span>
                                        <span class="text-xs text-secondary-foreground"><?= esc($app['author']) ?> • <?= esc($app['submittedAt']) ?></span>
                                        <div class="flex gap-2 mt-1">
                                            <span class="text-xs text-info"><?= esc($app['documents']) ?> belge</span>
                                            <?php if ($app['missing'] > 0): ?>
                                                <span class="text-xs text-danger"><?= esc($app['missing']) ?> eksik</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded"><?= esc($app['id']) ?></span>
                                        <span class="text-xs px-2 py-1 bg-<?= esc($app['priority'] === 'high' ? 'danger' : ($app['priority'] === 'medium' ? 'warning' : 'info')) ?>/10 text-<?= esc($app['priority'] === 'high' ? 'danger' : ($app['priority'] === 'medium' ? 'warning' : 'info')) ?> rounded"><?= esc($app['status']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-message-text text-primary"></i>
                            İletişim Geçmişi
                        </h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-3">
                            <?php foreach ($currentData['communicationLog'] as $comm): ?>
                                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-info/5">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-medium text-foreground"><?= esc($comm['author']) ?></span>
                                        <span class="text-xs text-secondary-foreground"><?= esc($comm['subject']) ?></span>
                                    </div>
                                    <div class="flex flex-col gap-1 text-right">
                                        <span class="text-xs px-2 py-1 bg-<?= esc($comm['status'] === 'Yanıtlandı' ? 'success' : ($comm['status'] === 'Yanıt bekliyor' ? 'warning' : 'info')) ?>/10 text-<?= esc($comm['status'] === 'Yanıtlandı' ? 'success' : ($comm['status'] === 'Yanıt bekliyor' ? 'warning' : 'info')) ?> rounded"><?= esc($comm['status']) ?></span>
                                        <span class="text-xs text-secondary-foreground"><?= esc($comm['time']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Diğer roller için grafik ve tablolar -->

            <!-- Grafik ve Tablolar -->
            <div class="grid gap-5 lg:grid-cols-2 mb-5">
                <!-- Tamamlanma Trendi -->
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-chart-line text-primary"></i>
                            Tamamlanma Trendi
                        </h3>
                    </div>
                    <div class="kt-card-content flex flex-col justify-end items-stretch grow px-3 py-1">
                        <div id="completion_chart"></div>
                    </div>
                </div>

                <!-- Son Eğitim İçerikleri -->
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-book text-primary"></i>
                            Son Eğitim İçerikleri
                        </h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="space-y-3">
                            <?php foreach (array_slice($latestContents, 0, 5) as $content): ?>
                                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-primary/5">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-medium text-foreground"><?= esc($content['title']) ?></span>
                                        <span class="text-xs text-secondary-foreground"><?= esc($content['author']) ?> • <?= esc($content['submittedAt']) ?></span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded"><?= esc($content['id']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($currentRoleId === 5): ?>
                <!-- Editor enhanced content -->
                <div class="grid gap-5 lg:grid-cols-2 mb-5">
                    <!-- Kontrol Edilecek Eğitim İçerikleri -->
                    <div class="kt-card h-full">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">
                                <i class="ki-filled ki-eye text-primary"></i>
                                Kontrol Edilecek Eğitim İçerikleri
                            </h3>
                        </div>
                        <div class="kt-card-content">
                            <div class="space-y-3">
                                <?php foreach ($currentData['contents'] as $content): ?>
                                    <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300 hover:bg-warning/5">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-medium text-foreground"><?= esc($content['title']) ?></span>
                                            <span class="text-xs text-secondary-foreground"><?= esc($content['author_name']) ?> • <?= esc($content['referee_status']) ?></span>
                                            <div class="flex gap-2 mt-1">
                                                <span class="text-xs text-info">Kalite: <?= esc($content['quality_score']) ?>/10</span>
                                                <span class="text-xs text-<?= esc($content['reviewer_agreement'] === 'Yüksek' ? 'success' : ($content['reviewer_agreement'] === 'Orta' ? 'warning' : 'danger')) ?>">Uyum: <?= esc($content['reviewer_agreement']) ?></span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="text-xs px-2 py-1 bg-<?= esc($content['status_color']) ?>/10 text-<?= esc($content['status_color']) ?> rounded"><?= esc($content['status_text']) ?></span>
                                            <span class="text-xs px-2 py-1 bg-<?= esc($content['priority'] === 'high' ? 'danger' : ($content['priority'] === 'medium' ? 'warning' : 'info')) ?>/10 text-<?= esc($content['priority'] === 'high' ? 'danger' : ($content['priority'] === 'medium' ? 'warning' : 'info')) ?> rounded"><?= esc(ucfirst($content['priority'])) ?></span>
                                            <button class="kt-btn kt-btn-sm kt-btn-primary"><i class="ki-filled ki-eye"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Kalite Metrikleri -->
                    <div class="kt-card h-full">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">
                                <i class="ki-filled ki-star text-primary"></i>
                                Kalite Metrikleri
                            </h3>
                        </div>
                        <div class="kt-card-content">
                            <div class="space-y-4">
                                <?php foreach ($currentData['qualityMetrics'] as $metric): ?>
                                    <div class="flex items-center justify-between p-3 rounded-lg border border-gray-300">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-medium text-foreground"><?= esc($metric['metric']) ?></span>
                                            <span class="text-xs text-secondary-foreground"><?= esc($metric['value']) ?></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-2 py-1 bg-<?= esc(strpos($metric['trend'], '+') !== false ? 'success' : 'danger') ?>/10 text-<?= esc(strpos($metric['trend'], '+') !== false ? 'success' : 'danger') ?> rounded"><?= esc($metric['trend']) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="lg:col-span-2 mb-5">
            <div class="kt-card h-full">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="ki-filled ki-chart-simple text-primary"></i>
                        Eğitim İçeriği Analizi
                    </h3>
                    <div class="flex gap-5">
                        <label class="flex items-center gap-2">
                            <input class="kt-switch" name="check" type="checkbox" value="1" />
                            <span class="kt-label">Sadece yayınlananlar</span>
                        </label>
                        <select class="kt-select w-36" data-kt-select="true" data-kt-select-placeholder="Zaman aralığı seç" name="kt-select">
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
    </div>
    <script>
        // Enhanced chart initialization with pie chart
        document.addEventListener('DOMContentLoaded', function() {
            // Completion trend chart
            const chartEl = document.querySelector("#completion_chart");
            if (chartEl && typeof ApexCharts !== 'undefined') {
                const completionData = <?= json_encode($completionTrend) ?>;

                new ApexCharts(chartEl, {
                    series: [{
                        name: 'Tamamlanma',
                        data: completionData.map(item => item.value)
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#3B82F6'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.3,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        categories: completionData.map(item => item.label),
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 12,
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#E5E7EB',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: val => val + " içerik"
                        }
                    }
                }).render();
            } else if (chartEl) {
                chartEl.innerHTML = '<div class="flex items-center justify-center h-64 text-gray-500">Grafik kütüphanesi yüklenemedi</div>';
            }

            // Performance chart for all roles
            const performanceChartEl = document.querySelector("#performance_chart");
            if (performanceChartEl && typeof ApexCharts !== 'undefined') {
                const performanceData = {
                    cpu: [23, 25, 28, 24, 26, 23, 25, 27, 24, 26, 25, 23],
                    memory: [67, 69, 71, 68, 70, 67, 69, 72, 68, 70, 69, 67],
                    disk: [85, 86, 87, 85, 86, 85, 86, 88, 85, 86, 86, 85]
                };

                new ApexCharts(performanceChartEl, {
                    series: [{
                            name: 'CPU',
                            data: performanceData.cpu
                        },
                        {
                            name: 'Bellek',
                            data: performanceData.memory
                        },
                        {
                            name: 'Disk',
                            data: performanceData.disk
                        }
                    ],
                    chart: {
                        type: 'line',
                        height: 200,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#10B981', '#F59E0B', '#EF4444'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        categories: ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '10px'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '10px'
                            },
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    },
                    grid: {
                        borderColor: '#E5E7EB',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '12px'
                    }
                }).render();
            }

            // Category pie chart for Manager role
            const categoryChartEl = document.querySelector("#category_chart");
            if (categoryChartEl && typeof ApexCharts !== 'undefined') {
                const categoryData = <?= json_encode($currentData['categoryAnalysis'] ?? []) ?>;

                if (categoryData.length > 0) {
                    new ApexCharts(categoryChartEl, {
                        series: categoryData.map(item => item.count),
                        chart: {
                            type: 'pie',
                            width: 300,
                            height: 300
                        },
                        colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
                        labels: categoryData.map(item => item.category),
                        dataLabels: {
                            enabled: true,
                            formatter: function(val, opts) {
                                return opts.w.config.labels[opts.seriesIndex];
                            },
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold',
                                colors: ['#ffffff']
                            }
                        },
                        legend: {
                            show: false
                        },
                        tooltip: {
                            y: {
                                formatter: function(val, opts) {
                                    const data = categoryData[opts.dataPointIndex];
                                    return data.category + ': ' + data.count + ' içerik (' + data.percentage + '%)';
                                }
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '50%'
                                }
                            }
                        }
                    }).render();
                }
            }
        });
    </script>
</main>

<?= $this->endSection() ?>