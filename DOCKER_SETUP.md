# Docker Kurulum Rehberi

Bu proje Docker kullanarak kolayca çalıştırılabilir.

## Gereksinimler

- Docker Desktop (veya Docker + Docker Compose)
- En az 4GB RAM
- 2GB boş disk alanı

## Hızlı Başlangıç

### 1. Docker Container'ları Başlat

```bash
docker-compose up -d
```

Bu komut şunları başlatır:
- **PHP 8.2-FPM** (Port: 9000)
- **Nginx** (Port: 8081)
- **MySQL 8.0** (Port: 3306)
- **phpMyAdmin** (Port: 8080)

### 2. Composer Bağımlılıklarını Yükle

```bash
docker-compose exec php composer install
```

### 3. Veritabanı Migration'larını Çalıştır

```bash
docker-compose exec php php spark migrate
```

### 4. Veritabanı Seed'lerini Çalıştır (Opsiyonel)

```bash
docker-compose exec php php spark db:seed AllSeeder
```

### 5. Writable Klasör İzinlerini Ayarla

```bash
docker-compose exec php chmod -R 755 writable
docker-compose exec php chown -R www-data:www-data writable
```

## Erişim Bilgileri

### Web Uygulaması
- **URL:** http://localhost:8081
- **Test Sayfası:** http://localhost:8081/test

### phpMyAdmin
- **URL:** http://localhost:8080
- **Kullanıcı Adı:** root
- **Şifre:** root123

### Veritabanı Bağlantı Bilgileri
- **Host:** localhost (dışarıdan) veya mysql (container içinden)
- **Port:** 3306
- **Database:** educontent_db
- **Username:** root veya educontent_user
- **Password:** root123 veya educontent_pass

## Docker Komutları

### Container'ları Başlat
```bash
docker-compose up -d
```

### Container'ları Durdur
```bash
docker-compose down
```

### Container'ları Durdur ve Volume'ları Sil
```bash
docker-compose down -v
```

### Logları Görüntüle
```bash
docker-compose logs -f
```

### Belirli Bir Container'ın Loglarını Görüntüle
```bash
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f mysql
```

### PHP Container'ına Bağlan
```bash
docker-compose exec php bash
```

### Nginx Container'ına Bağlan
```bash
docker-compose exec nginx sh
```

### MySQL Container'ına Bağlan
```bash
docker-compose exec mysql mysql -u root -proot123 educontent_db
```

## CodeIgniter Komutları

### Migration Çalıştır
```bash
docker-compose exec php php spark migrate
```

### Migration Geri Al
```bash
docker-compose exec php php spark migrate:rollback
```

### Cache Temizle
```bash
docker-compose exec php php spark cache:clear
```

### Route Listesi
```bash
docker-compose exec php php spark routes
```

## Sorun Giderme

### Port Çakışması
Eğer portlar kullanılıyorsa, `docker-compose.yml` dosyasındaki port numaralarını değiştirebilirsiniz:

```yaml
nginx:
  ports:
    - "8082:80"  # 8081 yerine 8082

phpmyadmin:
  ports:
    - "8081:80"  # 8080 yerine 8081
```

### Veritabanı Bağlantı Hatası
1. MySQL container'ının çalıştığından emin olun:
   ```bash
   docker-compose ps
   ```

2. MySQL container'ının loglarını kontrol edin:
   ```bash
   docker-compose logs mysql
   ```

3. Database config dosyasını kontrol edin:
   - `app/Config/Database.php`
   - Docker içinde hostname: `mysql` olmalı

### Permission Hataları
Writable klasörü için izinleri düzeltin:
```bash
docker-compose exec php chmod -R 755 writable
docker-compose exec php chown -R www-data:www-data writable
```

### Composer Hataları
Composer cache'i temizleyin:
```bash
docker-compose exec php composer clear-cache
docker-compose exec php composer install --no-cache
```

## Geliştirme İpuçları

### Hot Reload
Dosyalar volume olarak mount edildiği için, kod değişiklikleri anında yansır. Sadece Nginx'i yeniden başlatmanız gerekebilir:

```bash
docker-compose restart nginx
```

### Xdebug (Opsiyonel)
Xdebug eklemek için `Dockerfile`'ı güncelleyebilirsiniz.

### Production Build
Production için optimize edilmiş build:

```bash
docker-compose -f docker-compose.prod.yml up -d
```

## Container İstatistikleri

Container'ların kaynak kullanımını görmek için:

```bash
docker stats
```

## Temizlik

Tüm container'ları, volume'ları ve image'ları temizlemek için:

```bash
docker-compose down -v --rmi all
```

**DİKKAT:** Bu komut tüm verileri siler!

## Destek

Sorun yaşarsanız:
1. Logları kontrol edin: `docker-compose logs`
2. Container durumunu kontrol edin: `docker-compose ps`
3. Network'i kontrol edin: `docker network ls`

