<?php declare(strict_types=1);

namespace App\Models\ContentWorkflow;

use CodeIgniter\Model;
class LearningMaterialReviewerModel extends Model
{
    protected $table = 'learning_material_reviewers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['learning_material_id', 'reviewer_id', 'assigned_at', 'decision_code', 'decided_at',];
}