<?php
declare(strict_types=1);

namespace App\Models\LearningMaterials;

use CodeIgniter\Model;

class ContentTypeModel extends Model
{
    protected $table      = 'content_types';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['name'];

    /** id => name şeklinde dropdown için */
    public function listForSelect(): array
    {
        return $this->orderBy('id')->findAll() 
            ? array_column($this->findAll(), 'name', 'id')
            : [];
    }
}
