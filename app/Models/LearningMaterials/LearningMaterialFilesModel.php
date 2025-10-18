<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialFilesModel extends Model
{
    protected $table      = 'learning_material_files';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    public    $timestamps = false;

    protected $allowedFields = [
        'learning_material_id',
        'file_type',    // örn: 1=intihal raporu, 2=başvuru dosyası, vs.
        'name',         // path veya dosya adı
        'description',
        'created_at',
    ];
}
