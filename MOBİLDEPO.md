Mobil depo uygulaması


# Entegre ERP Mobil Depo Uygulaması - Sunum Metni

Merhaba, bugün sizlere **Entegre ERP Mobil Depo Uygulaması** projemden bahsedeceğim.

Bu proje, kurumsal ERP sistemleriyle entegre çalışan bir React Native mobil uygulaması. Depo içi süreçleri - yani mal kabul, sayım, transfer, sevkiyat gibi işlemleri - mobil cihazlardan yönetmeyi sağlıyor.

**Teknik olarak** React Native 0.82 ve TypeScript kullandım. State management için Redux Toolkit, navigasyon için React Navigation kullandım. API iletişimi Axios ile yaptım. Form validasyonu için React Hook Form ve Yup, UI için React Native Paper tercih ettim. Barkod okuma özelliği için Vision Camera entegre ettim.

**Mimari açıdan** katmanlı bir yapı kurdum. UI katmanı, business logic için custom hooks, API servisleri ve Redux store'u ayrı ayrı organize ettim. Her özellik için modüler hook'lar yazdım - useAuth, useStockCounting, useWarehouses gibi. Bu sayede kod tekrarını azalttım ve bakımı kolaylaştırdım.

**Uygulamanın ana özellikleri** şunlar: Stok yönetimi ve sayım işlemleri, depo transferleri, raporlama, taslak yönetimi ve barkod okuma. Özellikle çevrimdışı çalışma desteği ekledim - internet olmasa bile taslaklar kaydediliyor, bağlantı gelince otomatik senkronize oluyor.

**Güvenlik** konusunda hassas veriler Keychain ile saklanıyor, JWT token yönetimi ve otomatik yenileme mekanizması ekledim.

**Platform desteği** olarak hem iOS hem Android için tek kod tabanıyla çalışıyor. Jest ile testler yazdım, Fastlane ile CI/CD hazırlığı yaptım.

Sonuç olarak, modern React Native mimarisi kullanarak kurumsal seviyede bir depo yönetim uygulaması geliştirdim. Modüler yapısı sayesinde yeni özellikler kolayca eklenebilir durumda.

Teşekkürler, sorularınız varsa yanıtlamaktan memnuniyet duyarım.

