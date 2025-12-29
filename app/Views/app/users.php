<?= $this->extend('app/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$roles = $roles ?? [];
$userRoles = $userRoles ?? [];
$selectedRole = (string) ($selectedRole ?? '');

$rolesById = [];

foreach ($roles as $roleRow) {
    $roleId = (int) ($roleRow['id'] ?? 0);
    $roleName = $roleRow['role_name'] ?? '';
    if ($roleId <= 0 || $roleName === '') {
        continue;
    }
    $rolesById[$roleId] = $roleName;
}
?>


<div class="kt-container-fixed grow pb-5" id="content">
    <style>
        .hero-bg {
            background-image: url('assets/media/images/2600x1200/bg-1.png');
        }

        .dark .hero-bg {
            background-image: url('assets/media/images/2600x1200/bg-1-dark.png');
        }
    </style>
    <div class="bg-center bg-cover bg-no-repeat hero-bg">
        <!-- Container -->
        <div class="kt-container-fixed">
            <div class="flex flex-col items-start gap-2 lg:gap-3.5 py-4 lg:pt-5 lg:pb-10">
                <div class="flex items-start gap-1.5">
                    <div class="text-lg leading-5 font-semibold text-mono">
                        Kullanıcılar
                    </div>
                    <svg class="text-primary" fill="none" height="16" viewBox="0 0 15 16" width="15"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.5425 6.89749L13.5 5.83999C13.4273 5.76877 13.3699 5.6835 13.3312 5.58937C13.2925 5.49525 13.2734 5.39424 13.275 5.29249V3.79249C13.274 3.58699 13.2324 3.38371 13.1527 3.19432C13.0729 3.00494 12.9565 2.83318 12.8101 2.68892C12.6638 2.54466 12.4904 2.43073 12.2998 2.35369C12.1093 2.27665 11.9055 2.23801 11.7 2.23999H10.2C10.0982 2.24159 9.99722 2.22247 9.9031 2.18378C9.80898 2.1451 9.72371 2.08767 9.65249 2.01499L8.60249 0.957487C8.30998 0.665289 7.91344 0.50116 7.49999 0.50116C7.08654 0.50116 6.68999 0.665289 6.39749 0.957487L5.33999 1.99999C5.26876 2.07267 5.1835 2.1301 5.08937 2.16879C4.99525 2.20747 4.89424 2.22659 4.79249 2.22499H3.29249C3.08699 2.22597 2.88371 2.26754 2.69432 2.34731C2.50494 2.42709 2.33318 2.54349 2.18892 2.68985C2.04466 2.8362 1.93073 3.00961 1.85369 3.20013C1.77665 3.39064 1.73801 3.5945 1.73999 3.79999V5.29999C1.74159 5.40174 1.72247 5.50275 1.68378 5.59687C1.6451 5.691 1.58767 5.77627 1.51499 5.84749L0.457487 6.89749C0.165289 7.19 0.00115967 7.58654 0.00115967 7.99999C0.00115967 8.41344 0.165289 8.80998 0.457487 9.10249L1.49999 10.16C1.57267 10.2312 1.6301 10.3165 1.66878 10.4106C1.70747 10.5047 1.72659 10.6057 1.72499 10.7075V12.2075C1.72597 12.413 1.76754 12.6163 1.84731 12.8056C1.92709 12.995 2.04349 13.1668 2.18985 13.3111C2.3362 13.4553 2.50961 13.5692 2.70013 13.6463C2.89064 13.7233 3.0945 13.762 3.29999 13.76H4.79999C4.90174 13.7584 5.00275 13.7775 5.09687 13.8162C5.191 13.8549 5.27627 13.9123 5.34749 13.985L6.40499 15.0425C6.69749 15.3347 7.09404 15.4988 7.50749 15.4988C7.92094 15.4988 8.31748 15.3347 8.60999 15.0425L9.65999 14C9.73121 13.9273 9.81647 13.8699 9.9106 13.8312C10.0047 13.7925 10.1057 13.7734 10.2075 13.775H11.7075C12.1212 13.775 12.518 13.6106 12.8106 13.3181C13.1031 13.0255 13.2675 12.6287 13.2675 12.215V10.715C13.2659 10.6132 13.285 10.5122 13.3237 10.4181C13.3624 10.324 13.4198 10.2387 13.4925 10.1675L14.55 9.10999C14.6953 8.96452 14.8104 8.79176 14.8887 8.60164C14.9671 8.41152 15.007 8.20779 15.0063 8.00218C15.0056 7.79656 14.9643 7.59311 14.8847 7.40353C14.8051 7.21394 14.6888 7.04197 14.5425 6.89749ZM10.635 6.64999L6.95249 10.25C6.90055 10.3026 6.83864 10.3443 6.77038 10.3726C6.70212 10.4009 6.62889 10.4153 6.55499 10.415C6.48062 10.4139 6.40719 10.3982 6.33896 10.3685C6.27073 10.3389 6.20905 10.2961 6.15749 10.2425L4.37999 8.44249C4.32532 8.39044 4.28169 8.32793 4.25169 8.25867C4.22169 8.18941 4.20593 8.11482 4.20536 8.03934C4.20479 7.96387 4.21941 7.88905 4.24836 7.81934C4.27731 7.74964 4.31999 7.68647 4.37387 7.63361C4.42774 7.58074 4.4917 7.53926 4.56194 7.51163C4.63218 7.484 4.70726 7.47079 4.78271 7.47278C4.85816 7.47478 4.93244 7.49194 5.00112 7.52324C5.0698 7.55454 5.13148 7.59935 5.18249 7.65499L6.56249 9.05749L9.84749 5.84749C9.95296 5.74215 10.0959 5.68298 10.245 5.68298C10.394 5.68298 10.537 5.74215 10.6425 5.84749C10.6953 5.90034 10.737 5.96318 10.7653 6.03234C10.7935 6.1015 10.8077 6.1756 10.807 6.25031C10.8063 6.32502 10.7908 6.39884 10.7612 6.46746C10.7317 6.53608 10.6888 6.59813 10.635 6.64999Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
                <div class="flex items-start gap-2 text-sm font-normal text-secondary-foreground">
                    <?php if ($selectedRole !== ''): ?>
                        <?= esc($rolesById[(int) $selectedRole] ?? $selectedRole) ?> rolündeki kullanıcılar
                    <?php else: ?>
                        Tüm takım üyeleri ve rolleri
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>

    <!-- Container -->
    <div class="kt-container-fixed">
        <div
            class="flex items-start flex-wrap md:flex-nowrap lg:items-end justify-between border-b border-b-border gap-3 lg:gap-6 mb-5 lg:mb-10">
            <div class="grid">
                <div class="kt-scrollable-x-auto">
                    <div class="kt-menu gap-3" data-kt-menu="true">
                        <div class="kt-tab-item border-b-2 border-b-transparent <?= $selectedRole === '' ? 'kt-tab-active' : '' ?>"
                            data-role="">
                            <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-2" onclick="filterByRole('')" data-role="">
                                <span
                                    class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                    Tümü
                                </span>
                            </a>
                        </div>
                        <?php foreach ($rolesById as $roleId => $roleName): ?>
                            <div class="kt-tab-item border-b-2 border-b-transparent <?= $selectedRole === (string) $roleId ? 'kt-tab-active' : '' ?>"
                                data-role="<?= esc((string) $roleId) ?>">
                                <a class="kt-tab-link gap-1.5 pb-2 lg:pb-4 px-2"
                                    onclick="filterByRole('<?= esc((string) $roleId, 'js') ?>')"
                                    data-role="<?= esc((string) $roleId) ?>">
                                    <span
                                        class="kt-tab-title text-nowrap font-medium text-sm text-secondary-foreground kt-tab-active:text-primary kt-tab-active:font-semibold kt-tab-hover:text-primary">
                                        <?= esc($roleName) ?>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
            <div class="flex items-start justify-end grow lg:grow-0 lg:pb-4 gap-2.5 mb-3 lg:mb-0">
                <button class="kt-btn kt-btn-primary" data-kt-modal-toggle="#assignPermissionModal">
                    <i class="ki-filled ki-rocket me-2"></i>
                    Yetki Ver
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="kt-card kt-card-grid w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Kullanıcılar
            </h3>
        </div>
        <div class="kt-card-content">
            <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="10">
                <!-- Desktop Table -->
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true" id="users_table">
                        <thead>
                            <tr>
                                <th class="min-w-[300px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Kullanıcı
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
                                <th class="min-w-[160px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Roller
                                        </span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th class="min-w-[150px]">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">
                                            Kayıt Tarihi
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
                            <?php foreach ($users as $user): ?>
                                <?php
                                $userId = (int) ($user['id'] ?? 0);
                                $encryptedUserId = App\Helpers\EncryptHelper::encrypt((string) $userId);
                                $fullNameRaw = trim(($user['name'] ?? '') . ' ' . ($user['surname'] ?? ''));
                                $fullName = $fullNameRaw !== '' ? $fullNameRaw : 'İsimsiz Kullanıcı';
                                $emailAddress = $user['mail'] ?? '';
                                $createdAt = $user['created_at'] ?? null;

                                $assignedRoles = $userRoles[$userId] ?? [];

                                // ID’yi role_id varsa ondan, yoksa id’den çek
                                $roleIdList = array_map(function ($r) {
                                    $id = $r['role_id'] ?? $r['id'] ?? null;
                                    return $id !== null ? (string) (int) $id : '';
                                }, $assignedRoles);

                                $roleIdList = array_filter($roleIdList, fn($v) => $v !== '');
                                $roleDataset = implode('|', $roleIdList);
                                ?>

                                <tr data-user-id="<?= $userId ?>" data-roles="<?= esc($roleDataset) ?>">
                                    <td>
                                        <div class="flex items-start gap-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold text-mono" title="<?= esc($fullName) ?>">
                                                    <?= esc($fullName) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-start gap-2">
                                            <span class="text-sm text-foreground">
                                                <?= esc($emailAddress) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td data-cell="roles">
                                        <div class="flex flex-wrap items-start justify-center gap-1"
                                            data-role-badges="true">
                                            <?php if (!empty($assignedRoles)): ?>
                                                <?php foreach ($assignedRoles as $role): ?>
                                                    <?php $roleName = $role['name'] ?? ''; ?>
                                                    <?php if ($roleName !== ''): ?>
                                                        <span class="kt-badge kt-badge-outline kt-badge-primary">
                                                            <?= esc($roleName) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-xs text-muted-foreground" data-role-empty="true">Rol
                                                    atanmamış</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= $createdAt ? date('d.m.Y', strtotime($createdAt)) : '-' ?></td>
                                    <td>
                                        <div class="flex items-start justify-center gap-1">
                                            <a class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost kt-btn-primary"
                                                href="<?= base_url('admin/app/user-detail/' . $encryptedUserId) ?>"
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
                    <div class="per-page-selector flex items-start gap-2">
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
                            Showing 1 to <?= count($users) ?> of <?= count($users) ?> entries
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
    <!-- End of Users Table -->

    <?php if (empty($users)): ?>
        <!-- Empty State -->
        <div class="empty-state flex flex-col items-center justify-center py-20">
            <div class="flex items-center justify-center size-16 rounded-full bg-muted mb-4">
                <i class="ki-filled ki-users text-2xl text-muted-foreground"></i>
            </div>
            <h3 class="text-lg font-semibold text-mono mb-2 text-center">
                <?php if ($selectedRole): ?>
                    <?= esc($selectedRole) ?> rolünde kullanıcı bulunamadı
                <?php else: ?>
                    Henüz kullanıcı bulunmuyor
                <?php endif; ?>
            </h3>
            <p class="text-sm text-secondary-foreground text-center max-w-md">
                <?php if ($selectedRole): ?>
                    Bu role sahip kullanıcılar henüz eklenmemiş. Yetki atama sayfasından yeni kullanıcılar ekleyebilirsiniz.
                <?php else: ?>
                    Sistemde henüz kullanıcı bulunmuyor. İlk kullanıcıları eklemek için yetki atama sayfasını kullanabilirsiniz.
                <?php endif; ?>
            </p>
            <div class="flex items-center gap-2.5 mt-5">
                <button class="kt-btn kt-btn-primary" data-kt-modal-toggle="#assignPermissionModal">
                    <i class="ki-filled ki-rocket text-sm"></i>
                    Yetki Ata
                </button>
                <button class="kt-btn kt-btn-outline" onclick="filterByRole('')">
                    <i class="ki-filled ki-refresh text-sm"></i>
                    Tümünü Göster
                </button>
            </div>
        </div>
        <!-- End of Empty State -->
    <?php endif; ?>
</div>
<script>
    const ROLE_NAMES = <?= json_encode($rolesById, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script>
    const assignRoleUrl = '<?= base_url('admin/api/users/assign-role') ?>';

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
                'users_table',
                'datatable_users_table',
                'kt_datatable_users_table'
            ];
            for (const key of possibleKeys) {
                if (window.localStorage.getItem(key) !== null) {
                    window.localStorage.removeItem(key);
                }
            }
        } catch (error) {
            console.debug('[Users] Datatable state reset skipped:', error);
        }
    })();

    let currentRoleFilter = <?= json_encode($selectedRole) ?> || '';

    window.filterByRole = function (role) {
        const url = new URL(window.location.href);
        if (role) {
            url.searchParams.set('role', role);
        } else {
            url.searchParams.delete('role');
        }
        // sayfayı tam yenile
        window.location.href = url.toString();
    };


    function updateActiveTab(role) {
        const tabItems = document.querySelectorAll('.kt-tab-item');
        tabItems.forEach(item => {
            const tabRole = item.getAttribute('data-role') || '';
            if (role === tabRole) {
                item.classList.add('kt-tab-active');
            } else {
                item.classList.remove('kt-tab-active');
            }
        });
    }

    window.updateActiveTab = updateActiveTab;

    function filterTableByRole(roleId) {
        const normalized = String(roleId || '').trim();
        const rows = document.querySelectorAll('#users_table tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const roleList = (row.getAttribute('data-roles') || '')
                .split('|')
                .map(v => v.trim())
                .filter(Boolean);

            const shouldShow = !normalized || roleList.includes(normalized);
            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) visibleCount++;
        });

        updatePaginationInfo(visibleCount);
        toggleEmptyState(visibleCount === 0, normalized);
    }

    function updateUserRowRoles(userId, roleId, roleName) {
        if (!userId || !roleId || !roleName) return;

        const row = document.querySelector(`#users_table tbody tr[data-user-id="${userId}"]`);
        if (!row) return;

        const roleBadges = row.querySelector('[data-role-badges]');
        if (!roleBadges) return;

        const datasetRoles = row.getAttribute('data-roles') || '';
        const currentRoles = datasetRoles.split('|').map(v => v.trim()).filter(Boolean);

        if (!currentRoles.includes(String(roleId))) {
            const emptyPlaceholder = roleBadges.querySelector('[data-role-empty]');
            if (emptyPlaceholder) {
                emptyPlaceholder.remove();
            }

            const badge = document.createElement('span');
            badge.className = 'kt-badge kt-badge-outline kt-badge-primary';
            badge.textContent = roleName;
            roleBadges.appendChild(badge);

            currentRoles.push(String(roleId));
            row.setAttribute('data-roles', currentRoles.join('|'));
        }

        filterTableByRole(currentRoleFilter);
    }


    window.filterTableByRole = filterTableByRole;

    function updatePaginationInfo(count) {
        const paginationInfo = document.querySelector('[data-kt-datatable-info="true"]');
        if (paginationInfo) {
            const safeCount = Number.isFinite(count) && count > 0 ? count : 0;
            if (safeCount === 0) {
                paginationInfo.textContent = 'Showing 0 to 0 of 0 entries';
            } else {
                paginationInfo.textContent = `Showing 1 to ${safeCount} of ${safeCount} entries`;
            }
        }
    }

    window.updatePaginationInfo = updatePaginationInfo;

    function toggleEmptyState(isEmpty, role) {
        const tableCard = document.querySelector('#content .kt-card');
        let emptyState = document.querySelector('.empty-state');

        if (!isEmpty) {
            if (emptyState && emptyState.getAttribute('data-generated') === 'true') {
                emptyState.remove();
            } else if (emptyState) {
                emptyState.style.display = '';
            }
            if (tableCard) {
                tableCard.style.display = '';
            }
            return;
        }

        if (!emptyState || emptyState.getAttribute('data-generated') === 'true') {
            createEmptyState(role);
            emptyState = document.querySelector('.empty-state[data-generated="true"]');
        } else {
            emptyState.style.display = '';
        }

        if (tableCard) {
            tableCard.style.display = 'none';
        }
    }

    window.toggleEmptyState = toggleEmptyState;

    function createEmptyState(role) {
        const container = document.querySelector('#content');
        if (!container) return;

        const roleLabel = role ? escapeHtml(ROLE_NAMES[Number(role)] ?? role) : 'Henüz kullanıcı bulunmuyor';
        const description = role
            ? 'Bu role sahip kullanıcılar henüz eklenmemiş. Yetki atama sayfasından yeni kullanıcılar ekleyebilirsiniz.'
            : 'Sistemde henüz kullanıcı bulunmuyor. İlk kullanıcıları eklemek için yetki atama sayfasını kullanabilirsiniz.';

        const emptyStateHTML = `
            <div class="empty-state flex flex-col items-center justify-center py-20" data-generated="true">
                <div class="flex items-center justify-center size-16 rounded-full bg-muted mb-4">
                    <i class="ki-filled ki-users text-2xl text-muted-foreground"></i>
                </div>
                <h3 class="text-lg font-semibold text-mono mb-2">
                    ${role ? roleLabel + ' rolünde kullanıcı bulunamadı' : roleLabel}
                </h3>
                <p class="text-sm text-secondary-foreground text-center max-w-md">${escapeHtml(description)}</p>
                <div class="flex items-center gap-2.5 mt-5">
                    <button class="kt-btn kt-btn-primary" data-kt-modal-toggle="#assignPermissionModal">
                        <i class="ki-filled ki-rocket text-sm"></i>
                        Yetki Ata
                    </button>
                    <button class="kt-btn kt-btn-outline" onclick="filterByRole('')">
                        <i class="ki-filled ki-refresh text-sm"></i>
                        Tümünü Göster
                    </button>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', emptyStateHTML);
    }

    window.createEmptyState = createEmptyState;

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function updateQueryParam(role) {
        const url = new URL(window.location.href);
        if (role) {
            url.searchParams.set('role', role);
        } else {
            url.searchParams.delete('role');
        }
        window.history.pushState({}, '', url);
    }

    window.updateUserRowRoles = updateUserRowRoles;

    // Sayfa yüklendiğinde aktif sekmeyi ayarla
    document.addEventListener('DOMContentLoaded', function () {
        updateActiveTab(currentRoleFilter);
        if (currentRoleFilter) {
            filterTableByRole(currentRoleFilter);
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?= $this->include('app/modals/assign-permission-modal') ?>
<?= $this->endSection() ?>