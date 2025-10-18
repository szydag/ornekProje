<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialContributorsModel extends Model
{
    protected $table      = 'learning_material_contributors';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    public    $timestamps = false;

    protected $allowedFields = [
        'learning_material_id',
        'user_id',          // author | translator
        'type',
        'order_number',
        'orcid',
        'name',
        'surname',
        'mail',
        'phone',
        'country_id',
        'city',
        'title_id',
        'is_corresponding',
        'affiliation',
        'institution_id',
    ];
}
