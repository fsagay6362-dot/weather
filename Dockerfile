# Używamy oficjalnego obrazu PHP z FPM
FROM php:8.2-fpm

# Instalacja rozszerzeń PHP potrzebnych dla Laravela
RUN docker-php-ext-install pdo pdo_mysql

# Instalacja Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ustaw katalog roboczy
WORKDIR /var/www/html

# Skopiuj pliki projektu
COPY . .

# Instalacja zależności
RUN composer install --no-dev --optimize-autoloader

# Instalacja Nginx
RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

# Skopiuj konfigurację Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Wystaw port 8080 (Render go wykryje)
EXPOSE 8080

# Uruchom PHP-FPM i Nginx
CMD service php-fpm start && nginx -g "daemon off;"
