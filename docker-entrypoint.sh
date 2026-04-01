#!/bin/bash
set -e  

APP_DIR="/var/www/html"

cd $APP_DIR

if [ ! -f "$APP_DIR/.env" ] && [ -f "$APP_DIR/.env.example" ]; then
    echo "Criando .env a partir do .env.example..."
    cp .env.example .env
fi


if [ ! -d "$APP_DIR/vendor" ]; then
    echo "Instalando dependências PHP via Composer..."
    composer install --no-interaction --optimize-autoloader
fi

# Gera a APP_KEY (se ainda não existir)
if ! grep -q "^APP_KEY=" "$APP_DIR/.env" || grep -q "^APP_KEY=$" "$APP_DIR/.env"; then
    echo "Gerando APP_KEY..."
    php artisan key:generate
fi

echo "Ajustando permissões..."
[ -d "$APP_DIR/storage" ] && chmod -R 777 $APP_DIR/storage
[ -d "$APP_DIR/bootstrap/cache" ] && chmod -R 777 $APP_DIR/bootstrap/cache


echo "Iniciando PHP-FPM..."
exec "$@"