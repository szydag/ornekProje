# 📊 Veritabanını Görüntüleme - Hızlı Rehber

## 🌐 Yöntem 1: phpMyAdmin (ÖNERİLEN - En Kolay)

### Adım 1: Tarayıcıyı Aç
Tarayıcınızda şu adrese gidin:
```
http://localhost:8080
```

### Adım 2: Giriş Yap
- **Kullanıcı Adı:** `root`
- **Şifre:** `root123`
- **Sunucu:** `mysql` (otomatik seçilir, değiştirmeyin)

**Giriş butonuna tıklayın.**

### Adım 3: Veritabanını Seç
Sol taraftaki menüden **`educontent_db`** veritabanına tıklayın.

### Adım 4: Tabloları Görüntüle
Artık tüm tabloları görebilirsiniz:
- `users` - Kullanıcılar
- `courses` - Kurslar  
- `learning_materials` - İçerikler
- `user_roles` - Kullanıcı rolleri
- ve diğerleri...

### Adım 5: Tabloya Tıklayın
Herhangi bir tabloya tıklayarak içeriğini görebilirsiniz.

---

## 💻 Yöntem 2: Terminal/Command Line

### MySQL Container'ına Bağlan:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db
```

### Örnek Komutlar:

```sql
-- Tüm tabloları listele
SHOW TABLES;

-- Kullanıcıları görüntüle
SELECT * FROM users;

-- İlk 10 kullanıcıyı görüntüle
SELECT id, name, surname, mail FROM users LIMIT 10;

-- İçerikleri görüntüle
SELECT * FROM learning_materials LIMIT 10;

-- Kursları görüntüle
SELECT * FROM courses;

-- Çıkış yap
EXIT;
```

---

## 🔍 Hızlı Kontrol Komutları

### Kullanıcı Sayısı:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SELECT COUNT(*) as total FROM users;" 2>&1 | grep -v "Warning"
```

### Demo Kullanıcıları Görüntüle:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SELECT id, name, surname, mail FROM users WHERE mail LIKE '%@educontent.com';" 2>&1 | grep -v "Warning"
```

### Tüm Tabloları Listele:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SHOW TABLES;" 2>&1 | grep -v "Warning"
```

---

## 📋 Önemli Tablolar ve İçerikleri

| Tablo | Açıklama | Örnek Sorgu |
|-------|----------|-------------|
| `users` | Kullanıcılar | `SELECT * FROM users;` |
| `user_roles` | Kullanıcı rolleri | `SELECT * FROM user_roles;` |
| `roles` | Roller | `SELECT * FROM roles;` |
| `courses` | Kurslar | `SELECT * FROM courses;` |
| `learning_materials` | İçerikler | `SELECT * FROM learning_materials;` |
| `learning_material_translations` | İçerik çevirileri | `SELECT * FROM learning_material_translations;` |

---

## 🎯 Sunum İçin Hızlı Kontroller

### 1. Demo Kullanıcılar Var mı?
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SELECT id, name, surname, mail FROM users WHERE mail LIKE '%@educontent.com';" 2>&1 | grep -v "Warning"
```

### 2. Kullanıcı Rolleri:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SELECT u.id, u.name, u.mail, r.role_name FROM users u LEFT JOIN user_roles ur ON u.id = ur.user_id LEFT JOIN roles r ON ur.role_id = r.id WHERE u.mail LIKE '%@educontent.com';" 2>&1 | grep -v "Warning"
```

### 3. İstatistikler:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db -e "SELECT 'Kullanıcılar' as tablo, COUNT(*) as sayi FROM users UNION ALL SELECT 'İçerikler', COUNT(*) FROM learning_materials UNION ALL SELECT 'Kurslar', COUNT(*) FROM courses;" 2>&1 | grep -v "Warning"
```

---

## ⚠️ Sorun Giderme

### phpMyAdmin Açılmıyor?
```bash
# Container'ı kontrol et
docker-compose ps phpmyadmin

# Container'ı yeniden başlat
docker-compose restart phpmyadmin
```

### MySQL'e Bağlanamıyorum?
```bash
# Container'ı kontrol et
docker-compose ps mysql

# Logları kontrol et
docker-compose logs mysql

# Container'ı yeniden başlat
docker-compose restart mysql
```

---

## 💡 İpucu

**En kolay yol:** Tarayıcıda http://localhost:8080 adresine gidin ve phpMyAdmin'i kullanın. Grafik arayüz sayesinde tüm verileri kolayca görüntüleyebilirsiniz!


