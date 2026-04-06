#!/bin/bash

set -e

APP_DIR="/var/www/html"
cd $APP_DIR

echo "Aguardando MySQL..."

until php -r "
try {
    new PDO('mysql:host=mysql;dbname=app_db', 'app_user', 'secret');
} catch (Exception \$e) {
    exit(1);
}
" >/dev/null 2>&1; do
    echo "MySQL ainda não pronto..."
    sleep 2
done

echo "MySQL pronto!"

echo Permissões de escrita

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true


if [ "$AUTO_SETUP" = "true" ]; then
    echo "Executando setup automático..."

    if [ ! -d "vendor" ]; then
        echo "Instalando dependências do Composer..."
        composer install --no-interaction --prefer-dist
    fi

    if [ ! -f ".env" ] && [ -f ".env.example" ]; then
        echo "Criando .env... e gerando APP_KEY"
        cp .env.example .env
        php artisan key:generate
    fi

    php artisan migrate --force || echo "Migration falhou (ignorado)"
fi

echo "Subindo PHP-FPM..."

exec "$@"