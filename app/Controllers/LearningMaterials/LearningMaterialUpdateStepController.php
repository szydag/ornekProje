<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\Services\LearningMaterials\LearningMaterialUpdateService;
use App\Services\LearningMaterials\LearningMaterialWizardService;
use App\Exceptions\DtoValidationException;

final class LearningMaterialUpdateStepController extends BaseController
{
    public function __construct(
        private LearningMaterialUpdateService $updateService = new LearningMaterialUpdateService(),
        private LearningMaterialWizardService $wizardService = new LearningMaterialWizardService()
    ) {}

    private function learningMaterialId(): int
    {
        $id = (int) ($this->request->getGet('content_id') ?? 0);
        if ($id <= 0) {
            throw new \InvalidArgumentException('content_id parametresi zorunlu.');
        }
        return $id;
    }

    private function respondOk(array $payload = []): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->response->setJSON(['status' => 'ok'] + $payload);
    }

    private function respondSuccess(int $learningMaterialId): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->response->setJSON([
            'status' => 'success',
            'content_id' => $learningMaterialId,
        ]);
    }

    /* ---------- STEP 1 ---------- */
    public function step1()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $bundle = $this->updateService->getEditData($learningMaterialId);
log_message('debug', sprintf('[ContentUpdate::step%d] content=%d payload=%s', 1, $learningMaterialId, json_encode($bundle, JSON_UNESCAPED_UNICODE)));

            return $this->respondOk([
                'publicationTypes' => $this->wizardService->getPublicationTypes(),
                'topics'           => $this->wizardService->getTopics(),
                'data' => [
                    'content'      => $bundle['content'],
                    'translations' => $bundle['translations'],
                    'extra'        => $bundle['extra'],
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep1] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function step1Post()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $updatedId = $this->updateService->update($learningMaterialId, $this->request);
            return $this->respondSuccess($updatedId);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep1Post] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'error'  => 'Güncelleme sırasında hata oluştu.',
            ]);
        }
    }

    /* ---------- STEP 2 ---------- */
    public function step2()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $bundle = $this->updateService->getEditData($learningMaterialId);

            return $this->respondOk([
                'data' => [
                    'authors' => $bundle['authors'],
                    'titles'  => $this->wizardService->getTitles(),
                    'countries'    => $this->wizardService->getCountries(),
                    'institutions' => $this->wizardService->getInstitutions(),
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep2] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function step2Post()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $updatedId = $this->updateService->update($learningMaterialId, $this->request);
            return $this->respondSuccess($updatedId);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep2Post] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'error'  => 'Güncelleme sırasında hata oluştu.',
            ]);
        }
    }

    /* ---------- STEP 3 ---------- */
    public function step3()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $bundle = $this->updateService->getEditData($learningMaterialId);

            return $this->respondOk([
                'data' => [
                    'files'     => $bundle['files'],
                    'required'  => [], // frontend’de varsa zorunlu dosya tanımları için placeholder
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep3] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function step3Post()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $updatedId = $this->updateService->update($learningMaterialId, $this->request);
            return $this->respondSuccess($updatedId);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep3Post] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'error'  => 'Güncelleme sırasında hata oluştu.',
            ]);
        }
    }

    /* ---------- STEP 4 ---------- */
    public function step4()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $bundle = $this->updateService->getEditData($learningMaterialId);

            return $this->respondOk([
                'data' => [
                    'extra'          => $bundle['extra'],
                    'project_number' => $bundle['content']['project_number'] ?? null,
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep4] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function step4Post()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $updatedId = $this->updateService->update($learningMaterialId, $this->request);
            return $this->respondSuccess($updatedId);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep4Post] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'error'  => 'Güncelleme sırasında hata oluştu.',
            ]);
        }
    }

    /* ---------- STEP 5 ---------- */
    public function step5()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $bundle = $this->updateService->getEditData($learningMaterialId);

            return $this->respondOk([
                'data' => [
                    'approvals' => $bundle['approvals'],
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep5] ' . $e->getMessage());
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function step5Post()
    {
        try {
            $learningMaterialId = $this->learningMaterialId();
            $updatedId = $this->updateService->update($learningMaterialId, $this->request);
            return $this->respondSuccess($updatedId);
        } catch (DtoValidationException $e) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $e->getErrors(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ContentUpdateStep5Post] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'error'  => 'Güncelleme sırasında hata oluştu.',
            ]);
        }
    }
}
