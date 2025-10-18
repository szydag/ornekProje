<?php
declare(strict_types=1);

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\ProfileCompleteDTO;
use App\Exceptions\DtoValidationException;
use App\Models\Users\CountryModel;
use App\Models\Users\TitleModel;
use App\Models\Users\UserModel;
use App\Models\Users\İnstitutionModel;
use App\Services\Users\ProfileCompletionService;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function __construct(
        private ProfileCompletionService $service = new ProfileCompletionService(),
        private CountryModel $countryModel = new CountryModel(),
        private TitleModel $titleModel = new TitleModel(),
        private İnstitutionModel $institutionModel = new İnstitutionModel(),
        private UserModel $userModel = new UserModel(),
    ) {
    }

    public function complete()
    {
        $userId = (int) (session()->get('user_id') ?? 0);

        if ($userId <= 0) {
            if ($this->isJsonRequest()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profil tamamlama için giriş yapmalısınız.',
                ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            return redirect()->to('auth/login')
                ->with('error', 'Profilinizi tamamlamak için giriş yapmalısınız.');
        }

        $viewData = $this->buildViewPayload($userId);

        if ($this->isJsonRequest()) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'success' => true,
                    'data'    => $viewData,
                ]);
        }

        return view('auth/profileCompletion', $viewData);
    }

    public function completePost()
    {
        $userId    = (int) (session()->get('user_id') ?? 0);
        $wantsJson = $this->isJsonRequest();

        try {
            $dto = ProfileCompleteDTO::fromRequest($this->request);

            if ($userId <= 0) {
                throw new DtoValidationException('Oturum bulunamadı.', ['auth' => 'Kullanıcı oturumu yok.']);
            }

            $result = $this->service->complete($userId, $dto);

            if ($result['success'] ?? false) {
                session()->set('profile_completed', true);
            }

            if ($wantsJson) {
                return $this->response
                    ->setStatusCode(
                        $result['success'] ? ResponseInterface::HTTP_OK : ResponseInterface::HTTP_BAD_REQUEST
                    )
                    ->setJSON($result);
            }

            if ($result['success'] ?? false) {
                return redirect()->back()->with('success', $result['message'] ?? 'Profiliniz güncellendi.');
            }

            return redirect()->back()
                ->with('error', $result['message'] ?? 'Profilinizi güncellerken bir hata oluştu.')
                ->withInput();
        } catch (DtoValidationException $e) {
            $payload = [
                'success' => false,
                'message' => $e->getMessage(),
                'errors'  => $e->getErrors(),
            ];

            if ($wantsJson) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                    ->setJSON($payload);
            }

            return redirect()->back()
                ->with('errors', $e->getErrors())
                ->withInput();
        } catch (\Throwable $e) {
            log_message('error', 'Profile complete fatal: {msg}', ['msg' => $e->getMessage()]);

            if ($wantsJson) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Beklenmeyen bir hata oluştu.',
                    ]);
            }

            return redirect()->back()
                ->with('error', 'Beklenmeyen bir hata oluştu.')
                ->withInput();
        }
    }

    private function buildViewPayload(int $userId): array
    {
        $user = $this->userModel->find($userId) ?: [];

        return [
            'user' => [
                'id'          => $userId,
                'phone'       => $user['phone'] ?? null,
                'title'       => isset($user['title_id']) ? (int) $user['title_id'] : null,
                'country'     => $this->resolveCountryCode((int) ($user['country_id'] ?? 0)),
                'institution' => isset($user['institution_id']) ? (int) $user['institution_id'] : null,
            ],
            'titles'       => $this->titleModel->asMap(),
            'countries'    => $this->countryModel->asRichMap(),
            'institutions' => $this->institutionModel->asMap(),
        ];
    }

    private function resolveCountryCode(int $countryId): ?string
    {
        if ($countryId <= 0) {
            return null;
        }

        $row = $this->countryModel
            ->select('code')
            ->where('id', $countryId)
            ->first();

        return $row['code'] ?? null;
    }

    private function isJsonRequest(): bool
    {
        if ($this->request->isAJAX()) {
            return true;
        }

        $accept = strtolower($this->request->getHeaderLine('Accept') ?? '');
        if ($accept !== '' && str_contains($accept, 'application/json')) {
            return true;
        }

        $contentType = strtolower($this->request->getHeaderLine('Content-Type') ?? '');
        return $contentType !== '' && str_contains($contentType, 'application/json');
    }
}
