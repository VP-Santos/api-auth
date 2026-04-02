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

    # Instala dependências se não existir vendor
    if [ ! -d "vendor" ]; then
        echo "Instalando dependências do Composer..."
        composer install --no-interaction --prefer-dist
        # composer install --no-interaction --optimize-autoloader

    fi

    # .env
    if [ ! -f ".env" ] && [ -f ".env.example" ]; then
        echo "Criando .env... e gerando APP_KEY"
        cp .env.example .env
        php artisan key:generate
    fi

    echo Permissões de escrita
    # Permissões (melhor que 777)
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true

    # Migrate
    php artisan migrate --force || echo "Migration falhou (ignorado)"
fi

echo "Subindo PHP-FPM..."

exec "$@"