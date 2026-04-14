#!/bin/bash
set -e

cd /var/www/html

echo "Container iniciado como $(whoami)"

if [ ! -f .env ]; then
  cp .env.example .env
  chown appuser:appgroup .env
fi

echo "Aguardando MySQL..."

until php -r "
\$host = getenv('DB_HOST');
\$port = getenv('DB_PORT');
\$db   = getenv('DB_DATABASE');
\$user = getenv('DB_USERNAME');
\$pass = getenv('DB_PASSWORD');

try {
    new PDO(\"mysql:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass);
} catch (Exception \$e) {
    exit(1);
}
" >/dev/null 2>&1; do
    echo "MySQL ainda não pronto em ${DB_HOST}:${DB_PORT}..."
    sleep 2
done

echo "MySQL disponível"

mkdir -p storage bootstrap/cache
chown -R appuser:appgroup storage bootstrap/cache

echo "Iniciando supervisord..."

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf &

echo "Container pronto"

exec php-fpm -F