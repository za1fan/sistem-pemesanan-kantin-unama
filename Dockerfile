FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

RUN a2enmod rewrite
WORKDIR /var/www/html

COPY . /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
