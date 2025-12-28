# DSYB Projesi - Teknik Sunum Metni

Merhaba, bugün sizlere Konya DSYB web sitesi için geliştirdiğimiz modern web uygulamasını tanıtacağım.

## Proje Hakkında

Bu proje, mevcut bir web sitesinin bakımı zor hale gelmiş kodlarını modern teknolojilerle yeniden yazma ihtiyacından doğdu. Amacımız, hem kullanıcılar hem de yöneticiler için daha iyi bir deneyim sunmak ve gelecekte kolayca geliştirilebilir bir yapı oluşturmak.

## Teknoloji Seçimlerimiz

Projeyi üç ana bileşene ayırdık: backend, frontend ve veritabanı.

**Backend tarafında** .NET 8 Web API kullandık. .NET 8'i seçmemizin nedeni, performansı, güvenliği ve Microsoft'un desteği. RESTful API mimarisiyle çalışıyoruz, yani tüm işlemler HTTP istekleri üzerinden gerçekleşiyor.

**Frontend için** Next.js 14'ü tercih ettik. Next.js, React tabanlı bir framework ve özellikle App Router yapısı sayesinde hem server-side rendering hem de client-side rendering yapabiliyoruz. Bu da sayfalarımızın hem hızlı yüklenmesini hem de SEO açısından avantajlı olmasını sağlıyor.

**Veritabanı olarak** SQLite kullanıyoruz. Küçük ve orta ölçekli projeler için ideal, kurulum gerektirmiyor ve dosya tabanlı çalışıyor. İleride ihtiyaç olursa PostgreSQL veya MySQL'e geçiş yapmak da kolay.

**Güvenlik** için JWT, yani JSON Web Token kullanıyoruz. Kullanıcılar giriş yaptığında bir token alıyorlar ve bu token ile yetkili işlemleri gerçekleştirebiliyorlar. Şifreleri de BCrypt ile hash'liyoruz, yani veritabanında düz metin olarak saklamıyoruz.

## Mimari Yapı ve Katmanlar

Projeyi **modüler** bir şekilde tasarladık. Hem backend hem frontend'de katmanlı mimari kullanıyoruz.

### Backend Katmanları

**Mimari Notu:** Backend'imiz MVC değil, **Web API** mimarisi. MVC'de View'lar vardır ve HTML döndürür, ama bizim backend'imiz sadece JSON veri döndüren RESTful API endpoint'leri içeriyor. Frontend ayrı bir uygulama olduğu için bu ayrım önemli.

**Controllers Katmanı:** HTTP isteklerini karşılayan API controller'larımız var. Her modül için ayrı controller: Menüler, Sayfalar, Haberler, Duyurular, Medya ve Ayarlar. Her birinin kendi CRUD işlemleri mevcut. Controller'lar JSON formatında veri döndürüyor.

**Services Katmanı:** İş mantığını yöneten servisler. Örneğin AuthService, kullanıcı doğrulama ve JWT token oluşturma işlemlerini yönetiyor.

**Models Katmanı:** Veritabanı tablolarını temsil eden entity'ler. Her model, veritabanındaki bir tabloya karşılık geliyor.

**Data Katmanı:** Entity Framework Core ile veritabanı erişimi. ApplicationDbContext, tüm veritabanı işlemlerini yönetiyor. SQL sorguları yazmak yerine C# kodlarıyla çalışıyoruz, bu da hem daha güvenli hem de daha okunabilir kod demek.

### Frontend Katmanları

**App Katmanı:** Next.js App Router yapısı. Sayfalar ve route'lar burada tanımlı. Public site ve admin panel ayrı route'larda.

**Components Katmanı:** Yeniden kullanılabilir UI bileşenleri. Header, Footer gibi ortak bileşenler burada.

**Lib Katmanı:** Yardımcı fonksiyonlar ve servisler. API çağrıları için axios instance, Zustand ile state management, ve utility fonksiyonları.

**TypeScript** kullanarak tip güvenliği sağlıyoruz, bu da hataları daha erken yakalamamızı sağlıyor. **State management** için Zustand kullanıyoruz - Redux'a göre daha hafif ve kullanımı daha kolay.

## Öne Çıkan Özellikler

**Admin Panel:** Yöneticiler, web sitesinin tüm içeriğini görsel bir arayüzden yönetebiliyorlar. Menüleri dinamik olarak oluşturabiliyor, alt menüler ekleyebiliyor ve sıralamalarını değiştirebiliyorlar.

**HTML İçerik Yönetimi:** Sayfa içeriklerini zengin metin editörü ile HTML olarak oluşturup düzenleyebiliyorlar. Bu HTML içerikler veritabanında saklanıyor ve kullanıcı tarafında direkt olarak render ediliyor.

**SEO Optimizasyonu:** Her sayfa için meta description, meta keywords ve SEO-friendly URL'ler tanımlanabiliyor. Bu sayede arama motorlarında daha iyi sıralama alınabiliyor.

**Dosya Yönetimi:** Medya dosyaları admin panelden yüklenebiliyor ve otomatik olarak kategorize ediliyor. Yüklenen dosyalar hem admin panelde hem de public sitede kullanılabiliyor.

**Responsive Tasarım:** Tailwind CSS kullanarak modern ve responsive bir arayüz oluşturduk. Hem masaüstü hem de mobil cihazlarda sorunsuz çalışıyor.

## Containerization

Projeyi **Docker** ile containerize ettik. Docker Compose kullanarak hem backend hem frontend'i tek komutla çalıştırabiliyoruz. Bu sayede geliştirme ortamı kurulumu çok kolaylaşıyor ve "bende çalışıyordu" sorunları ortadan kalkıyor.

## Gelecek Planları

Şu an Phase 1'i tamamladık. Phase 2'de haber ve duyuru detay sayfalarını, daha gelişmiş arama özelliklerini ve belki bir blog modülünü ekleyebiliriz.

## Sonuç

Bu proje, modern web geliştirme pratiklerini kullanarak, bakımı kolay, ölçeklenebilir ve güvenli bir sistem oluşturma deneyimiydi. Hem teknik hem de kullanıcı deneyimi açısından mevcut sisteme göre önemli iyileştirmeler sağladık.

Sorularınız varsa memnuniyetle cevaplarım. Teşekkürler.

