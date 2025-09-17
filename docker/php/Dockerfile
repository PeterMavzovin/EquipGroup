FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
COPY bootstrap/ ./bootstrap/
COPY config/ ./config/
COPY artisan ./
COPY .env .env

RUN composer install
COPY . .
RUN php artisan key:generate

EXPOSE 9000
CMD ["php-fpm"]