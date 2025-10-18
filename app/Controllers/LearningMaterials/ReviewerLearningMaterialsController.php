<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\DTOs\LearningMaterials\MyLearningMaterialsQueryDTO;
use App\Services\LearningMaterials\ReviewerLearningMaterialsService;

final class ReviewerLearningMaterialsController extends BaseController
{
    public function __construct(
        private ReviewerLearningMaterialsService $service = new ReviewerLearningMaterialsService()
    ) {}

    private function wantsJson(): bool
    {
        $accept = $this->request->getHeaderLine('Accept');
        return $this->request->isAJAX() || strpos($accept, 'application/json') !== false;
    }

    public function index()
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        if ($userId <= 0) {
            if ($this->wantsJson()) {
                return $this->response->setJSON([
                    'status' => 'fatal',
                    'error'  => 'Kullanıcı oturumu yok (user_id).',
                ])->setStatusCode(401);
            }

            return redirect()->to(base_url('auth/login'));
        }

        $dto  = MyLearningMaterialsQueryDTO::fromRequest($this->request);
        $data = $this->service->listAssigned($userId, $dto);

        if ($this->wantsJson()) {
            return $this->response->setJSON([
                'status' => 'ok',
                'data'   => $data['items'],
                'meta'   => $data['meta'],
            ]);
        }

        return view('app/reviewer-materials', [
            'title'        => 'Hakemlik - Panel',
            'pageTitle'    => 'Hakemlik',
            'pageSubtitle' => 'Görevlendirildiğiniz içerikleri yönetin',
            'contents'     => $data['items'],
            'meta'         => $data['meta'],
        ]);
    }
}
