#!/bin/bash
set -e  # Para sair se algum comando falhar

# Caminho da aplicação
APP_DIR="/var/www/html"

cd $APP_DIR

# Copiar .env se ainda não existir
if [ ! -f "$APP_DIR/.env" ]; then
    echo "Criando .env a partir do .env.example..."
    cp .env.example .env
fi

# Instalar dependências do Composer
if [ ! -d "$APP_DIR/vendor" ]; then
    echo "Instalando dependências PHP via Composer..."
    composer install
fi

# Ajustar permissões
echo "Ajustando permissões..."
chmod -R 777 $APP_DIR/storage $APP_DIR/bootstrap/cache

# Executar o comando passado para o container
exec "$@"
