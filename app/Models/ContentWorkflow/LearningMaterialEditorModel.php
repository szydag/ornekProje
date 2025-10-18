<?php
declare(strict_types=1);

namespace App\Models\ContentWorkflow;

use CodeIgniter\Model;

class LearningMaterialEditorModel extends Model
{
    protected $table         = 'learning_material_editors';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'learning_material_id', 'editor_email', 'editor_id', 'assigned_by', 'assigned_at',
        'decision_code', 'decided_at',
    ];
}
