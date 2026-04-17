FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    unzip curl \
    libzip-dev libpng-dev libjpeg-dev \
    supervisor \
    gosu \
    && docker-php-ext-install pdo_mysql gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000