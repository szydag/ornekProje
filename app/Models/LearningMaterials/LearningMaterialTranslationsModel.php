<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialTranslationsModel extends Model
{
    protected $table      = 'learning_material_translations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    public    $timestamps = false;

    protected $allowedFields = [
        'learning_material_id',
        'lang',
        'title',
        'short_title',
        'keywords',
        'self_description',
    ];
}
