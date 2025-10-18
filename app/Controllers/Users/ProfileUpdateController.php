<?php
declare(strict_types=1);

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\DTOs\Users\ProfileCompleteDTO;
use App\Exceptions\DtoValidationException;
use App\Models\Users\CountryModel;
use App\Models\Users\InstitutionTypeModel;
use App\Models\Users\İnstitutionModel;
use App\Models\Users\TitleModel;
use App\Models\Users\UserModel;
use App\Services\Users\ProfileCompletionService;

final class ProfileUpdateController extends BaseController
{
    public function __construct(
        private UserModel $userModel = new UserModel(),
        private TitleModel $titleModel = new TitleModel(),
        private CountryModel $countryModel = new CountryModel(),
        private İnstitutionModel $institutionModel = new İnstitutionModel(),
        private InstitutionTypeModel $institutionTypeModel = new InstitutionTypeModel(),
        private ProfileCompletionService $completionService = new ProfileCompletionService(),
    ) {
    }

    public function edit()
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        if ($userId <= 0) {
            return redirect()->to('auth/login')
                ->with('error', 'Profilinizi görüntülemek için giriş yapmalısınız.');
        }

        $user = $this->userModel->find($userId);
        if (!$user) {
            return redirect()->to('/app/home')
                ->with('error', 'Kullanıcı bilgileri bulunamadı.');
        }

        $viewData = [
            'title' => 'Profilim',
            'user' => [
                'id'             => $userId,
                'first_name'     => $user['name'] ?? '',
                'last_name'      => $user['surname'] ?? '',
                'email'          => $user['mail'] ?? '',
                'phone'          => $user['phone'] ?? '',
                'title'          => isset($user['title_id']) ? (int) $user['title_id'] : null,
                'country'        => $this->resolveCountryCode(
                    isset($user['country_id']) ? (int) $user['country_id'] : null
                ),
                'institution'    => isset($user['institution_id']) ? (int) $user['institution_id'] : null,
                'no_institution' => false,
                'add_institution'=> false,
            ],
            'titles'           => $this->titleModel->asMap(),
            'countries'        => $this->countryModel->asRichMap(),
            'institutions'     => $this->institutionModel->asMap(),
            'institutionTypes' => $this->institutionTypeModel->asMap(),
        ];

        return view('app/my-profile', $viewData);
    }

    public function update()
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        if ($userId <= 0) {
            return redirect()->to('auth/login')
                ->with('error', 'Profilinizi güncellemek için giriş yapmalısınız.');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name'  => 'required|min_length[2]|max_length[100]',
            'email'      => "required|valid_email|is_unique[users.mail,id,{$userId}]",
        ];

        if (!$this->validate($rules)) {
            log_message(
                'warning',
                'Profile update basic validation failed for user {user_id}: {errors}',
                [
                    'user_id' => $userId,
                    'errors'  => json_encode($this->validator->getErrors(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]
            );
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $rawPost = $this->request->getPost();
        log_message(
            'info',
            'Profile update raw POST data for user {user_id}: {payload}',
            [
                'user_id' => $userId,
                'payload' => json_encode($rawPost, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]
        );

        try {
            $dto = ProfileCompleteDTO::fromRequest($this->request);
            log_message(
                'info',
                'Profile update DTO prepared for user {user_id}: {payload}',
                [
                    'user_id' => $userId,
                    'payload' => json_encode($dto->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]
            );
        } catch (DtoValidationException $e) {
            log_message(
                'warning',
                'Profile update DTO validation failed for user {user_id}: {errors}',
                [
                    'user_id' => $userId,
                    'errors'  => json_encode($e->getErrors(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]
            );
            return redirect()->back()
                ->with('errors', $e->getErrors())
                ->withInput();
        } catch (\Throwable $e) {
            log_message('error', 'Profile update DTO failure: {msg}', ['msg' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Profil bilgileriniz işlenirken beklenmeyen bir hata oluştu.')
                ->withInput();
        }

        $result = $this->completionService->complete($userId, $dto);
        log_message(
            'info',
            'Profile completion service result for user {user_id}: {result}',
            [
                'user_id' => $userId,
                'result'  => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]
        );

        if (!($result['success'] ?? false)) {
            $message = $result['message'] ?? 'Profilinizi güncellerken bir hata oluştu.';
            return redirect()->back()
                ->with('error', $message)
                ->withInput();
        }

        $firstName = trim((string) $this->request->getPost('first_name'));
        $lastName  = trim((string) $this->request->getPost('last_name'));
        $email     = trim((string) $this->request->getPost('email'));

        $this->userModel->skipValidation(true);

        $updateOk = $this->userModel->update($userId, [
            'name'    => $firstName,
            'surname' => $lastName,
            'mail'    => $email,
        ]);

        $this->userModel->skipValidation(false);

        if (!$updateOk) {
            $errors = $this->userModel->errors();
            log_message(
                'error',
                'User basic info update failed for user {user_id}: {errors}',
                [
                    'user_id' => $userId,
                    'errors'  => json_encode($errors, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]
            );
            if (!empty($errors)) {
                session()->setFlashdata('errors', $errors);
            }

            return redirect()->back()
                ->with('error', 'Kişisel bilgileriniz güncellenemedi.')
                ->withInput();
        }

        session()->set('user_name', trim($firstName . ' ' . $lastName));
        session()->set('user_email', $email);

        $successMessage = $result['message'] ?? 'Profiliniz başarıyla güncellendi.';

        log_message(
            'info',
            'Profile update completed successfully for user {user_id}',
            ['user_id' => $userId]
        );

        return redirect()->back()->with('success', $successMessage);
    }

    private function resolveCountryCode(?int $countryId): ?string
    {
        if ($countryId === null || $countryId <= 0) {
            return null;
        }

        $row = $this->countryModel
            ->select('code')
            ->where('id', $countryId)
            ->first();

        return $row['code'] ?? null;
    }
}
