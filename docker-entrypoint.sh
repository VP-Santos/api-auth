#!/bin/bash
set -e  

APP_DIR="/var/www/html"
cd $APP_DIR

# Espera MySQL
echo "Aguardando MySQL..."
until php -r "new PDO('mysql:host=mysql;dbname=app_db', 'app_user', 'secret');" 2>/dev/null; do
    echo -n "."
    sleep 2
done
echo "MySQL pronto!"

# .env
if [ ! -f "$APP_DIR/.env" ] && [ -f "$APP_DIR/.env.example" ]; then
    echo "Criando .env a partir do .env.example..."
    cp .env.example .env
fi

# Composer
if [ ! -d "$APP_DIR/vendor" ]; then
    echo "Instalando dependências PHP via Composer..."
    composer install --no-interaction --optimize-autoloader
fi

# APP_KEY
if ! grep -q "^APP_KEY=" "$APP_DIR/.env" || grep -q "^APP_KEY=$" "$APP_DIR/.env"; then
    echo "Gerando APP_KEY..."
    php artisan key:generate
fi

# Permissões
echo "Ajustando permissões..."
[ -d "$APP_DIR/storage" ] && chmod -R 777 $APP_DIR/storage
[ -d "$APP_DIR/bootstrap/cache" ] && chmod -R 777 $APP_DIR/bootstrap/cache

# Migrations
echo "Rodando migrations..."
php artisan migrate --force || true 

# Inicia PHP-FPM
echo "Iniciando PHP-FPM..."
exec "$@"