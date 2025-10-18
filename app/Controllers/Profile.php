<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Profile extends Controller
{
    public function complete()
    {
        // Kullanıcının giriş yapmış olduğunu kontrol et
        // Bu kısımda session kontrolü yapılabilir
        
        if ($this->request->getMethod() === 'POST') {
            // Form verilerini al
            $data = $this->request->getPost();
            
            // Temel validasyon kuralları
            $validation = \Config\Services::validation();
            
            $validation->setRules([
                'title' => 'required',
                'phone' => 'required|min_length[10]|max_length[15]',
                'expertise_areas' => 'required',
                'country' => 'required'
            ], [
                'title' => [
                    'required' => 'Ünvan seçimi zorunludur.'
                ],
                'phone' => [
                    'required' => 'Telefon numarası zorunludur.',
                    'min_length' => 'Telefon numarası en az 10 karakter olmalıdır.',
                    'max_length' => 'Telefon numarası en fazla 15 karakter olmalıdır.'
                ],
                'expertise_areas' => [
                    'required' => 'Uzmanlık alanı seçimi zorunludur.'
                ],
                'country' => [
                    'required' => 'Ülke seçimi zorunludur.'
                ]
            ]);
            
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
            
            // Profil verilerini kaydet
            // Bu kısımda veritabanı işlemleri yapılacak
            // Örnek: User modeli ile profil bilgilerini güncelle
            
            // Başarılı mesajı ile profil sayfasına yönlendir
            return redirect()->to('/app/my-profile')->with('success', 'Profiliniz başarıyla tamamlandı!');
        }
        
        // Gerçek API endpoint'ine yönlendir
        return redirect()->to(base_url('apps/profile-complete'));
    }
    
    public function checkProfileComplete()
    {
        // Kullanıcının profil bilgilerinin tamamlanıp tamamlanmadığını kontrol et
        // Bu fonksiyon middleware olarak kullanılabilir
        
        // Örnek kontrol:
        // - Ünvan var mı?
        // - Uzmanlık alanları seçilmiş mi?
        // - Ülke seçilmiş mi?
        // - Kurum bilgileri tamamlanmış mı?
        
        $profileComplete = false; // Veritabanından kontrol edilecek
        
        if (!$profileComplete) {
            return redirect()->to('/app/profile-complete')->with('info', 'Lütfen profil bilgilerinizi tamamlayın.');
        }
        
        return true;
    }
}

