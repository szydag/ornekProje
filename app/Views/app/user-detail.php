<?= $this->extend('app/layouts/main') ?>

<?= $this->section('style') ?>
<style>
    .kt-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .kt-container-fixed {
        max-width: none !important;
        width: 100% !important;
        padding: 0 1rem !important;
    }

    /* Responsive Container */
    @media (min-width: 640px) {
        .kt-container-fixed {
            padding: 0 1.5rem !important;
        }
    }

    @media (min-width: 1024px) {
        .kt-container-fixed {
            padding: 0 2rem !important;
        }
    }

    /* Responsive Page Padding */
    .page-content {
        padding: 1rem !important;
    }

    @media (min-width: 640px) {
        .page-content {
            padding: 1.5rem !important;
        }
    }

    @media (min-width: 1024px) {
        .page-content {
            padding: 2rem !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <!-- Header -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Kullanıcı Detayı
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    <?= esc($user['name']) ?> - <?= $roleNames[$user['role']] ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Header -->

    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Sol Kolon - Kullanıcı Bilgileri -->
            <div class="lg:col-span-1">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Kullanıcı Bilgileri</h3>
                    </div>
                    <div class="kt-card-content">
                        <div class="flex flex-col items-center gap-4">
                            
                            <!-- Kullanıcı Adı -->
                            <div class="text-center">
                                <h2 class="text-lg font-semibold text-mono"><?= esc($user['name']) ?></h2>
                                <?php if (!empty($user['title'])): ?>
                                    <p class="text-sm text-secondary-foreground"><?= esc($user['title']) ?></p>
                                <?php endif; ?>
                                <p class="text-xs text-muted-foreground"><?= $roleNames[$user['role']] ?></p>
                            </div>
                            
                            <!-- İletişim Bilgileri -->
                            <div class="w-full space-y-1">
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-sms text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">E-posta</p>
                                        <a href="mailto:<?= esc($user['email']) ?>" class="text-sm text-primary hover:underline">
                                            <?= esc($user['email']) ?>
                                        </a>
                                    </div>
                                </div>
                                
                                <?php if (!empty($user['phone'])): ?>
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-phone text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Telefon</p>
                                        <a href="tel:<?= esc($user['phone']) ?>" class="text-sm text-primary hover:underline">
                                            <?= esc($user['phone']) ?>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($user['title'])): ?>
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-award text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Ünvan</p>
                                        <p class="text-sm text-secondary-foreground">
                                            <?= esc($user['title']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($user['institution'])): ?>
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-abstract-41 text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Kurum</p>
                                        <p class="text-sm text-secondary-foreground">
                                            <?= esc($user['institution']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($user['country'])): ?>
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-geolocation text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Ülke</p>
                                        <p class="text-sm text-secondary-foreground">
                                            <?= esc($user['country']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($user['city'])): ?>
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-geolocation text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Şehir</p>
                                        <p class="text-sm text-secondary-foreground">
                                            <?= esc($user['city']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-calendar text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Kayıt Tarihi</p>
                                        <p class="text-sm text-secondary-foreground">
                                            <?= date('d.m.Y H:i', strtotime($user['created_at'] ?? 'now')) ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 p-1.5 bg-accent/5 rounded-lg">
                                    <i class="ki-filled ki-setting text-primary"></i>
                                    <div>
                                        <p class="text-sm font-medium">Rol</p>
                                        <span class="kt-badge kt-badge-outline kt-badge-primary">
                                            <?= $roleNames[$user['role']] ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Sağ Kolon - Eğitim İçerikleri ve Kursler -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Kullanıcının Eğitim İçeriklerii -->
                <div class="kt-card mb-2">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Eğitim İçerikleri</h3>
                        <div class="kt-card-toolbar">
                            <span class="kt-badge kt-badge-outline kt-badge-primary">
                                <?= count($userContents) ?> içerik
                            </span>
                        </div>
                    </div>
                    <div class="kt-card-content">
                        <?php if (!empty($userContents)): ?>
                            <div class="space-y-2">
                                <?php foreach ($userContents as $content): ?>
                                    <?php
                                        $contentCreatedAt = $content['created_at'] ?? null;
                                        $contentDate = $contentCreatedAt ? date('d.m.Y', strtotime($contentCreatedAt)) : '-';
                                        $encryptedContentId = $content['encrypted_id'] ?? App\Helpers\EncryptHelper::encrypt((string) ($content['id'] ?? ''));
                                    ?>
                                    <div class="flex items-center justify-between p-3 border border-border rounded-lg hover:bg-accent/5 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <!-- Eğitim İçeriği İkonu -->
                                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10">
                                                <i class="ki-filled ki-document text-primary"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-semibold text-mono"><?= esc($content['title']) ?></h4>
                                                <p class="text-xs text-secondary-foreground">
                                                    <?= esc($contentDate) ?> • 
                                                    <span class="kt-badge kt-badge-outline kt-badge-<?= $content['status_color'] ?? 'primary' ?> kt-badge-sm">
                                                        <?= esc($content['status'] ?? 'Bilinmiyor') ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('admin/apps/materials/' . $encryptedContentId) ?>" 
                                           class="kt-btn kt-btn-sm kt-btn-outline">
                                            Detay
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <div class="flex items-center justify-center size-16 rounded-full bg-muted mb-4 mx-auto">
                                    <i class="ki-filled ki-document text-2xl text-muted-foreground"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-mono mb-2">Henüz içerik yok</h3>
                                <p class="text-sm text-secondary-foreground">
                                    Bu kullanıcı henüz hiç içerik oluşturmamış.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Kullanıcının Kursleri -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Kursler</h3>
                        <div class="kt-card-toolbar">
                            <span class="kt-badge kt-badge-outline kt-badge-primary">
                                <?= count($userCourses) ?> kurs
                            </span>
                        </div>
                    </div>
                    <div class="kt-card-content">
                        <?php if (!empty($userCourses)): ?>
                            <div class="space-y-4">
                                <?php foreach ($userCourses as $course): ?>
                                    <?php
                                        $encyCreatedAt = $course['created_at'] ?? null;
                                        $encyDate = $encyCreatedAt ? date('d.m.Y', strtotime($encyCreatedAt)) : '-';
                                        $encryptedCourseId = $course['encrypted_id'] ?? App\Helpers\EncryptHelper::encrypt((string) ($course['id'] ?? ''));
                                    ?>
                                    <div class="flex items-center justify-between p-3 border border-border rounded-lg hover:bg-accent/5 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <!-- Kurs İkonu -->
                                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10">
                                                <i class="ki-filled ki-folder text-primary"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-semibold text-mono"><?= esc($course['name']) ?></h4>
                                                <p class="text-xs text-secondary-foreground">
                                                    <?= esc($encyDate) ?> • 
                                                    <span class="kt-badge kt-badge-outline kt-badge-<?= $course['status_color'] ?? 'primary' ?> kt-badge-sm">
                                                        <?= esc($course['status'] ?? 'Bilinmiyor') ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('admin/apps/courses/' . $encryptedCourseId) ?>" 
                                           class="kt-btn kt-btn-sm kt-btn-outline">
                                            Detay
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <div class="flex items-center justify-center size-16 rounded-full bg-muted mb-4 mx-auto">
                                    <i class="ki-filled ki-folder text-2xl text-muted-foreground"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-mono mb-2">Henüz kurs yok</h3>
                                <p class="text-sm text-secondary-foreground">
                                    Bu kullanıcı henüz hiç kurs oluşturmamış.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    function changeUserRole(userId) {
        // TODO: Yetki değiştirme modalı açılacak
        alert('Yetki değiştirme özelliği yakında eklenecek! Kullanıcı ID: ' + userId);
    }
</script>

<?= $this->endSection() ?>
