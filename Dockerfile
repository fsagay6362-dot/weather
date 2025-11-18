FROM php:8.2-fpm

# Zainstaluj systemowe zależności
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Skopiuj Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Skopiuj pliki projektu
COPY . .

# Instalacja zależności PHP
RUN composer install --no-dev --optimize-autoloader

# Instalacja Nginx
RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 8080

CMD service php-fpm start && nginx -g "daemon off;"
