FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libsqlite3-dev \
    && docker-php-ext-install intl pdo_mysql pdo_pgsql pdo_sqlite zip gd opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /srv/app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

COPY . .

RUN mkdir -p var/cache var/log public/build || true

EXPOSE 8080

CMD ["bash", "-lc", "php bin/console doctrine:migrations:migrate --no-interaction || true; php -S 0.0.0.0:${PORT:-8080} -t public"]
