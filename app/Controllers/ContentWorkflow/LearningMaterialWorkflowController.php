<?php
declare(strict_types=1);

namespace App\Controllers\ContentWorkflow;

use App\Controllers\BaseController;
use App\DTOs\ContentWorkflow\ActionDTO;
use App\DTOs\ContentWorkflow\AssignReviewersDTO;
use App\Exceptions\DtoValidationException;
use App\Services\ContentWorkflow\LearningMaterialWorkflowService;

final class LearningMaterialWorkflowController extends BaseController
{
    public function __construct(
        private LearningMaterialWorkflowService $service = new LearningMaterialWorkflowService()
    ) {
    }

    // GET /api/contents/{id}/state
    public function state(int $id)
    {
        try {
            $state = $this->service->getCurrentState($id);
            return $this->response->setJSON(['success' => true, 'data' => ['state' => $state]]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // GET /api/contents/{id}/actions
    public function actions(int $id)
    {
        try {
            [$roleIds, $userId] = $this->whoami();
            $res = $this->service->getUIActions($id, $roleIds, $userId);
            return $this->response->setJSON(['success' => true, 'data' => $res]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    // POST /api/contents/{id}/action   (body: { action_code, reviewer_ids? })
    public function submitAction(int $id)
    {
        try {
            [$roleIds, $userId] = $this->whoami();
            $payload = $this->request->getJSON(true) ?? $this->request->getPost();
            $dto = ActionDTO::fromArray($payload);

            $res = $this->service->submitAction($id, $dto, $roleIds, $userId);
            return $this->response->setJSON(['success' => true, 'data' => $res]);
        } catch (DtoValidationException $e) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['success' => false, 'errors' => $e->getErrors() ?: $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // POST /api/contents/{id}/assign-reviewers   (Admin, korhakemlik aşaması)
    // body: { reviewer_ids: [ .. ] }
    public function assignReviewers(int $id)
    {
        try {
            [$roleIds, $userId] = $this->whoami();
            if (!in_array(2, $roleIds, true)) {
                return $this->response
                    ->setStatusCode(403)
                    ->setJSON(['success' => false, 'error' => 'Yetkisiz erişim.']);
            }

            $payload = $this->request->getJSON(true) ?? $this->request->getPost();
            $dto = AssignReviewersDTO::fromArray($payload);

            $meta = $this->service->assignReviewers($id, $dto, $userId, $roleIds);
            return $this->response->setJSON(['success' => true, 'data' => ['meta' => $meta]]);
        } catch (DtoValidationException $e) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['success' => false, 'errors' => $e->getErrors() ?: $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // POST /api/contents/{id}/revision/submit   (revizyonok → on_inceleme)
    // UI tarafında içerik sahibi kullanıcıya gösterilen "Revizyonu Gönder" butonu burayı çağırır.
    public function revisionSubmit(int $id)
    {
        try {
            // Sahiplik kontrolü projendeki modele göre yapılmalı.
            $userId = (int) (session('user_id') ?? $this->request->getHeaderLine('X-User-Id') ?: 0);
            if ($userId <= 0) {
                throw new \RuntimeException('Kimlik doğrulanamadı.');
            }

            // TODO: İçerik sahibini doğrula (örnek)
            // $content = (new \App\Models\Contents\ContentsModel())->find($id);
            // if (!$content || (int)$content['owner_id'] !== $userId) {
            //     return $this->response->setStatusCode(403)->setJSON(['success'=>false,'error'=>'Yetkisiz işlem.']);
            // }

            // Revision submitted işlemi burada yapılabilir
            // $this->service->markRevisionSubmitted($id, $userId);

            return $this->response->setJSON(['success' => true, 'next' => 'on_inceleme']);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // ---- helpers ----
    private function whoami(): array
    {
        $session = session();
        $userId = (int) ($session->get('user_id') ?? 0);

        $roleIds = $session->get('role_ids');
        if (!is_array($roleIds) || empty($roleIds)) {
            $singleRole = (int) ($session->get('role_id') ?? 0);
            $roleIds = $singleRole > 0 ? [$singleRole] : [];
        }

        $roleHeaderRaw = trim((string) $this->request->getHeaderLine('X-Role-Id'));
        if ($roleHeaderRaw !== '') {
            $headerRoles = array_map('trim', explode(',', $roleHeaderRaw));
            foreach ($headerRoles as $headerRole) {
                if ($headerRole !== '' && ctype_digit($headerRole)) {
                    $roleIds[] = (int) $headerRole;
                }
            }
        }

        $roleIds = array_values(array_unique(array_map('intval', $roleIds)));
        if (empty($roleIds)) {
            $roleIds = [1];
        }

        $userHeader = (int) ($this->request->getHeaderLine('X-User-Id') ?: 0);
        if ($userHeader > 0) {
            $userId = $userHeader;
        }

        if ($userId <= 0) {
            throw new \RuntimeException('Kullanıcı kimliği bulunamadı.');
        }

        return [$roleIds, $userId];
    }
    public function uiActions(int $id)
    {
        try {
            [$roleIds, $userId] = $this->whoami();
            $res = $this->service->getUIActions($id, $roleIds, $userId);
            return $this->response->setJSON(['success' => true, 'data' => $res]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    public function logClick()
    {
        $payload = $this->request->getJSON(true);
        log_message('info', 'Action button clicked: ' . json_encode($payload));
        return $this->response->setJSON(['success' => true]);
    }

}
