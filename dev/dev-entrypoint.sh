#!/bin/bash
set -e

cd /var/www/html

echo "Container iniciado como $(whoami)"

if [ ! -f .env ]; then
  cp .env.example .env
  chown appuser:appgroup .env
fi

echo "Aguardando MySQL..."

until mysqladmin ping -h"${DB_HOST:-mysql}" -P3306 -u"${DB_USERNAME}" -p"${DB_PASSWORD}" --silent; do
  sleep 2
done

echo "MySQL disponível"

mkdir -p storage bootstrap/cache
chown -R appuser:appgroup storage bootstrap/cache

echo "Iniciando supervisord..."

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf &

echo "Container pronto"

exec php-fpm -F