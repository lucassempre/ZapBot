FROM php:8.2-fpm


RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libssl-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    unzip \
    redis \
    r-base

# Enable dependencies
RUN docker-php-ext-install bcmath pcntl exif bz2 ctype fileinfo gd intl mbstring mysqli pdo pdo_mysql session xml zip
RUN pecl install redis && docker-php-ext-enable redis


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
COPY --chown=1000:1000 ./src /var/www
COPY --chown=1000:1000 ./docker/custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN composer install


RUN chmod -R 755 storage/
RUN chown 1000:1000 -R /var/www/storage

