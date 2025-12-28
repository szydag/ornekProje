# 🔄 Port Değişikliği

## ✅ Yapılan Değişiklik

Proje artık **8082** portunda çalışıyor!

### Eski Port: 8081
### Yeni Port: 8082

## 🌐 Yeni Erişim Adresleri

| Servis | Eski URL | Yeni URL |
|--------|----------|----------|
| **Web Uygulaması** | http://localhost:8081 | **http://localhost:8082** |
| **Test Sayfası** | http://localhost:8081/test | **http://localhost:8082/test** |
| **phpMyAdmin** | http://localhost:8080 | http://localhost:8080 (değişmedi) |
| **MySQL** | localhost:3306 | localhost:3306 (değişmedi) |

## 🚀 Container'ı Yeniden Başlatma

Port değişikliğinden sonra Nginx container'ını yeniden başlatmanız gerekiyor:

```bash
docker-compose restart nginx
```

veya tüm container'ları yeniden başlatmak için:

```bash
docker-compose down
docker-compose up -d
```

## ✅ Kontrol

Port'un çalıştığını kontrol etmek için:

```bash
curl http://localhost:8082/test
```

veya tarayıcıda:
```
http://localhost:8082
```

## 📝 Not

Eğer 8082 portu başka bir uygulama tarafından kullanılıyorsa, `docker-compose.yml` dosyasındaki port numarasını değiştirebilirsiniz:

```yaml
nginx:
  ports:
    - "8083:80"  # İstediğiniz port numarası
```


