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

if [ "$AUTO_SETUP" = "true" ]; then
    echo "Executando setup automático..."

    # .env
    if [ ! -f ".env" ] && [ -f ".env.example" ]; then
        echo "Criando .env..."
        cp .env.example .env
        php artisan key:generate
    fi

    # Permissões (melhor que 777)
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true

    # Migrate
    php artisan migrate --force || echo "Migration falhou (ignorado)"
else
    echo "AUTO_SETUP desativado, pulando setup..."
fi

echo "Subindo PHP-FPM..."

exec "$@"