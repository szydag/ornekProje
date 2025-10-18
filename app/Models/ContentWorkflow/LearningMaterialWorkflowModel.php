<?php
declare(strict_types=1);

namespace App\Models\ContentWorkflow;

use CodeIgniter\Model;

class LearningMaterialWorkflowModel extends Model
{
    protected $table         = 'learning_material_workflows';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'learning_material_id', 'user_id', 'admin_id',
        'processes_code', 'action_code', 'created_at',
    ];
}
