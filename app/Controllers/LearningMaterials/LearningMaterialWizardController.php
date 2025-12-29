<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\Services\LearningMaterials\LearningMaterialWizardService;
use App\Exceptions\DtoValidationException;
use App\Helpers\EncryptHelper;

final class LearningMaterialWizardController extends BaseController
{
    private LearningMaterialWizardService $service;

    public function __construct()
    {
        $this->service = new LearningMaterialWizardService();
    }
    // GET /app/add-content - Stepper yapısı
    public function addContent()
    {
        // Backend'den yayın türleri, konuları, ülkeleri, ünvanlar, kurumlar ve kurum tiplerini çek
        $data = [
            'publicationTypes' => $this->service->getPublicationTypes(),
            'topics' => $this->service->getTopics(),
            'countries' => $this->service->getCountries(),
            'titles' => $this->service->getTitles(),
            'institutions' => $this->service->getInstitutions(),
            'institutionTypes' => $this->service->getInstitutionTypes(),
            'contentTypes' => $this->service->getContentTypes(),
            // Edit modal için gerekli değişkenler
            'academicTitles' => $this->service->getTitles(),
            'universities' => $this->service->getInstitutions(),
        ];

        return view('app/add-material', $data);
    }


    // GET /apps/add-content/step-1
    public function step1()
    {
        return $this->response->setJSON([
            'step' => 1,
            'status' => 'ok',
            'publicationTypes' => $this->service->getPublicationTypes(),
            'topics' => $this->service->getTopics(),
            'countries' => $this->service->getCountries(),
            'titles' => $this->service->getTitles(),
            'institutions' => $this->service->getInstitutions(),
            'institutionTypes' => $this->service->getInstitutionTypes(),
            'data' => $this->service->getStep1Defaults(), // eklediğin helper
        ]);
    }


    // POST /apps/add-content/step-1
    public function step1Post()
    {
        try {
            $clean = $this->service->handleStep1($this->request);

            return $this->response->setJSON([
                'step' => 1,
                'status' => 'success',
                'data' => $clean,
                'next' => '/apps/add-content/step-2',
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setJSON([
                'step' => 1,
                'status' => 'error',
                'errors' => $e->getErrors(),
            ])->setStatusCode(422);
        } catch (\Throwable $e) {
            log_message('error', '[Step1] ' . $e->getMessage());

            return $this->response->setJSON([
                'step' => 1,
                'status' => 'fatal',
                'error' => 'Beklenmeyen bir hata oluştu',
            ])->setStatusCode(500);
        }
    }

    // GET /apps/add-content/step-2
    public function step2()
    {
        return $this->response->setJSON([
            'step' => 2,
            'status' => 'ok',
            'data' => $this->service->getStep2Data(), // {authors: [...]}
        ]);
    }

    // POST /apps/add-content/step-2
    public function step2Post()
    {
        try {
            $clean = $this->service->handleStep2($this->request);

            return $this->response->setJSON([
                'step' => 2,
                'status' => 'success',
                'data' => $clean,
                'next' => '/apps/add-content/step-3',
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setJSON([
                'step' => 2,
                'status' => 'error',
                'errors' => $e->getErrors(),
            ])->setStatusCode(422);
        } catch (\Throwable $e) {
            log_message('error', '[Step2] ' . $e->getMessage());
            return $this->response->setJSON([
                'step' => 2,
                'status' => 'fatal',
                'error' => 'Beklenmeyen bir hata oluştu',
            ])->setStatusCode(500);
        }
    }

    // GET /apps/add-content/step-3
    public function step3()
    {
        return $this->response->setJSON([
            'step' => 3,
            'status' => 'ok',
            'data' => $this->service->getStep3Data(), // {files:[...]}
        ]);
    }

    // POST /apps/add-content/step-3  (metadata kaydet)
    public function step3Post()
    {
        try {
            $clean = $this->service->handleStep3($this->request);

            return $this->response->setJSON([
                'step' => 3,
                'status' => 'success',
                'data' => $clean,
                'next' => '/apps/add-content/step-4',
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setJSON([
                'step' => 3,
                'status' => 'error',
                'errors' => $e->getErrors(),
            ])->setStatusCode(422);
        } catch (\Throwable $e) {
            log_message('error', '[Step3] ' . $e->getMessage());
            return $this->response->setJSON([
                'step' => 3,
                'status' => 'fatal',
                'error' => 'Beklenmeyen bir hata oluştu',
            ])->setStatusCode(500);
        }
    }

    // POST /apps/add-content/step-3/upload  (dosya yükle)
    public function step3Upload()
    {
        try {
            $payload = $this->service->handleStep3Upload($this->request);

            return $this->response->setJSON([
                'step' => 3,
                'status' => 'success',
                'data' => $payload, // {files:[{temp_id,name,stored_path,mime,size}]}
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[Step3Upload] ' . $e->getMessage());
            return $this->response->setJSON([
                'step' => 3,
                'status' => 'error',
                'error' => $e->getMessage(),
            ])->setStatusCode(400);
        }
    }

    // GET /apps/add-content/step-4  (view istiyorsan view dönebilir; JSON sürümünü de koruyorum)
    public function step4()
    {
        return $this->response->setJSON([
            'step' => 4,
            'status' => 'ok',
            'data' => $this->service->getStep4Data(),
        ]);
        // Alternatif: return view('app/add-material/step-4', ['data' => $this->service->getStep4Data()]);
    }

    // POST /apps/add-content/step-4
    public function step4Post()
    {
        try {
            $clean = $this->service->handleStep4($this->request);

            return $this->response->setJSON([
                'step' => 4,
                'status' => 'success',
                'data' => $clean,
                'next' => '/apps/add-content/step-5',
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setJSON([
                'step' => 4,
                'status' => 'error',
                'errors' => $e->getErrors(),
            ])->setStatusCode(422);
        } catch (\Throwable $e) {
            log_message('error', '[Step4] ' . $e->getMessage());
            return $this->response->setJSON([
                'step' => 4,
                'status' => 'fatal',
                'error' => 'Beklenmeyen bir hata oluştu',
            ])->setStatusCode(500);
        }
    }

    // GET /apps/add-content/step-5
    public function step5()
    {
        return $this->response->setJSON([
            'step' => 5,
            'status' => 'ok',
            'step1Data' => $this->service->getStep1Defaults(),
            'step2Data' => $this->service->getStep2Defaults(),
            'step3Data' => $this->service->getStep3Defaults(),
            'step4Data' => $this->service->getStep4Defaults(),
            'step5Data' => $this->service->getStep5Defaults(),
        ]);
    }


    // POST /apps/add-content/step-5
    public function step5Post()
    {
        try {
            $clean = $this->service->handleStep5($this->request);

            // İsteğe bağlı: mevcut içerik için Step 5'i anında kaydet
            $learningMaterialId = (int) ($this->request->getPost('content_id') ?? 0);
            if ($learningMaterialId > 0) {
                // Step 5 kaydetme işlemi burada yapılabilir
            }

            return $this->response->setJSON([
                'step' => 5,
                'status' => 'success',
                'data' => $clean,
                'next' => '/apps/add-content/finish',
            ]);
        } catch (DtoValidationException $e) {
            return $this->response->setJSON([
                'step' => 5,
                'status' => 'error',
                'errors' => $e->getErrors(),
            ])->setStatusCode(422);
        } catch (\Throwable $e) {
            log_message('error', '[Step5] ' . $e->getMessage());
            return $this->response->setJSON([
                'step' => 5,
                'status' => 'fatal',
                'error' => 'Beklenmeyen bir hata oluştu',
            ])->setStatusCode(500);
        }
    }


    // POST /apps/add-content/finalize
    public function finalize()
    {
        try {
            $wizardData = $this->request->getJSON(true) ?? [];

            $learningMaterialId = $this->service->finalize($wizardData);

            $encryptedId = EncryptHelper::encrypt((string) $learningMaterialId);

            return $this->response->setJSON([
                'status' => 'success',
                'content_id' => $learningMaterialId,
                'next' => '/apps/materials/' . $encryptedId,
            ]);
        } catch (\Throwable $e) {
            $wizardData = $wizardData ?? ($this->request->getJSON(true) ?? []);

            log_message(
                'error',
                '[Finalize] Hata: ' . $e->getMessage() . ' | Payload: ' . json_encode($wizardData, JSON_UNESCAPED_UNICODE)
            );
            log_message('error', "[Finalize] Trace:\n{$e->getTraceAsString()}");

            $payload = [
                'status' => 'fatal',
                'error' => 'Kayıt sırasında hata oluştu',
            ];

            if (defined('ENVIRONMENT') && ENVIRONMENT !== 'production') {
                $payload['debug'] = $e->getMessage();
                $payload['lastQuery'] = $this->service->getLastQuery();
            }

            return $this->response->setJSON($payload)->setStatusCode(500);
        }
    }

}
