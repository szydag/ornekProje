<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\Services\LearningMaterials\LearningMaterialEditorService;

final class LearningMaterialEditorController extends BaseController
{
    public function __construct(
        private LearningMaterialEditorService $service = new LearningMaterialEditorService()
    ) {
    }

    public function assign()
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        if ($userId <= 0) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'Yetkisiz erişim.']);
        }

        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        $learningMaterialId = (int) ($payload['content_id'] ?? 0);
        $email = (string) ($payload['editor_email'] ?? $payload['email'] ?? '');

        try {
            $result = $this->service->assignByEmail($learningMaterialId, $email, $userId);
            $currentEmail = (string) (session()->get('user_email') ?? '');
            if ($currentEmail !== '' && strcasecmp($currentEmail, $email) === 0) {
                $hasAssignments = $this->service->userHasAssignments($userId, $currentEmail);
                session()->set('has_editor_assignments', $hasAssignments);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $result['message'],
                'alreadyAssigned' => $result['alreadyAssigned'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
