FROM php:8.2-fpm

# Instalacja rozszerzeń PHP
RUN docker-php-ext-install pdo pdo_mysql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalacja zależności

CMD ["php-fpm"]
