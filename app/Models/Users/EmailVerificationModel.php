<?php
namespace App\Models\Users;

use CodeIgniter\Model;

class EmailVerificationModel extends Model
{
    protected $table      = 'email_verifications';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['email','code','date','status'];

    // Son gönderilen bekleyen kaydı çekmek için yardımcı:
    public function getLatestPending(string $email)
    {
        return $this->where('email', $email)
            ->where('status', 'pending')
            ->orderBy('id', 'DESC')
            ->first();
    }
}
