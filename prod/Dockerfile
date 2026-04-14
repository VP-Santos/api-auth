FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    supervisor \
    gosu \
    && docker-php-ext-install pdo_mysql mysqli gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd -g ${GID} groupuser \
    && useradd -u ${UID} -g groupuser -m appuser

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./app/ .

# em prod o .env vem do servidor ou configurado vi CI/CD
COPY prod/.env.production ./.env

RUN chown -R appuser:groupuser /var/www/html

USER appuser 

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

USER root

COPY prod/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]