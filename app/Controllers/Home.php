<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        
        // Test için: Kullanıcı ID'sini session'a ekle (profil tamamlanmamış kullanıcı)
        if (!$this->session->has('user_id')) {
            $this->session->set('user_id', 1); // Profil tamamlanmamış kullanıcı
        }
    }

    /**
     * Profil tamamlama kontrolü
     */
    protected function checkProfileCompletion()
    {
        // TODO: Gerçek uygulamada session'dan kullanıcı bilgileri alınacak
        $currentUserId = $this->session->get('user_id');
        
        // TODO: Profil tamamlama kontrolü gerçek API'den yapılacak
        return false;
    }

    public function index(): string
    {
        // Ana sayfa direkt home sayfasına yönlendir
        return $this->homePage();
    }

    public function homePage(): string
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        
        return view('app/home');
    }

    public function iceriklerim(): string
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        $data = [
            'title' => 'İçeriklerim - My App',
            'pageTitle' => 'İçeriklerim',
            'pageSubtitle' => 'Yayımladığınız ve taslak içeriklerinizi yönetin',
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'contents' => [],
            'categories' => [],
            'statuses' => []
        ];
        return view('app/my-materials', $data);
    }

    public function reviewer(): string
    {
        $showProfileCompletionWarning = !$this->checkProfileCompletion();

        $data = [
            'title' => 'Hakemlik',
            'pageTitle' => 'Hakemlik',
            'pageSubtitle' => 'Görevlendirildiğiniz içerikleri görüntüleyin',
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'contents' => [],
            'categories' => [],
            'statuses' => []
        ];

        return view('app/reviewer-materials', $data);
    }

    public function adminIcerikler(): string
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        $data = [
            'title' => 'İçerikler - Admin Panel',
            'pageTitle' => 'İçerikler',
            'pageSubtitle' => 'Tüm içerikleri görüntüleyin ve yönetin',
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'contents' => [],
            'statuses' => []
        ];
        return view('app/admin-materials', $data);
    }

    public function addArticle()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content'));
    }

    public function processAddArticle()
    {
        // Legacy method - redirect to step-1
        return redirect()->to('/app/add-content');
    }

    // Step-based content creation methods
    public function addArticleStep1()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-1'));
    }

    public function processAddArticleStep1()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-1/process'));
    }

    public function addArticleStep2()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-2'));
    }

    public function processAddArticleStep2()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-2/process'));
    }

    public function addArticleStep3()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-3'));
    }

    public function processAddArticleStep3()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-3/process'));
    }

    public function addArticleStep4()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-4'));
    }

    public function processAddArticleStep4()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-4/process'));
    }

    public function addArticleStep5()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-5'));
    }

    public function processAddArticleStep5()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/add-content/step-5/process'));
    }

    public function roles()
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('app/users'));
    }

   /* public function users()
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        // URL'den role parametresini al
        $role = $this->request->getGet('role');
        
        // Mock data - gerçek uygulamada database'den gelecek
        $allUsers = [
            ['id' => 1, 'name' => 'Ahmet Yılmaz', 'email' => 'ahmet@example.com', 'role' => 'user', 'avatar' => 'https://picsum.photos/40/40?random=1'],
            ['id' => 2, 'name' => 'Ayşe Demir', 'email' => 'ayse@example.com', 'role' => 'admin', 'avatar' => 'https://picsum.photos/40/40?random=2'],
            ['id' => 3, 'name' => 'Mehmet Kaya', 'email' => 'mehmet@example.com', 'role' => 'secretary', 'avatar' => 'https://picsum.photos/40/40?random=3'],
            ['id' => 4, 'name' => 'Fatma Öz', 'email' => 'fatma@example.com', 'role' => 'referee', 'avatar' => 'https://picsum.photos/40/40?random=4'],
            ['id' => 5, 'name' => 'Ali Çelik', 'email' => 'ali@example.com', 'role' => 'editor', 'avatar' => 'https://picsum.photos/40/40?random=5'],
            ['id' => 6, 'name' => 'Zeynep Arslan', 'email' => 'zeynep@example.com', 'role' => 'user', 'avatar' => 'https://picsum.photos/40/40?random=6'],
            ['id' => 7, 'name' => 'Mustafa Şahin', 'email' => 'mustafa@example.com', 'role' => 'referee', 'avatar' => 'https://picsum.photos/40/40?random=7'],
            ['id' => 8, 'name' => 'Elif Yıldız', 'email' => 'elif@example.com', 'role' => 'secretary', 'avatar' => 'https://picsum.photos/40/40?random=8']
        ];

        // Role'e göre filtrele
        $users = $role ? array_filter($allUsers, function($user) use ($role) {
            return $user['role'] === $role;
        }) : $allUsers;

        $data = [
            'users' => $users,
            'selectedRole' => $role,
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'roleNames' => [
                'user' => 'Kullanıcı',
                'admin' => 'Admin',
                'secretary' => 'Sekreterya',
                'referee' => 'Hakem',
                'editor' => 'Editör'
            ]
        ];

        return view('app/users', $data);
    }
*/
    public function userDetail($userId)
    {
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url("apps/users/{$userId}"));
    }

    public function contentDetail($contentId): string
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        // TODO: Gerçek API'den içerik verilerini çek
        $content = null;
        $currentUserId = null;
        $isAuthor = false;
        
        $data = [
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'content' => $content,
            'currentUserId' => $currentUserId,
            'isAuthor' => $isAuthor
        ];

        return view('app/material-detail', $data);
    }

    public function encyclopediaDetail($encyclopediaId): string
    {
        // Profil tamamlama kontrolü
        $showProfileCompletionWarning = !$this->checkProfileCompletion();
        
        // TODO: Gerçek API'den kurs detay verisini al
        $course = null;
        $currentUserId = null;
        $isEditor = false;

        $data = [
            'showProfileCompletionWarning' => $showProfileCompletionWarning,
            'course' => $course,
            'currentUserId' => $currentUserId,
            'isEditor' => $isEditor
        ];

        return view('app/course-detail', $data);
    }

    public function myProfile()
    {
        // Session'dan kullanıcı bilgilerini al
        $userName = session('user_name') ?: 'Kullanıcı';
        $nameParts = explode(' ', $userName, 2);
        
        $userData = [
            'first_name' => $nameParts[0] ?? '',
            'last_name' => $nameParts[1] ?? '',
            'email' => session('user_email') ?: 'email@example.com',
            'institution' => 'Kurum belirtilmemiş',
            'country' => 'Ülke belirtilmemiş'
        ];

        $data = [
            'title' => 'Profilim',
            'user' => $userData
        ];

        return view('app/my-profile', $data);
    }

    public function profileComplete(): string
    {
        // TODO: Gerçek API'den kullanıcı verilerini çek
        $user = null;

        $data = [
            'title' => 'Profil Tamamlama',
            'user' => $user,
            'titles' => [],
            'institutions' => [],
            'institutionLanguages' => [],
            'institutionTypes' =>[],
            'countries' =>[],
        ];

        return view('auth/profileCompletion', $data);
    }

    public function processProfileComplete()
    {
        if ($this->request->getMethod() === 'POST') {
            // Development aşamasında validasyon yok, direkt home'a yönlendir
            return redirect()->to('/app/home')->with('success', 'Profil başarıyla tamamlandı!');
        }
        
        return redirect()->to('/app/profile-complete');
    }
}
