<?php
declare(strict_types=1);

namespace App\Models\Courses;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'title', 'description', 'status',
        'start_date', 'end_date', 'indefinite'
    ];

    // Otomatik zaman damgaları
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at'; // migration'da yoksa eklemelisin (öneririm)

    // Eğer tablonda updated_at yoksa, aşağıdaki iki satırı kapat:
    // protected $useTimestamps    = false;
    // protected $allowedFields içine 'created_at' ekleme; service set'ler.

    protected $validationRules  = [];
}
