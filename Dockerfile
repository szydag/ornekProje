FROM php:8.2-fpm

# Sistem paketlerini güncelle ve gerekli paketleri yükle
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer'ı yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizinini ayarla
WORKDIR /var/www/html

# Proje dosyalarını kopyala
COPY . /var/www/html

# Gerekli izinleri ayarla
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

# Composer bağımlılıklarını yükle (eğer vendor yoksa)
RUN if [ ! -d "vendor" ]; then composer install --no-dev --optimize-autoloader; fi

EXPOSE 9000

CMD ["php-fpm"]

