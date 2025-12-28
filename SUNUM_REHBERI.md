# 🎯 EduContent - Sunum Rehberi

Bu rehber, projenizi sunum için hazırlamanıza yardımcı olur.

## 🚀 Hızlı Başlangıç

### 1. Demo Verilerini Yükle

```bash
# Docker container'larını başlat
docker-compose up -d

# Demo verilerini yükle
./setup-demo.sh
```

veya manuel olarak:

```bash
docker-compose exec php php spark migrate
docker-compose exec php php spark db:seed DemoDataSeeder
```

## 👥 Demo Kullanıcılar

| Rol | E-posta | Şifre | Açıklama |
|-----|---------|-------|----------|
| **Admin** | `admin@educontent.com` | `admin123` | Tüm yetkilere sahip |
| **Editör** | `editor@educontent.com` | `editor123` | İçerik editörü |
| **Hakem** | `reviewer@educontent.com` | `reviewer123` | İçerik değerlendirici |
| **Yazar** | `author@educontent.com` | `author123` | İçerik yazarı |
| **Demo** | `demo@educontent.com` | `demo123` | Genel demo kullanıcı |

## 📋 Sunum Senaryosu

### Senaryo 1: Kullanıcı Kaydı ve Girişi

1. **Kayıt Ol**
   - URL: `http://localhost:8081/auth/register`
   - Yeni bir kullanıcı oluştur
   - Otomatik giriş yapılır

2. **Giriş Yap**
   - URL: `http://localhost:8081/auth/login`
   - Demo kullanıcılardan biriyle giriş yap

### Senaryo 2: İçerik Yönetimi (Yazar)

1. **Yazar olarak giriş yap**
   - `author@educontent.com` / `author123`

2. **Yeni İçerik Ekle**
   - URL: `http://localhost:8081/app/add-material`
   - 5 adımlı form doldur
   - İçerik gönder

3. **İçeriklerimi Görüntüle**
   - URL: `http://localhost:8081/apps/my-materials`
   - Gönderdiğin içerikleri görüntüle

### Senaryo 3: İçerik Değerlendirme (Hakem)

1. **Hakem olarak giriş yap**
   - `reviewer@educontent.com` / `reviewer123`

2. **Değerlendirilecek İçerikler**
   - URL: `http://localhost:8081/apps/reviewer-materials`
   - Atanan içerikleri görüntüle
   - Değerlendirme yap

### Senaryo 4: İçerik Editörlüğü

1. **Editör olarak giriş yap**
   - `editor@educontent.com` / `editor123`

2. **Editör Paneli**
   - URL: `http://localhost:8081/apps/editor-materials`
   - Atanan içerikleri yönet

### Senaryo 5: Admin Paneli

1. **Admin olarak giriş yap**
   - `admin@educontent.com` / `admin123`

2. **Tüm İçerikleri Görüntüle**
   - URL: `http://localhost:8081/apps/admin-materials`
   - Tüm içerikleri listele

3. **Kurs Yönetimi**
   - URL: `http://localhost:8081/apps/courses`
   - Kursları görüntüle ve yönet

4. **Kullanıcı Yönetimi**
   - URL: `http://localhost:8081/app/users`
   - Kullanıcıları görüntüle

## 🎨 Öne Çıkan Özellikler

### ✅ Tamamlanmış Özellikler

- ✅ Kullanıcı kaydı ve girişi
- ✅ Rol bazlı yetkilendirme
- ✅ İçerik ekleme (5 adımlı form)
- ✅ İçerik listeleme ve görüntüleme
- ✅ İçerik güncelleme
- ✅ Kurs yönetimi
- ✅ Hakem değerlendirme sistemi
- ✅ Editör atama sistemi
- ✅ İş akışı yönetimi

### 🔄 İş Akışı Durumları

- `taslak` - Yeni oluşturulan içerik
- `on_inceleme` - Değerlendirme aşamasında
- `revizyon` - Revizyon gerekli
- `revizyonok` - Revizyon tamamlandı
- `onay` - Onaylandı
- `red` - Reddedildi
- `yayinda` - Yayında

## 📱 Önemli URL'ler

| Sayfa | URL | Açıklama |
|-------|-----|----------|
| Ana Sayfa | `http://localhost:8081/` | Giriş yapılmışsa dashboard |
| Giriş | `http://localhost:8081/auth/login` | Kullanıcı girişi |
| Kayıt | `http://localhost:8081/auth/register` | Yeni kullanıcı kaydı |
| İçerik Ekle | `http://localhost:8081/app/add-material` | Yeni içerik ekleme |
| İçeriklerim | `http://localhost:8081/apps/my-materials` | Kullanıcının içerikleri |
| Admin Panel | `http://localhost:8081/apps/admin-materials` | Tüm içerikler |
| Kurslar | `http://localhost:8081/apps/courses` | Kurs listesi |
| phpMyAdmin | `http://localhost:8080` | Veritabanı yönetimi |

## 🛠️ Sorun Giderme

### Login çalışmıyor

1. Veritabanı bağlantısını kontrol et:
   ```bash
   docker-compose exec php php spark migrate
   ```

2. Demo kullanıcıların oluşturulduğundan emin ol:
   ```bash
   docker-compose exec php php spark db:seed DemoUserSeeder
   ```

### Veritabanı hatası

1. MySQL container'ının çalıştığını kontrol et:
   ```bash
   docker-compose ps
   ```

2. Migration'ları tekrar çalıştır:
   ```bash
   docker-compose exec php php spark migrate:refresh
   docker-compose exec php php spark db:seed DemoDataSeeder
   ```

## 💡 Sunum İpuçları

1. **Önceden Test Et**: Sunumdan önce tüm senaryoları test edin
2. **Yedek Plan**: Demo kullanıcılar hazır olsun
3. **Hızlı Erişim**: Önemli URL'leri bookmark'layın
4. **Veritabanı Yedek**: Önemli demo verilerini yedekleyin

## 📊 Sunum Sırası Önerisi

1. **Giriş** (2 dk)
   - Proje tanıtımı
   - Teknoloji stack'i

2. **Kullanıcı Yönetimi** (3 dk)
   - Kayıt ol
   - Giriş yap
   - Rol bazlı yetkilendirme

3. **İçerik Yönetimi** (5 dk)
   - İçerik ekleme (5 adımlı form)
   - İçerik listeleme
   - İçerik detayı

4. **İş Akışı** (5 dk)
   - Hakem değerlendirme
   - Editör atama
   - Durum yönetimi

5. **Admin Özellikleri** (3 dk)
   - Kurs yönetimi
   - Kullanıcı yönetimi
   - Sistem yönetimi

6. **Soru-Cevap** (2 dk)

**Toplam: ~20 dakika**

## 🎉 Başarılar!

Sunumunuzda başarılar dileriz! 🚀


