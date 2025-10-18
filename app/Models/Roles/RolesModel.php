<?php
// app/Models/Roles/RolesModel.php
namespace App\Models\Roles;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table         = 'roles';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['role_name', 'slug']; // varsa
}
