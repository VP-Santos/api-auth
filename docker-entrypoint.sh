set -e

cd /var/www/html

if [ ! -f .env ]; then
    echo "Criando .env..."
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    echo "Rodando composer install..."
    composer install --no-interaction --prefer-dist
fi

exec "$@"
