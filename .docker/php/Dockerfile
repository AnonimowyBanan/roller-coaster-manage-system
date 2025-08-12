FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html