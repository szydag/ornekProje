<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

final class ProfileCompletionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        $userId = (int) ($session->get('user_id') ?? 0);

        if ($userId <= 0) {
            // Login filter should normally handle this; fall back to allow flow.
            return null;
        }

        $isCompleted = (bool) ($session->get('profile_completed') ?? false);

        if ($isCompleted) {
            return null;
        }

        $wantsJson = $request->isAJAX()
            || str_contains(strtolower($request->getHeaderLine('Accept') ?? ''), 'application/json')
            || str_contains(strtolower($request->getHeaderLine('Content-Type') ?? ''), 'application/json');

        if ($wantsJson) {
            return Services::response()
                ->setStatusCode(403)
                ->setJSON([
                    'success' => false,
                    'message' => 'Profilinizi tamamlamanız gerekiyor.',
                    'redirect_to' => base_url('auth/profileCompletion'),
                ]);
        }

        return redirect()->to(base_url('auth/profileCompletion'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
