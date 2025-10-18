<?php
declare(strict_types=1);

namespace App\Models\Users;

use CodeIgniter\Model;

final class PasswordResetModel extends Model
{
    protected $table         = 'password_resets';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['user_id','token_hash','expires_at','used_at'];

    public function markUsed(int $id): bool
    {
        return $this->update($id, ['used_at' => date('Y-m-d H:i:s')]);
    }

    public function invalidateAllForUser(int $userId): void
    {
        $this->where('user_id', $userId)
             ->where('used_at', null)
             ->set('expires_at', date('Y-m-d H:i:s', time()-60))
             ->update();
    }
}
