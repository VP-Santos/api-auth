#!/bin/bash
set -e

APP_DIR="/var/www/html"
cd "$APP_DIR" || exit 1

echo "Iniciando como $(whoami)..."

if [ -f /usr/local/etc/php-fpm.d/www.conf ]; then
    echo "🔧 Configurando PHP-FPM para appuser..."
    sed -i 's/user = www-data/user = appuser/g' /usr/local/etc/php-fpm.d/www.conf
    sed -i 's/group = www-data/group = groupuser/g' /usr/local/etc/php-fpm.d/www.conf
fi

if [ ! -f ".env" ]; then
    echo "Criando .env..."
    cp .env.example .env
    chown appuser:groupuser .env
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

echo " MySQL pronto!"

echo "Ajustando permissões..."
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chown -R appuser:groupuser storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache

if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
    echo "Gerando APP_KEY..."
    gosu appuser php artisan key:generate --force
fi

echo "Rodando migrations"
gosu appuser php artisan migrate --force --no-interaction

echo "limpando cache!"
gosu appuser bash -c "
php artisan package:discover &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache &&
php artisan event:cache
"

echo "Iniciando supervisord..."

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf &

exec php-fpm -F