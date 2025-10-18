<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialExtraInfoModel extends Model
{
    protected $table      = 'learning_material_extra_info';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    public    $timestamps = false;

    protected $allowedFields = [
        'learning_material_id',
        'lang',
        'ethics_declaration',
        'supporting_institution',
        'thanks_description',
        'project_number',
    ];
}
