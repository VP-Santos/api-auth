#!/bin/bash
set -e

APP_DIR="/var/www/html"
cd "$APP_DIR" || exit 1

echo "🔒 Iniciando como $(whoami)..."

# 1. Ajustar PHP-FPM (igual ao outro)
if [ -f /usr/local/etc/php-fpm.d/www.conf ]; then
    echo "🔧 Configurando PHP-FPM para appuser..."
    sed -i 's/user = www-data/user = appuser/g' /usr/local/etc/php-fpm.d/www.conf
    sed -i 's/group = www-data/group = groupuser/g' /usr/local/etc/php-fpm.d/www.conf
fi



# 2. Criar .env
if [ ! -f ".env" ]; then
    echo "📄 Criando .env..."
    cp .env.example .env
    chown appuser:groupuser .env
fi

# 3. Aguardar MySQL
echo "⏳ Aguardando MySQL..."
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
echo "✅ MySQL pronto!"

# 4. Permissões (root faz isso)
echo "🔧 Ajustando permissões..."
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chown -R appuser:groupuser storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache

# 5. APP_KEY (rodar como appuser)
if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
    echo "🔑 Gerando APP_KEY..."
    gosu appuser php artisan key:generate --force
fi

# 6. Init única
INIT_FILE="storage/.initialized"

if [ ! -f "$INIT_FILE" ]; then
    echo "🚀 Primeira inicialização..."

    gosu appuser php artisan migrate --force --no-interaction

    gosu appuser bash -c "
        php artisan package:discover &&
        php artisan config:cache &&
        php artisan route:cache &&
        php artisan view:cache
    "

    touch "$INIT_FILE"
    chown appuser:groupuser "$INIT_FILE"
else
    echo "✅ App já inicializado"
fi

# 7. Subir supervisord (root)
echo "📡 Iniciando supervisord..."

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf &

exec php-fpm -F