<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialsModel extends Model
{
    protected $table         = 'learning_materials';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'user_id',
        'course_id',
        'content_type_id',
        'first_language',
        'topics',
        'created_at',
        'status',
    ];
}
