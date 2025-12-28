<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialEditorModel extends Model
{
    protected $table         = 'learning_material_editors';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'learning_material_id',
        'user_id',
        'email',
        'assigned_at',
        'status',
    ];
}




