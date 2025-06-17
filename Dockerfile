FROM php:8.3-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    libpq-dev \
    git \
    vim

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

COPY .env.example /var/www/.env

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

RUN composer install --optimize-autoloader --no-dev

USER www-data

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
