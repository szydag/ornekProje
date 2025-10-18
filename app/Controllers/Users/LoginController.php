<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\LoginDTO;
use App\Services\Users\LoginService;

class LoginController extends BaseController
{
    public function __construct(private LoginService $service = new LoginService())
    {
    }

    public function login()
    {
        $wantsJson = $this->request->isAJAX()
            || str_contains(strtolower($this->request->getHeaderLine('Content-Type') ?? ''), 'application/json')
            || str_contains(strtolower($this->request->getHeaderLine('Accept') ?? ''), 'application/json');

        $data = $this->request->getJSON(true) ?: $this->request->getRawInput() ?: $this->request->getPost();

        $dto = LoginDTO::fromArray($data);
        $res = $this->service->login($dto);   // beklenen: ['success'=>bool, 'data'=>['id'=>..., 'email'=>..., 'name'=>...], ...]

        // >>> EKLE: Başarılı girişte session set <<<
        if (!empty($res['success']) && !empty($res['data']['id'])) {
            session()->regenerate(); // önerilir
            session()->set([
                'user_id' => (int) $res['data']['id'],
                'user_email' => $res['data']['email'] ?? null,
                'user_name' => $res['data']['name'] ?? null,
                'role_id' => (int) ($res['data']['role_id'] ?? 0),
                'profile_completed' => (bool) ($res['data']['profile_completed'] ?? false),
                'login' => true,
            ]);
        }

        $profileCompleted = (bool) ($res['data']['profile_completed'] ?? false);
        if ($res['success'] && !$profileCompleted) {
            if ($wantsJson) {
                $res['redirect_to'] = base_url('auth/profileCompletion');
                return $this->response->setStatusCode(200)->setJSON($res);
            }
            return redirect()->to(base_url('auth/profileCompletion'));
        }

        $redirectTo = session('intended_url')
            ?? $this->request->getGet('return_to')
            ?? '/';
        if ($res['success']) {
            if ($wantsJson) {
                $res['redirect_to'] = $redirectTo;
                return $this->response->setStatusCode(200)->setJSON($res);
            }
            return redirect()->to($redirectTo);
        }


        $status = $res['success'] ? 200 : (isset($res['errors']) ? 422 : 401);
        return $this->response->setStatusCode($status)->setJSON($res);
    }

    public function show()
    {
        if (session('login') === true && session('user_id')) {
            return redirect()->to('/app'); // varsayılan sonrası
        }

        $returnTo = session('intended_url') ?? $this->request->getGet('return_to');
        return view('auth/login', ['return_to' => $returnTo, 'email' => old('email', '')]);
    }

}
