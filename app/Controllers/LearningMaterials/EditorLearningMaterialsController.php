<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\DTOs\LearningMaterials\MyLearningMaterialsQueryDTO;
use App\Services\LearningMaterials\LearningMaterialEditorService;

final class EditorLearningMaterialsController extends BaseController
{
    public function __construct(
        private LearningMaterialEditorService $service = new LearningMaterialEditorService()
    ) {
    }

    public function index()
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        $userEmail = (string) (session()->get('user_email') ?? '');

        if ($userId <= 0 && $userEmail === '') {
            return redirect()->to(base_url('auth/login'));
        }

        $dto = MyLearningMaterialsQueryDTO::fromRequest($this->request);
        $data = $this->service->listAssignedContents($userId, $userEmail, $dto);
        $hasAssignments = $this->service->userHasAssignments($userId, $userEmail);
        session()->set('has_editor_assignments', $hasAssignments);

        if ($this->wantsJson()) {
            return $this->response->setJSON([
                'status' => 'ok',
                'data'   => $data['items'],
                'meta'   => $data['meta'],
            ]);
        }

        return view('app/editor-materials', [
            'title'        => 'Alan Editörlüğü İçerikleri',
            'pageTitle'    => 'Alan Editörlüğü',
            'pageSubtitle' => 'Atandığınız içerikleri yönetin',
            'contents'     => $data['items'],
            'meta'         => $data['meta'],
        ]);
    }

    private function wantsJson(): bool
    {
        $accept = $this->request->getHeaderLine('Accept');
        return $this->request->isAJAX() || stripos($accept, 'application/json') !== false;
    }
}
