# 🎤 Sunum Konuşma Metni - EduContent Platform

## Giriş (1-2 dakika)

Merhaba, bugün sizlere staj dönemimde geliştirdiğim **EduContent - Eğitim İçerik Yönetim Sistemi** projesini tanıtacağım.

Bu proje, eğitim kurumları için içerik yönetimi, kurs yönetimi ve içerik gönderim süreçlerini dijitalleştiren bir web platformudur.

---

## Teknik Altyapı (2-3 dakika)

Projeyi **CodeIgniter 4** framework'ü ile geliştirdim. CodeIgniter, PHP tabanlı, MVC mimarisini destekleyen ve hızlı geliştirme imkanı sunan bir framework.

**Backend tarafında:**
- PHP 8.1+ kullandım
- MySQL veritabanı ile çalışıyor
- MVC (Model-View-Controller) mimarisi ile organize edildi
- DTO (Data Transfer Object) pattern'i ile veri transferi yapılıyor
- Service layer pattern'i ile iş mantığı ayrıldı

**Frontend tarafında:**
- Modern, responsive bir arayüz tasarladım
- JavaScript ile dinamik form işlemleri
- AJAX ile asenkron veri transferi

**Deployment:**
- Projeyi **Docker** ile containerize ettim
- Nginx web server, PHP-FPM ve MySQL ayrı container'larda çalışıyor
- phpMyAdmin ile veritabanı yönetimi sağlandı
- Tüm sistem tek bir `docker-compose` komutu ile çalışıyor

---

## Proje Özellikleri (3-4 dakika)

### 1. Kullanıcı Yönetimi
- Kullanıcı kayıt ve giriş sistemi
- Rol bazlı yetkilendirme (Admin, Yönetici, Editör, Hakem, Yazar)
- Profil tamamlama sistemi
- Session yönetimi

### 2. İçerik Yönetimi
- 5 adımlı içerik gönderim süreci (Stepper yapısı)
- Çok dilli içerik desteği (Türkçe/İngilizce)
- Dosya yükleme ve yönetimi
- İçerik güncelleme ve revizyon sistemi

### 3. Kurs Yönetimi
- Kurs oluşturma ve yönetimi
- Kurs yetkilileri atama sistemi
- Kurs bazlı içerik organizasyonu

### 4. İş Akışı Yönetimi (Workflow)
- İçerik durum takibi (Taslak, İncelemede, Yayında, vb.)
- Hakem atama ve değerlendirme sistemi
- Editör atama sistemi
- Revizyon süreçleri
- İşlem geçmişi ve timeline görüntüleme

### 5. Raporlama
- Kullanıcı bazlı içerik listeleme
- Admin paneli ile tüm içerikleri görüntüleme
- İstatistiksel veriler

---

## Teknik Detaylar (2-3 dakika)

### Veritabanı Tasarımı
- Normalize edilmiş veritabanı yapısı
- Foreign key ilişkileri
- Migration dosyaları ile versiyon kontrolü
- Seeder ile demo veri yükleme

### Güvenlik
- CSRF koruması
- SQL injection koruması (Prepared statements)
- XSS koruması (Output escaping)
- Şifre hash'leme (password_hash)
- Session güvenliği

### Kod Organizasyonu
- PSR-4 autoloading standardı
- Namespace kullanımı
- Service layer ile iş mantığı ayrımı
- DTO pattern ile veri transferi
- Repository pattern benzeri yapı

---

## Geliştirme Süreci (1-2 dakika)

Projeyi geliştirirken:
- Önce veritabanı şemasını tasarladım
- Migration dosyaları oluşturdum
- Model, Controller ve View katmanlarını ayrı ayrı geliştirdim
- Service layer ile iş mantığını ayırdım
- Frontend'i responsive ve kullanıcı dostu hale getirdim
- Docker ile deployment ortamını hazırladım

---

## Sonuç ve Öğrenilenler (1 dakika)

Bu projede:
- Modern PHP framework kullanımı öğrendim
- MVC mimarisini uyguladım
- Docker containerization öğrendim
- Veritabanı tasarımı ve optimizasyonu yaptım
- RESTful API tasarımı prensiplerini uyguladım
- Güvenlik best practice'lerini öğrendim

Proje şu anda **8082 portunda** çalışıyor ve tüm özellikler test edilebilir durumda.

---

## Sorular ve Demo

Şimdi projeyi canlı olarak gösterebilirim. Sorularınız varsa memnuniyetle cevaplayacağım.

---

## Kısa Versiyon (5 dakika için)

Merhaba, bugün **EduContent - Eğitim İçerik Yönetim Sistemi** projemi tanıtacağım.

Bu proje, **CodeIgniter 4** framework'ü ile geliştirilmiş, **Docker** ile containerize edilmiş bir web platformudur.

**Temel özellikler:**
- Kullanıcı yönetimi ve rol bazlı yetkilendirme
- 5 adımlı içerik gönderim süreci
- Kurs yönetimi
- İş akışı yönetimi (workflow)
- Hakem ve editör atama sistemi

**Teknik olarak:**
- PHP 8.1+, MySQL, Nginx
- MVC mimarisi
- Service layer pattern
- Docker containerization
- Modern, responsive arayüz

Proje şu anda çalışır durumda ve demo için hazır. Sorularınız varsa memnuniyetle cevaplayacağım.

