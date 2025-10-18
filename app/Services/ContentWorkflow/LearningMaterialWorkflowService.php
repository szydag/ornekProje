<?php
declare(strict_types=1);

namespace App\Services\ContentWorkflow;

use App\DTOs\ContentWorkflow\ActionDTO;
use App\DTOs\ContentWorkflow\AssignReviewersDTO;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\ContentWorkflow\LearningMaterialWorkflowModel;
use App\Models\ContentWorkflow\LearningMaterialReviewerModel;
use CodeIgniter\Database\BaseConnection;

final class LearningMaterialWorkflowService
{
    private BaseConnection $db;
    private LearningMaterialsModel $materials;
    private LearningMaterialWorkflowModel $workflows;
    private LearningMaterialReviewerModel $reviewers;
    private \Config\Processes $cfg;

    public function __construct(
        ?LearningMaterialsModel $materials = null,
        ?LearningMaterialWorkflowModel $workflows = null,
        ?LearningMaterialReviewerModel $reviewers = null,
        ?\Config\Processes $cfg = null
    ) {
        $this->materials = $materials ?? new LearningMaterialsModel();
        $this->workflows = $workflows ?? new LearningMaterialWorkflowModel();
        $this->reviewers = $reviewers ?? new LearningMaterialReviewerModel();
        $this->cfg = $cfg ?? new \Config\Processes();
        $this->db = \Config\Database::connect();
    }

    public function getCurrentState(int $contentId): string
    {
        $row = $this->materials->select('status')->find($contentId);
        if (!$row) {
            throw new \RuntimeException('Eğitim içeriği bulunamadı.');
        }
        return (string) $row['status'];
    }

    /**
     * @param array<int,int>|int $roles
     * @return array<int,int>
     */
    private function normalizeRoles(array|int $roles): array
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        $roles = array_values(array_unique(array_map('intval', $roles)));
        if (empty($roles)) {
            $roles = [1];
        }
        return $roles;
    }

    private function reviewerHasPendingTask(int $contentId, int $userId): bool
    {
        return (bool) $this->reviewers
            ->select('id')
            ->where('learning_material_id', $contentId)
            ->where('reviewer_id', $userId)
            ->where('decision_code', null)
            ->first();
    }

    private function resolveActingRole(int $contentId, string $state, array $roleIds, int $userId, ?array $proc = null): ?int
    {
        $proc ??= $this->cfg->getProcesses()[$state] ?? null;
        if (!$proc) {
            return null;
        }

        if ($state === 'revizyonok' && $this->isOwner($contentId, $userId)) {
            return 0;
        }

        foreach ($roleIds as $roleId) {
            if (!in_array($roleId, $proc['action_role'] ?? [], true)) {
                continue;
            }
            if ($this->isOwnerActionRestricted($contentId, $roleId, $userId)) {
                continue;
            }
            if ($state === 'korhakemlik' && $roleId === 4 && !$this->reviewerHasPendingTask($contentId, $userId)) {
                continue;
            }

            return $roleId;
        }

        if ($state === 'korhakemlik' && $this->reviewerHasPendingTask($contentId, $userId)) {
            return 4;
        }

        return null;
    }

    /**
     * @param array<int,int>|int $roleIds
     */
    public function getAvailableActions(int $contentId, array|int $roleIds, int $userId): array
    {
        $roles = $this->normalizeRoles($roleIds);
        $state = $this->getCurrentState($contentId);
        $proc = $this->cfg->getProcesses()[$state] ?? null;
        if (!$proc) {
            return [];
        }

        $actingRole = $this->resolveActingRole($contentId, $state, $roles, $userId, $proc);
        if ($actingRole === null) {
            return [];
        }

        return array_map(static fn($a) => $a['action_code'], $proc['action'] ?? []);
    }

    /**
     * @param array<int,int>|int $roleIds
     */
    public function assignReviewers(int $contentId, AssignReviewersDTO $dto, int $adminId, array|int $roleIds): array
    {
        $roles = $this->normalizeRoles($roleIds);
        if (!in_array(2, $roles, true)) {
            throw new \RuntimeException('Yetkisiz işlem.');
        }
        if ($this->isOwnerActionRestricted($contentId, 2, $adminId)) {
            throw new \RuntimeException('Kendi eğitim içeriğiniz için işlem yapamazsınız.');
        }

        // Hakem ataması yalnızca korhakemlik aşamasında
        $state = $this->getCurrentState($contentId);
        if ($state !== 'korhakemlik') {
            throw new \RuntimeException('Hakem ataması yalnızca korhakemlik aşamasında yapılabilir.');
        }

        $now = date('Y-m-d H:i:s');
        $this->db->transStart();

        foreach ($dto->reviewer_ids as $rid) {
            $existing = $this->reviewers
                ->where('learning_material_id', $contentId)
                ->where('reviewer_id', $rid)
                ->orderBy('id', 'DESC')
                ->first();

            if ($existing) {
                if ($existing['decision_code'] === null) {
                    // Zaten bekleyen bir görevi var
                    continue;
                }

                $this->reviewers->update((int) $existing['id'], [
                    'assigned_at' => $now,
                    'decision_code' => null,
                    'decided_at' => null,
                ]);
                continue;
            }

            $this->reviewers->insert([
                'learning_material_id' => $contentId,
                'reviewer_id' => $rid,
                'assigned_at' => $now,
                'decision_code' => null,
                'decided_at' => null,
            ]);
        }

        $this->log($contentId, 'korhakemlik', 'assign_reviewers', $adminId, true);
        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            throw new \RuntimeException('Hakem ataması sırasında hata oluştu.');
        }

        return $this->reviewerStats($contentId);
    }
    /**
     * @param array<int,int>|int $roleIds
     */
    public function submitAction(int $contentId, ActionDTO $dto, array|int $roleIds, int $userId): array
    {
        $roles = $this->normalizeRoles($roleIds);
        $state = $this->getCurrentState($contentId);
        $procs = $this->cfg->getProcesses();
        $proc = $procs[$state] ?? null;

        if (!$proc) {
            throw new \RuntimeException('Geçersiz süreç.');
        }

        $actingRole = $this->resolveActingRole($contentId, $state, $roles, $userId, $proc);
        if ($actingRole === null) {
            throw new \RuntimeException('Bu aşamada işlem yetkiniz yok.');
        }

        // action lookup...
        $actionDef = null;
        foreach (($proc['action'] ?? []) as $a) {
            if ($a['action_code'] === $dto->action_code) {
                $actionDef = $a;
                break;
            }
        }
        if (!$actionDef) {
            throw new \RuntimeException('Bu aşama için geçersiz işlem.');
        }

        $next = (string) ($actionDef['next'] ?? '');
        $now = date('Y-m-d H:i:s');

        $this->db->transStart();

        // 1) her zaman logla
        $this->log($contentId, $state, $dto->action_code, $userId, $actingRole === 2);

        // 2) state-specific
        switch ($state) {
            case 'on_inceleme':
                if ($dto->action_code === 'revizyon') {
                    $this->setStatus($contentId, 'revizyonok');

                } elseif ($dto->action_code === 'red') {
                    $this->setStatus($contentId, 'rejected');
                    $next = 'end';

                } elseif ($dto->action_code === 'onay') {
                    $this->setStatus($contentId, 'korhakemlik');
                    $this->clearReviewers($contentId);

                    if (!empty($dto->reviewer_ids) && is_array($dto->reviewer_ids)) {
                        foreach ($dto->reviewer_ids as $rid) {
                            $this->reviewers->insert([
                                'learning_material_id' => $contentId,
                                'reviewer_id' => (int) $rid,
                                'assigned_at' => $now,
                                'decision_code' => null,
                                'decided_at' => null,
                            ]);
                        }
                    }
                }
                break;

            case 'revizyonok':
                if ($dto->action_code === 'revizyonok') {
                    $this->setStatus($contentId, 'on_inceleme');
                }
                break;

            case 'korhakemlik':
                // (aynı) hakem bir kez oy kullanır, tüm oylar bitince editorkontrol'e geç
                $pending = $this->reviewers
                    ->where('learning_material_id', $contentId)
                    ->where('reviewer_id', $userId)
                    ->where('decision_code', null)
                    ->first();
                if (!$pending) {
                    throw new \RuntimeException('Bekleyen hakem göreviniz yok veya oy kullandınız.');
                }
                $this->reviewers->update($pending['id'], [
                    'decision_code' => $dto->action_code, // onay|revizyon|red
                    'decided_at' => $now,
                ]);

                $left = $this->reviewers
                    ->where('learning_material_id', $contentId)
                    ->where('decision_code', null)
                    ->countAllResults();

                if ($left === 0) {
                    $this->setStatus($contentId, 'editorkontrol');
                }
                break;

            case 'editorkontrol':
                // Editör ataması yok; kararı admin verir
                if ($dto->action_code === 'revizyon') {
                    $this->setStatus($contentId, 'revizyonok');
                } elseif ($dto->action_code === 'red') {
                    $this->setStatus($contentId, 'rejected');
                    $next = 'end';
                } elseif ($dto->action_code === 'onizleme') {
                    $this->setStatus($contentId, 'yayinla');
                }
                break;

            case 'yayinla':
                if ($dto->action_code === 'yayinla') {
                    $this->setStatus($contentId, 'published');
                    $next = 'end';
                }
                break;
        }

        $this->db->transComplete();
        if (!$this->db->transStatus()) {
            throw new \RuntimeException('İşlem sırasında hata oluştu.');
        }

        $ui = $this->getUIActions($contentId, $roles, $userId);
        $newState = $ui['state'] ?? $this->getCurrentState($contentId);

        return [
            'current' => $state,
            'action' => $dto->action_code,
            'next' => $next,
            'state' => $newState,
            'status' => $newState,
            'actions' => $ui['actions'] ?? [],
            'reviewers' => $this->reviewerStats($contentId),
        ];
    }


    // ------ helpers ------

    private function setStatus(int $contentId, string $status): void
    {
        $this->materials->update($contentId, ['status' => $status]);
    }

    private function log(int $contentId, string $state, string $action, int $whoId, bool $isAdmin): void
    {
        $this->workflows->insert([
            'learning_material_id' => $contentId,
            'processes_code' => $state,
            'action_code' => $action,
            'created_at' => date('Y-m-d H:i:s'),
            $isAdmin ? 'admin_id' : 'user_id' => $whoId,
        ]);
    }



    ////////////////////////////////////////////
    // LearningMaterialWorkflowService.php (ilave/ufak ekler)

    private function isOwnerActionRestricted(int $contentId, int $roleId, int $userId): bool
    {
        if (!$this->isOwner($contentId, $userId)) {
            return false;
        }

        $restrictedRoles = [2];
        return in_array($roleId, $restrictedRoles, true);
    }

    private function isOwner(int $contentId, int $userId): bool
    {
        $row = $this->materials->select('user_id')->find($contentId);
        return $row && (int) $row['user_id'] === $userId;
    }

    private function editUrl(int $contentId, string $mode = 'revision'): string
    {
        // Senin controller’ınla birebir uyumlu
        return base_url("updates/contents/{$contentId}/edit?mode={$mode}");
    }

    private function clearReviewers(int $contentId): void
    {
        // Önceki hakem turunu sıfırla; yeni döngü için yeniden atama yapılacak.
        $this->reviewers
            ->where('learning_material_id', $contentId)
            ->delete();
    }

    /**
     * @return array{total:int,pending:int}
     */
    private function reviewerStats(int $contentId): array
    {
        $row = $this->reviewers
            ->select([
                'COUNT(*) as total',
                'SUM(CASE WHEN decision_code IS NULL THEN 1 ELSE 0 END) as pending',
            ])
            ->where('learning_material_id', $contentId)
            ->get()
            ->getRowArray();

        return [
            'total' => (int) ($row['total'] ?? 0),
            'pending' => (int) ($row['pending'] ?? 0),
        ];
    }

    /**
     * @param array<int,int>|int $roleIds
     * @return array{state:string,actions:array<int,array<string,mixed>>}
     */
    public function getUIActions(int $contentId, array|int $roleIds, int $userId): array
    {
        $roles = $this->normalizeRoles($roleIds);
        $state = $this->getCurrentState($contentId);
        $proc = $this->cfg->getProcesses()[$state] ?? null;
        if (!$proc) {
            return ['state' => $state, 'actions' => []];
        }

        $actions = [];

        // 1) revizyonok durumunda "Düzenle" redirect butonu (eğitim içeriği sahibi ise)
        if ($state === 'revizyonok' && $this->isOwner($contentId, $userId)) {
            $actions[] = [
                'type' => 'redirect',
                'code' => 'open_edit',
                'label' => 'Revizyonu Düzenle',
                'url' => $this->editUrl($contentId, 'revision'),
            ];
        }

        $actingRole = $this->resolveActingRole($contentId, $state, $roles, $userId, $proc);
        if ($actingRole !== null && $actingRole !== 0) {
            foreach (($proc['action'] ?? []) as $a) {
                $label = $a['label'] ?? strtoupper($a['action_code']);
                $actions[] = ['type' => 'process', 'code' => $a['action_code'], 'label' => $label];
            }
        }

        return ['state' => $state, 'actions' => $actions];
    }

}
