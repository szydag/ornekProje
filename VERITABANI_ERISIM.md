# 📊 Veritabanı Erişim Rehberi

## 🌐 Yöntem 1: phpMyAdmin (En Kolay)

### Erişim Bilgileri:
- **URL:** http://localhost:8080
- **Kullanıcı Adı:** `root`
- **Şifre:** `root123`
- **Sunucu:** `mysql` (otomatik seçilir)

### Adımlar:
1. Tarayıcınızda http://localhost:8080 adresine gidin
2. Sol taraftan `educontent_db` veritabanını seçin
3. Tüm tabloları görebilirsiniz

## 💻 Yöntem 2: MySQL Komut Satırı

### Container'a Bağlan:
```bash
docker-compose exec mysql mysql -uroot -proot123 educontent_db
```

### Örnek Komutlar:
```sql
-- Tüm tabloları listele
SHOW TABLES;

-- Kullanıcıları görüntüle
SELECT * FROM users;

-- İçerikleri görüntüle
SELECT * FROM learning_materials;

-- Kursları görüntüle
SELECT * FROM courses;

-- Çıkış
EXIT;
```

## 🔧 Yöntem 3: CodeIgniter Spark Komutları

### Migration Durumunu Kontrol Et:
```bash
docker-compose exec php php spark migrate:status
```

### Veritabanı Seed'lerini Çalıştır:
```bash
docker-compose exec php php spark db:seed DemoUserSeeder
```

## 📋 Önemli Tablolar

| Tablo Adı | Açıklama |
|-----------|----------|
| `users` | Kullanıcılar |
| `user_roles` | Kullanıcı rolleri |
| `roles` | Roller (Admin, Yazar, vb.) |
| `learning_materials` | Eğitim içerikleri |
| `learning_material_translations` | İçerik çevirileri |
| `learning_material_contributors` | İçerik katkıda bulunanlar |
| `courses` | Kurslar |
| `course_authorities` | Kurs yetkilileri |
| `content_types` | İçerik türleri |
| `topics` | Konular |

## 🔍 Hızlı Sorgular

### Tüm Kullanıcıları Görüntüle:
```sql
SELECT id, name, surname, mail, created_at FROM users;
```

### Kullanıcı Rollerini Görüntüle:
```sql
SELECT u.id, u.name, u.surname, u.mail, r.role_name 
FROM users u
LEFT JOIN user_roles ur ON u.id = ur.user_id
LEFT JOIN roles r ON ur.role_id = r.id;
```

### İçerikleri Görüntüle:
```sql
SELECT lm.id, lt.title, lm.status, lm.created_at
FROM learning_materials lm
LEFT JOIN learning_material_translations lt ON lm.id = lt.learning_material_id AND lt.lang = 'tr';
```

### Kursları Görüntüle:
```sql
SELECT id, title, description, status, start_date FROM courses;
```

## 🛠️ Sorun Giderme

### phpMyAdmin'e Erişemiyorum:
```bash
# Container'ın çalıştığını kontrol et
docker-compose ps

# Container'ı yeniden başlat
docker-compose restart phpmyadmin
```

### MySQL'e Bağlanamıyorum:
```bash
# MySQL container'ının çalıştığını kontrol et
docker-compose logs mysql

# Container'ı yeniden başlat
docker-compose restart mysql
```

## 📊 Veritabanı Yedekleme

### Tüm Veritabanını Yedekle:
```bash
docker-compose exec mysql mysqldump -uroot -proot123 educontent_db > backup.sql
```

### Yedekten Geri Yükle:
```bash
docker-compose exec -T mysql mysql -uroot -proot123 educontent_db < backup.sql
```

## 🎯 Sunum İçin Önemli Sorgular

### Demo Kullanıcıları Kontrol Et:
```sql
SELECT id, name, surname, mail FROM users WHERE mail LIKE '%@educontent.com';
```

### Kullanıcı Sayısı:
```sql
SELECT COUNT(*) as total_users FROM users;
```

### İçerik Sayısı:
```sql
SELECT COUNT(*) as total_materials FROM learning_materials;
```

### Kurs Sayısı:
```sql
SELECT COUNT(*) as total_courses FROM courses;
```


