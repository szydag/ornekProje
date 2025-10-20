<?php
declare(strict_types=1);

namespace App\Services\ContentWorkflow;

use App\DTOs\ContentWorkflow\ActionDTO;
use App\DTOs\ContentWorkflow\AssignReviewersDTO;
use App\Models\LearningMaterials\LearningMaterialsModel;
use App\Models\ContentWorkflow\LearningMaterialWorkflowModel;
use App\Models\ContentWorkflow\LearningMaterialReviewerModel;
use CodeIgniter\Database\BaseConnection;

final class TransactionHistoryService
{
    private BaseConnection $db;
    private LearningMaterialsModel $materials;
    private LearningMaterialWorkflowModel $workflows;
    private LearningMaterialReviewerModel $reviewers;
    private \Config\Processes $cfg;

    public function __construct(
        ?LearningMaterialsModel $materials = null,
        ?LearningMaterialWorkflowModel $processes = null,
        ?LearningMaterialReviewerModel $reviewers = null,
        ?\Config\Processes $cfg = null
    ) {
        $this->materials = $contents ?? new LearningMaterialsModel();
        $this->workflows = $processes ?? new LearningMaterialWorkflowModel();
        $this->reviewers = $reviewers ?? new LearningMaterialReviewerModel();
        $this->cfg = $cfg ?? new \Config\Processes();
        $this->db = \Config\Database::connect();
    }


    // app/Services/Process/LearningMaterialWorkflowService.php:20
    private const BADGE_BASE = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium';
    private const CARD_BASE = 'border border-border bg-white dark:bg-slate-900/40 shadow-sm';
    private const REVIEWER_VOTE_VISIBLE_ROLES = [1, 2, 5]; // Admin, Yönetici, Editör

    private const STAGE_MAP = [
        'on_inceleme' => [
            'title' => 'Ön İnceleme',
            'icon' => 'ki-filled ki-eye',
            'badge_class' => 'bg-blue-500 text-white',
            'card_class' => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
            'default' => 'Beklemede',
            'actions' => [
                'onay' => [
                    'label' => 'Onaylandı',
                    'badge_class' => 'bg-green-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-green-50 border border-green-300 text-green-700',
                ],
                'revizyon' => [
                    'label' => 'Revizyon İstendi',
                    'badge_class' => 'bg-yellow-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-yellow-50 border border-yellow-300 text-yellow-700',
                ],
                'red' => [
                    'label' => 'Reddedildi',
                    'badge_class' => 'bg-red-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-red-50 border border-red-300 text-red-600',
                ],
            ],
        ],
        /*
         'revizyonok' => [
            'title' => 'Revizyon Yapıldı',
            'icon' => 'ki-filled ki-eye',
            'badge_class' => 'bg-blue-500 text-white',
            'card_class' => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
            'default' => 'Beklemede',
            'actions' => [
                'revizyon' => [
                    'label' => 'Revize Edildi',
                    'badge_class' => 'bg-yellow-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-yellow-50 border border-yellow-300 text-yellow-700',
                ],
            ],
        ],*/
        'korhakemlik' => [
            'title' => 'Hakem Değerlendirmesi',
            'icon' => 'ki-filled ki-gavel',
            'badge_class' => 'bg-amber-500 text-white',
            'card_class' => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
            'default' => 'Hakem Değerlendirmesinde',
            'actions' => [
                'assign_reviewers' => [
                    'label' => 'Hakem Ataması Yapıldı',
                    'badge_class' => 'bg-sky-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-sky-50 border border-sky-300 text-sky-700',
                ],
                'onay' => [
                    'label' => 'Onaylandı',
                    'badge_class' => 'bg-green-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-green-50 border border-green-300 text-green-700',
                ],
                'revizyon' => [
                    'label' => 'Revizyon İstendi',
                    'badge_class' => 'bg-yellow-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-yellow-50 border border-yellow-300 text-yellow-700',
                ],
                'red' => [
                    'label' => 'Reddedildi',
                    'badge_class' => 'bg-red-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-red-50 border border-red-300 text-red-600',
                ],
            ],
        ],
        'editorkontrol' => [
            'title' => 'Editör Değerlendirmesi',
            'icon' => 'ki-filled ki-pencil',
            'badge_class' => 'bg-purple-500 text-white',
            'card_class' => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
            'default' => 'Editör Değerlendirmesinde',
            'actions' => [
                'onizleme' => [
                    'label' => 'Onaylandı',
                    'badge_class' => 'bg-green-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-green-50 border border-green-300 text-green-700',
                ],
                'revizyon' => [
                    'label' => 'Revizyon İstendi',
                    'badge_class' => 'bg-yellow-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-yellow-50 border border-yellow-300 text-yellow-700',
                ],
                'red' => [
                    'label' => 'Reddedildi',
                    'badge_class' => 'bg-red-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-red-50 border border-red-300 text-red-600',
                ],
            ],
        ],
        'yayinla' => [
            'title' => 'Yayınlandı',
            'icon' => 'ki-filled ki-document',
            'badge_class' => 'bg-emerald-500 text-white',
            'card_class' => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
            'default' => 'Beklemede',
            'actions' => [
                'yayinla' => [
                    'label' => 'Yayına Alındı',
                    'badge_class' => 'bg-emerald-600 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-emerald-50 border border-emerald-300 text-emerald-700',
                ],
                'red' => [
                    'label' => 'Reddedildi',
                    'badge_class' => 'bg-red-500 text-white',
                    'card_class' => self::CARD_BASE,
                    'status_badge_class' => self::BADGE_BASE . ' bg-red-50 border border-red-300 text-red-600',
                ],
            ],
        ],
    ];

    public function getTimeline(int $contentId, array $viewerRoleIds = []): array
    {
        $rows = $this->workflows
            ->select([
                'learning_material_workflows.*',
                "CONCAT_WS(' ', a.name, a.surname) AS admin_name",
                "CONCAT_WS(' ', u.name, u.surname) AS user_name",
            ])
            ->join('users a', 'a.id = learning_material_workflows.admin_id', 'left')
            ->join('users u', 'u.id = learning_material_workflows.user_id', 'left')
            ->where('learning_material_id', $contentId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $viewerRoleIds = array_unique(array_map('intval', $viewerRoleIds));
        $canSeeReviewerVotes = !empty(array_intersect($viewerRoleIds, self::REVIEWER_VOTE_VISIBLE_ROLES));

        $timeline = [];

        foreach ($rows as $row) {
            if (
                !$canSeeReviewerVotes
                && $row['processes_code'] === 'korhakemlik'
                && empty($row['admin_id'])
            ) {
                continue; // hakem oylarını gizle
            }

            $stage = self::STAGE_MAP[$row['processes_code']] ?? [
                'title'              => ucfirst(str_replace('_', ' ', (string) $row['processes_code'])),
                'icon'               => 'ki-filled ki-information',
                'badge_class'        => 'bg-gray-500 text-white',
                'card_class'         => self::CARD_BASE,
                'status_badge_class' => self::BADGE_BASE . ' bg-gray-100 border border-gray-300 text-gray-700',
                'default'            => 'Beklemede',
                'actions'            => [],
            ];

            $action = null;
            if (!empty($row['action_code']) && isset($stage['actions'][$row['action_code']])) {
                $action = $stage['actions'][$row['action_code']];
            }

            if ($row['processes_code'] === 'korhakemlik' && !$canSeeReviewerVotes) {
                $stage['title'] = 'Editör Değerlendirmesi Bekleniyor';
                $stage['default'] = 'Editör Değerlendirmesi Bekleniyor';
            }

            $timeline[] = [
                'title'              => $stage['title'],
                'status'             => $action['label'] ?? $stage['default'],
                'status_code'        => $row['action_code'] !== null && $row['action_code'] !== ''
                    ? (string) $row['action_code']
                    : (string) $row['processes_code'],
                'icon'               => $stage['icon'],
                'badge_class'        => $action['badge_class'] ?? $stage['badge_class'],
                'card_class'         => self::CARD_BASE,
                'status_badge_class' => $action['status_badge_class'] ?? $stage['status_badge_class'],
                'actor'              => $canSeeReviewerVotes ? ($row['admin_name'] ?: $row['user_name']) : null,
                'created_at'         => $row['created_at'],
            ];
        }

        $contentMeta = $this->materials
            ->select(['learning_materials.created_at', "CONCAT_WS(' ', u.name, u.surname) AS author_name"])
            ->join('users u', 'u.id = learning_materials.user_id', 'left')
            ->find($contentId);

        $baseCreatedAt = $contentMeta['created_at']
            ?? ($timeline !== [] ? $timeline[count($timeline) - 1]['created_at'] : date('Y-m-d H:i:s'));

        $baseEntry = [
            'title'              => 'Eğitim İçeriği Başvurusu',
            'status'             => 'Eğitim İçeriği Başvurusu Eklendi',
            'status_code'        => 'submitted',
            'icon'               => 'ki-filled ki-document',
            'badge_class'        => 'bg-slate-500 text-white',
            'card_class'         => self::CARD_BASE,
            'status_badge_class' => self::BADGE_BASE . ' bg-slate-100 border border-slate-300 text-slate-700',
            'actor'              => $canSeeReviewerVotes ? ($contentMeta['author_name'] ?? null) : null,
            'created_at'         => $baseCreatedAt,
        ];

        if ($timeline === []) {
            return [$baseEntry];
        }

        $timeline[] = $baseEntry;

        return $timeline;
    }




}
