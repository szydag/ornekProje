<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\Services\LearningMaterials\LearningMaterialUpdateService;
use App\Services\LearningMaterials\LearningMaterialWizardService; // upload için yeniden kullanacağız
use App\Exceptions\DtoValidationException;
use App\Services\ContentWorkflow\ContentWorkflowService;
use App\Helpers\EncryptHelper;

final class LearningMaterialUpdateController extends BaseController
{
    public function __construct(
        private LearningMaterialUpdateService $service = new LearningMaterialUpdateService(),
        private LearningMaterialWizardService $wizard = new LearningMaterialWizardService() // step3 upload’ı reuse
    ) {
    }

    // app/Controllers/Contents/ContentUpdateController.php

    public function edit(int $id)
    {
        log_message('debug', '[ContentUpdate::edit] id=' . $id);
        try {
            $mode = (string) ($this->request->getGet('mode') ?? '');
            $userId = (int) (session('user_id') ?? 0);
            $roleId = (int) (session('role_id') ?? 0);

            if ($mode === 'revision') {
                $wf = new \App\Services\ContentWorkflow\LearningMaterialWorkflowService();
                $state = $wf->getCurrentState($id);

                $row = (new \App\Models\LearningMaterials\LearningMaterialsModel())
                    ->select('user_id')
                    ->find($id);

                $isOwner = $row && (int) $row['user_id'] === $userId;
                $isPrivileged = in_array($roleId, [1, 2], true);

                if (!($isOwner || $isPrivileged)) {
                    return $this->response
                        ->setStatusCode(403)
                        ->setBody('Bu içerikte revizyon düzenleme yetkiniz yok.');
                }

                if ($state !== 'revizyonok' && !$isPrivileged) {
                    return $this->response
                        ->setStatusCode(409)
                        ->setBody('İçerik şu anda revizyon aşamasında değil.');
                }
            }

            $data = $this->service->getEditData($id);
            log_message('debug', '[ContentUpdate::edit] data=' . json_encode($data, JSON_UNESCAPED_UNICODE));

            $common = [
                'publicationTypes' => $this->wizard->getPublicationTypes(),
                'topics' => $this->wizard->getTopics(),
                'countries' => $this->wizard->getCountries(),
                'titles' => $this->wizard->getTitles(),
                'institutions' => $this->wizard->getInstitutions(),
                'institutionTypes' => $this->wizard->getInstitutionTypes(),
            ];

            if ($this->request->isAJAX() || strtolower((string) $this->request->getGet('format')) === 'json') {
                return $this->response->setJSON([
                    'status' => 'ok',
                    'data' => $data,
                ]);
            }

            return view('app/update-material', $common + [
                'learningMaterialId' => $id,
                  'content_id'  => $id,   // <— eklendi
                'initialData' => $data,
                'mode' => $mode,
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdate] ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setBody('Bir hata oluştu: ' . $e->getMessage());
        }
    }



    // POST /apps/contents/{id}/update   (veya PUT/PATCH)
    public function update(int $id)
    {
        try {
            $updatedId = $this->service->update($id, $this->request);
            $encryptedId = EncryptHelper::encrypt((string) $updatedId);
            return $this->response->setJSON([
                'status' => 'success',
                'content_id' => $updatedId,
                'content_id_encrypted' => $encryptedId,
                'next' => '/apps/contents/' . $encryptedId,
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdate] ' . $e->getMessage());
            $payload = ['status' => 'fatal', 'error' => 'Güncelleme sırasında hata oluştu'];
            if (defined('ENVIRONMENT') && ENVIRONMENT !== 'production') {
                $payload['debug'] = $e->getMessage();
            }
            return $this->response->setStatusCode(500)->setJSON($payload);
        }
    }

    // POST /apps/contents/{id}/files/upload  (edit sırasında yeni dosya yükleme)
    public function upload(int $id)
    {
        try {
            // wizard’daki upload endpoint’ini aynen kullan: {files:[...]}
            $payload = $this->wizard->handleStep3Upload($this->request);
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $payload
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateUpload] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
