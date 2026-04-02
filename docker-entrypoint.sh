#!/bin/bash

APP_DIR="/var/www/html"
cd $APP_DIR

echo "Aguardando MySQL..."

until php -r "
try {
    new PDO('mysql:host=mysql;dbname=app_db', 'app_user', 'secret');
    echo 'ok';
} catch (Exception \$e) {
    exit(1);
}
" >/dev/null 2>&1; do
    echo "MySQL ainda não pronto..."
    sleep 2
done

echo "MySQL pronto!"

if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader || echo "Erro no composer"
fi


# .env
if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    echo "Criando .env..."
    cp .env.example .env
fi

# APP_KEY
php artisan key:generate || echo "Key generate falhou"

# Permissões
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Migrate (não derruba container)
php artisan migrate --force || echo "Migration falhou (ignorado)"

echo "Subindo PHP-FPM..."

exec "$@"