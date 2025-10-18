<?php
$roleIds = session('role_ids') ?? [];
$roleIds = is_array($roleIds) ? $roleIds : [];
$isAdmin = in_array(1, $roleIds, true);
$isManager = in_array(2, $roleIds, true);
$hasManagementAccess = $isAdmin || $isManager;
$hasReviewerRole = in_array(4, $roleIds, true);
$hasEditorAssignments = (bool) (session('has_editor_assignments') ?? false);

$currentUri = uri_string();
$isAdminSection = strpos($currentUri, 'admin') === 0;

$baseMenuItems = [
    ['url' => base_url('/'), 'title' => 'Ana Sayfa', 'icon' => 'ki-home-2', 'type' => 'single'],
    ['url' => base_url('apps/my-materials'), 'title' => 'İçeriklerim', 'icon' => 'ki-book', 'type' => 'single'],
    ['url' => base_url('app/add-material'), 'title' => 'İçerik Ekle', 'icon' => 'ki-plus', 'type' => 'single'],
];

if ($hasReviewerRole) {
    $baseMenuItems[] = ['url' => base_url('apps/reviewer-materials'), 'title' => 'Değerlendirme', 'icon' => 'ki-people', 'type' => 'single'];
}

if ($hasEditorAssignments) {
    $baseMenuItems[] = ['url' => base_url('apps/editor-materials'), 'title' => 'Editörlük', 'icon' => 'ki-pencil', 'type' => 'single'];
}

if ($hasManagementAccess && $isAdminSection) {
    $menuItems = [
        ['url' => base_url('admin'), 'title' => 'Ana Sayfa', 'icon' => 'ki-home-2', 'type' => 'single'],
        ['url' => base_url('admin/apps/materials'), 'title' => 'Eğitim İçerikleri', 'icon' => 'ki-book', 'type' => 'single'],
        ['url' => base_url('admin/apps/courses'), 'title' => 'Kurslar', 'icon' => 'ki-folder', 'type' => 'single'],
        ['url' => base_url('admin/app/users'), 'title' => 'Kullanıcılar', 'icon' => 'ki-users', 'type' => 'single'], // admin tarafında farklı rota varsa onu yaz
    ];
} else {
    $menuItems = $baseMenuItems;
}

?>

<div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    <div class="kt-sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
        id="sidebar_header">
        <a class="dark:hidden flex flex-col items-center" href="<?= base_url('/') ?>"
            style="transition: all 0.3s ease-in-out;">
            <img class="small-logo h-10 w-auto max-w-none transition-all duration-300 ease-in-out z-10"
                src="<?= base_url('assets/media/app/educontent-emblem.svg') ?>" />
            <img class="default-logo min-h-[22px] max-w-none mt-2 transition-all duration-300 ease-in-out z-20"
                src="<?= base_url('assets/media/app/educontent-logo.svg') ?>" />
        </a>
        <a class="hidden dark:block flex flex-col items-center" href="<?= base_url('/') ?>"
            style="transition: all 0.3s ease-in-out;">
            <img class="small-logo h-10 w-auto max-w-none transition-all duration-300 ease-in-out z-10"
                src="<?= base_url('assets/media/app/educontent-emblem.svg') ?>" />
            <img class="default-logo min-h-[22px] max-w-none mt-2 transition-all duration-300 ease-in-out z-20"
                src="<?= base_url('assets/media/app/educontent-logo.svg') ?>" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon size-[30px] absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:kt-toggle-active:rotate-0">
            </i>
        </button>
    </div>
    <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <!-- Sidebar Menu -->
            <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false"
                id="sidebar_menu">

                <?php foreach ($menuItems as $item): ?>

                    <?php if ($item['type'] === 'heading'): ?>
                        <div class="kt-menu-item pt-2.25 pb-px">
                            <span
                                class="kt-menu-heading uppercase text-xs font-medium text-muted-foreground ps-[10px] pe-[10px]">
                                <?= $item['title'] ?>
                            </span>
                        </div>

                    <?php elseif ($item['type'] === 'single'): ?>
                        <?php
                        $isActive = false;

                        if ($isAdminSection) {
                        switch ($item['title']) {
                            case 'Ana Sayfa':
                                $isActive = ($currentUri === 'admin');
                                break;
                            case 'Eğitim İçerikleri':
                                $isActive = ($currentUri === 'admin/apps/materials' || preg_match('/^admin\/apps\/materials\/[A-Za-z0-9+\/=]+$/', $currentUri));
                                break;
                            case 'Kurslar':
                                $isActive = ($currentUri === 'admin/apps/courses' || preg_match('/^admin\/apps\/courses\/[A-Za-z0-9+\/=]+$/', $currentUri));
                                break;
                                case 'Kullanıcılar':
                                    $isActive = ($currentUri === 'admin/app/users' || preg_match('/^admin\/app\/user-detail\/[A-Za-z0-9+\/=]+$/', $currentUri));
                                    break;
                            }
                        } else {
                            if ($item['title'] === 'Ana Sayfa') {
                                $isActive = ($currentUri === '' || $currentUri === '/');
                            } elseif ($item['title'] === 'İçerik Ekle') {
                                $isActive = strpos($currentUri, 'add-material') !== false;
                            } elseif ($item['title'] === 'İçeriklerim') {
                                $isActive = ($currentUri === 'apps/my-materials' || preg_match('/^apps\/materials\/[A-Za-z0-9+\/=]+$/', $currentUri));
                            } elseif ($item['title'] === 'Değerlendirme') {
                                $isActive = ($currentUri === 'apps/reviewer-materials');
                            } elseif ($item['title'] === 'Editörlük') {
                                $isActive = ($currentUri === 'apps/editor-materials');
                            } elseif ($item['title'] === 'Kullanıcılar') {
                                $isActive = ($currentUri === 'app/users' || preg_match('/^app\/user-detail\/\d+$/', $currentUri));
                            } elseif ($item['title'] === 'Yönetim') {
                                $isActive = $isAdminSection;
                            }
                        }

                        if (!$isActive) {
                            $itemPath = trim((string) parse_url($item['url'], PHP_URL_PATH), '/');
                            if ($itemPath === '') {
                                $itemPath = trim(str_replace(['http://', 'https://'], '', $item['url']), '/');
                                $itemPath = preg_replace('/^[^\/]+\//', '', $itemPath);
                            }
                            $isActive = ($currentUri === $itemPath);
                        }
                        ?>

                        <div class="kt-menu-item">
                            <a class="kt-menu-link flex items-center grow border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px] w-full text-left
                                      <?= $isActive ? 'kt-menu-item-active bg-accent/60 rounded-lg' : 'hover:bg-accent/60 hover:rounded-lg' ?>"
                                href="<?= $item['url'] ?>" tabindex="0">
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i class="ki-filled <?= $item['icon'] ?> text-lg"></i>
                                </span>
                                <span
                                    class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary">
                                    <?= $item['title'] ?>
                                </span>
                            </a>
                        </div>

                    <?php elseif ($item['type'] === 'label'): ?>
                        <div class="kt-menu-item">
                            <div class="kt-menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" href=""
                                tabindex="0">
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i class="ki-filled <?= $item['icon'] ?> text-lg"></i>
                                </span>
                                <span class="kt-menu-title text-sm font-medium text-foreground">
                                    <?= $item['title'] ?>
                                </span>
                                <?php if (!empty($item['badge'])): ?>
                                    <span class="kt-menu-badge me-[-10px]">
                                        <span class="kt-badge kt-badge-sm text-accent-foreground/60">
                                            <?= $item['badge'] ?>
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
            <!-- End of Sidebar Menu -->
        </div>
    </div>
</div>
