# 🎯 Sunum Hızlı Başlangıç Rehberi

## ✅ Yapılan Değişiklikler

### 1. Login/Register İşlemleri
- ✅ `Auth` controller'ı `LoginService` ve `RegisterService` kullanacak şekilde güncellendi
- ✅ Routes düzenlendi: `auth/login` ve `auth/register` hem GET hem POST destekliyor
- ✅ Otomatik giriş ve yönlendirme çalışıyor

### 2. Demo Kullanıcılar
- ✅ `DemoUserSeeder` oluşturuldu
- ✅ 5 farklı rol için demo kullanıcılar hazır

### 3. Demo Veriler
- ✅ `DemoDataSeeder` oluşturuldu
- ✅ Tüm seeder'ları tek komutla çalıştırıyor

## 🚀 Hızlı Kurulum

```bash
# 1. Container'ları başlat
docker-compose up -d

# 2. Migration'ları çalıştır
docker-compose exec php php spark migrate

# 3. Demo verilerini yükle
docker-compose exec php php spark db:seed DemoDataSeeder
```

## 👥 Demo Kullanıcılar

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Admin | `admin@educontent.com` | `admin123` |
| Editör | `editor@educontent.com` | `editor123` |
| Hakem | `reviewer@educontent.com` | `reviewer123` |
| Yazar | `author@educontent.com` | `author123` |
| Demo | `demo@educontent.com` | `demo123` |

## 📱 Önemli URL'ler

- **Ana Sayfa**: http://localhost:8081/
- **Giriş**: http://localhost:8081/auth/login
- **Kayıt**: http://localhost:8081/auth/register
- **İçerik Ekle**: http://localhost:8081/app/add-material
- **İçeriklerim**: http://localhost:8081/apps/my-materials
- **Admin Panel**: http://localhost:8081/apps/admin-materials

## 🎯 Sunum Senaryosu

1. **Kayıt Ol** → Yeni kullanıcı oluştur
2. **Giriş Yap** → Demo kullanıcılardan biriyle giriş
3. **İçerik Ekle** → 5 adımlı form doldur
4. **İçerikleri Görüntüle** → Farklı rollerle test et
5. **Admin Paneli** → Tüm özellikleri göster

## ⚠️ Not

Eğer seeder çalışmazsa, manuel olarak kullanıcı oluşturabilirsiniz:

```sql
INSERT INTO users (name, surname, mail, password, phone, country_id, title_id, created_at) 
VALUES 
('Admin', 'User', 'admin@educontent.com', '$2y$10$...', '05551234567', 1, 1, NOW());
```

Şifre hash'i için: `password_hash('admin123', PASSWORD_DEFAULT)`

## 🎉 Başarılar!


