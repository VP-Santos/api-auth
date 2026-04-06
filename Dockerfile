FROM php:8.3-fpm 

RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get update \
    && apt-get install -y --no-install-recommends --fix-missing \
    git unzip libzip-dev libpng-dev libjpeg-dev supervisor \
    && docker-php-ext-install pdo_mysql mysqli gd zip \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /var/www/html

COPY ./app/ /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer 

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
