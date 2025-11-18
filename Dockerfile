FROM php:8.2-fpm

# Systemowe zależności
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Skopiuj projekt
COPY . .

# Instalacja zależności PHP
RUN composer install --no-dev --optimize-autoloader

# Skopiuj konfigurację Nginx i Supervisora
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Wystaw port
EXPOSE 8080

# Uruchom supervisor (który odpali php-fpm i nginx)
CMD ["/usr/bin/supervisord", "-n"]
