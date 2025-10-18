<?php
namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class LearningMaterialApprovalsModel extends Model
{
    protected $table         = 'learning_material_approvals';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes= false;

    // Timestamps KAPALI (tabloda updated_at yok)
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // yok

    // GÖNDERDİĞİN TÜM ALANLAR BURADA OLMALI
    protected $allowedFields = [
        'learning_material_id',
        'rules_ok',
        'all_authors_ok',
        'description',
        'created_at',
    ];
}
