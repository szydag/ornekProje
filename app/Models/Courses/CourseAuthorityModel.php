<?php
declare(strict_types=1);

namespace App\Models\Courses;

use CodeIgniter\Model;

class CourseAuthorityModel extends Model
{
    protected $table            = 'course_authorities';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'course_id', 'user_id'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // tabloda yok

    protected $validationRules  = [];
}
