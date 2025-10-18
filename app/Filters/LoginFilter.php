<?php

namespace App\Filters;

use App\Models\Users\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        
        // Kullanıcının giriş yapıp yapmadığını kontrol et
        if ($session->get('login') !== true && empty($session->get('user_id'))) {
            return redirect()->to('user/auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
