<?php

use CodeIgniter\Router\RouteCollection;
//session()->destroy();
/**
 * @var RouteCollection $routes
 */
// Test sayfası (filter olmadan)
$routes->get('/test', function () {
    return view('test');
});

//EĞİTİM MATERYALİ EKLEME - STEPPER YAPISI (filter olmadan)
$routes->get('/app/add-material', 'LearningMaterials\LearningMaterialWizardController::addContent');

// Tüm içerikleri göster (filter olmadan)
$routes->get('/apps/admin-materials', 'LearningMaterials\AllLearningMaterialsController::index');

// Kurs listesi (filter olmadan)
$routes->get('/apps/courses', 'Courses\CourseListController::index');

// Kullanıcı listesi (filter olmadan)
$routes->get('/app/users', 'Users\UsersController::index');

// Ana sayfa
$routes->group('', ['filter' => ['loginFilter', 'roleFilter', 'profileGuard']], function ($routes) {
    $routes->get('/', 'Users\UsersController::homeUser');
    $routes->get('app/home', 'Users\UsersController::homeUser');


    // app/Config/Routes.php
    $routes->get('api/users/options', 'Users\UsersController::optionsAll');
    // STEP 1
    $routes->get('apps/add-material/step-1', 'LearningMaterials\LearningMaterialWizardController::step1');
    $routes->post('apps/add-material/step-1', 'LearningMaterials\LearningMaterialWizardController::step1Post');

    // STEP 2
    $routes->get('apps/add-material/step-2', 'LearningMaterials\LearningMaterialWizardController::step2');
    $routes->post('apps/add-material/step-2', 'LearningMaterials\LearningMaterialWizardController::step2Post');

    // STEP 3
    $routes->get('apps/add-material/step-3', 'LearningMaterials\LearningMaterialWizardController::step3');
    $routes->post('apps/add-material/step-3', 'LearningMaterials\LearningMaterialWizardController::step3Post');
    $routes->post('apps/add-material/step-3/upload', 'LearningMaterials\LearningMaterialWizardController::step3Upload');

    // STEP 4
    $routes->get('apps/add-material/step-4', 'LearningMaterials\LearningMaterialWizardController::step4');
    $routes->post('apps/add-material/step-4', 'LearningMaterials\LearningMaterialWizardController::step4Post');

    // STEP 5
    $routes->get('apps/add-material/step-5', 'LearningMaterials\LearningMaterialWizardController::step5');
    $routes->post('apps/add-material/step-5', 'LearningMaterials\LearningMaterialWizardController::step5Post');

    // Finalize (DB kayıt işlemi)


    $routes->get('/apps/my-materials', 'LearningMaterials\MyLearningMaterialsController::index');
    $routes->get('/apps/reviewer-materials', 'LearningMaterials\ReviewerLearningMaterialsController::index');
    $routes->get('/apps/editor-materials', 'LearningMaterials\EditorLearningMaterialsController::index');
});
$routes->post('apps/add-material/finalize', 'LearningMaterials\LearningMaterialWizardController::finalize');
$routes->group('user/auth', static function ($routes) {
    $routes->post('register', 'Users\RegisterController::register');
    $routes->get('verify-two-factor', 'Users\VerifyController::form');
    $routes->post('verify-two-factor', 'Users\VerifyController::verify2fa');
    $routes->get('login', 'Users\LoginController::show');
    $routes->post('login', 'Users\LoginController::login');
});
$routes->get('app/courses', 'Courses\CourseListController::index');

// Auth routes (GET ve POST)
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::processLogin');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::processRegister');

$routes->post('api/auth/register', 'Users\RegisterController::register');
$routes->post('auth/verify-two-factor', 'Users\VerifyController::verify2fa');
////// POSTMAN İLE TEST EDİLEN ROUTELAR//////////



$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => ['loginFilter', 'roleFilter', 'profileGuard']], function ($routes) {
    $routes->get('/', 'Users\UsersController::homeAdmin');

    // Kullanıcılar
    $routes->get('app/users', 'Users\UsersController::index');
    $routes->get('app/user-detail/(:any)', 'Users\UserDetailController::show/$1');

    // Eğitim İçerikleri
    $routes->get('apps/materials', 'LearningMaterials\AllLearningMaterialsController::index');
    $routes->get('apps/materials/(:any)', 'LearningMaterials\LearningMaterialDetailController::detail/$1');

    // Kurslar
    $routes->get('apps/courses', 'Courses\CourseListController::index');
    $routes->get('apps/courses/(:any)', 'Courses\CourseDetailController::detail/$1');

    $routes->group('api', ['namespace' => 'App\Controllers\Courses'], static function ($routes) {
        // Yöneticiler (role_id=2 olanlar)
        $routes->get('managers', 'ManagersController::index');

        // Kurslar
        $routes->post('courses', 'CoursesController::create');
        $routes->get('courses', 'CourseListController::index');
        $routes->post('courses/(:num)', 'CoursesController::update/$1');
        $routes->get('courses/(:num)', 'CourseDetailController::detail/$1');
        $routes->post('courses/(:num)/managers', 'CoursesController::assignManagers/$1');
    });

    $routes->post('api/users/assign-role', 'Users\RoleController::assign');
});

// Public routes (no login required)
$routes->get('apps/courses', 'Courses\CourseListController::index');
$routes->get('apps/courses/(:any)', 'Courses\CourseDetailController::detail/$1');
$routes->get('apps/materials', 'LearningMaterials\AllLearningMaterialsController::index');
$routes->get('apps/materials/(:any)', 'LearningMaterials\LearningMaterialDetailController::detail/$1');
$routes->get('app/users', 'Users\UsersController::index');
$routes->get('app/user-detail/(:any)', 'Users\UserDetailController::show/$1');
$routes->get('app/my-profile', 'Users\ProfileUpdateController::edit');
$routes->post('app/profile/update', 'Users\ProfileUpdateController::update');
$routes->post('api/users/assign-role', 'Users\RoleController::assign');

$routes->get('auth/profileCompletion', 'Users\ProfileController::complete');
$routes->post('apps/profile/complete', 'Users\ProfileController::completePost');
///// Güncelleme İşlemleri

$routes->group('updates/materials', static function ($routes) {
    $routes->get('(:num)/edit', 'LearningMaterials\LearningMaterialUpdateController::edit/$1');//Görüntüleme yani mevcut olan veriyi bu routes ile getiriyoruz frontend'e
    $routes->post('(:num)/update', 'LearningMaterials\LearningMaterialUpdateController::update/$1');
    $routes->post('(:num)/files/upload', 'LearningMaterials\LearningMaterialUpdateController::upload/$1');
});

$routes->group('apps/update-material', static function ($routes) {
    $routes->get('step-1', 'LearningMaterials\LearningMaterialUpdateStepController::step1');
    $routes->post('step-1', 'LearningMaterials\LearningMaterialUpdateStepController::step1Post');

    $routes->get('step-2', 'LearningMaterials\LearningMaterialUpdateStepController::step2');
    $routes->post('step-2', 'LearningMaterials\LearningMaterialUpdateStepController::step2Post');

    $routes->get('step-3', 'LearningMaterials\LearningMaterialUpdateStepController::step3');
    $routes->post('step-3', 'LearningMaterials\LearningMaterialUpdateStepController::step3Post');

    $routes->get('step-4', 'LearningMaterials\LearningMaterialUpdateStepController::step4');
    $routes->post('step-4', 'LearningMaterials\LearningMaterialUpdateStepController::step4Post');

    $routes->get('step-5', 'LearningMaterials\LearningMaterialUpdateStepController::step5');
    $routes->post('step-5', 'LearningMaterials\LearningMaterialUpdateStepController::step5Post');
});


//process işlemleri
$routes->group('api/materials', static function ($routes) {
    $routes->get('(:num)/state', 'ContentWorkflow\LearningMaterialWorkflowController::state/$1');
    $routes->get('(:num)/actions', 'ContentWorkflow\LearningMaterialWorkflowController::actions/$1');
    $routes->post('(:num)/action', 'ContentWorkflow\LearningMaterialWorkflowController::submitAction/$1');
    $routes->post('(:num)/assign-reviewers', 'ContentWorkflow\LearningMaterialWorkflowController::assignReviewers/$1');
    //$routes->post('(:num)/assign-editor', 'ContentWorkflow\LearningMaterialWorkflowController::assignEditor/$1');
    $routes->post('(:num)/revision/submit', 'ContentWorkflow\LearningMaterialWorkflowController::revisionSubmit/$1');
    $routes->get('(:num)/ui-actions', 'ContentWorkflow\LearningMaterialWorkflowController::uiActions/$1');
});
$routes->post('api/materials/add-editor', 'LearningMaterials\LearningMaterialEditorController::assign');
$routes->post('api/uploads', 'Process\UploadController::store');
$routes->get('api/refereeUsers', 'Users\UsersController::listByRole');


$routes->group('auth', static function ($routes) {
    $routes->post('send-reset-email', 'Users\PasswordResetController::sendResetEmail');
    $routes->get('reset/(:segment)', 'Users\PasswordResetController::showResetForm/$1');
    $routes->post('reset', 'Users\PasswordResetController::handleResetPost');
});

// Dosya işlemleri
$routes->get('preview/(:num)', 'FileController::preview/$1');
$routes->get('download/(:num)', 'FileController::download/$1');
$routes->post('api/debug/log-click', 'ContentWorkflow\LearningMaterialWorkflowController::logClick');



//////// POSTMAN İLE TES EDİLEN ROUTE SONU//////////

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('send-reset-email', 'Auth::sendResetEmail');
    $routes->get('change-password', 'Auth::changePassword');
    $routes->post('change-password', 'Auth::processChangePassword');
    $routes->get('verify-email', 'Auth::verifyEmail');
    $routes->post('resend-verification', 'Auth::resendVerification');
    $routes->get('resetPassword/checkEmail', 'Auth::checkEmail');
    $routes->get('two-factor', 'Auth::twoFactor');
    $routes->post('verify-two-factor', 'Auth::verifyTwoFactor');
    $routes->get('logout', 'Auth::logout');
});

/*$routes->group('app', function ($routes) {
    $routes->get('home', 'Home::homePage');
    $routes->get('my-materials', 'Home::iceriklerim');
    //$routes->get('materials', 'Home::adminIcerikler');
    $routes->get('courses', 'Courses\CourseListController::index');
    // $routes->get('users', 'Home::users');
    // $routes->get('user-detail/(:num)', 'Home::userDetail/$1');
    //$routes->get('content-detail/(:num)', 'Home::contentDetail/$1');
    //$routes->get('course-detail/(:num)', 'Home::courseDetail/$1');
    $routes->get('profile-complete', 'Home::profileComplete');
    $routes->post('profile-complete', 'Home::processProfileComplete');
    //$routes->get('reviewer', 'Home::reviewer');

});*/



//////////////
/* --- IGNORE ---
    // Step-based content creation
    $routes->get('add-content/step-1', 'Home::addContentStep1');
    $routes->post('add-content/step-1', 'Home::processAddContentStep1');
    $routes->get('add-content/step-2', 'Home::addContentStep2');
    $routes->post('add-content/step-2', 'Home::processAddContentStep2');
    $routes->get('add-content/step-3', 'Home::addContentStep3');
    $routes->post('add-content/step-3', 'Home::processAddContentStep3');
    $routes->get('add-content/step-4', 'Home::addContentStep4');
    $routes->post('add-content/step-4', 'Home::processAddContentStep4');
    $routes->get('add-content/step-5', 'Home::addContentStep5');
    $routes->post('add-content/step-5', 'Home::processAddContentStep5');

    // Legacy routes (redirect to step-1)
    $routes->get('add-content', 'Home::addContentStep1');
    $routes->post('add-content', 'Home::processAddContentStep1');
    */
