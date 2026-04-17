
# Introdução

Este é o meu primeiro projeto usando o framework Laravel, montado de forma a ser consumido como uma API. Neste projeto, busco mostrar na prática todo o conhecimento que adquiri com o meu primeiro trabalho em desenvolvimento. Contudo, este projeto também tem o objetivo de servir como aprendizado sobre o ecossistema de uma API de autenticação.

A estrutura da aplicação foi construída visando separar as responsabilidades por domínios. Sendo assim, o projeto possui três domínios:

- Auth 
- Admin
- Users

Foi montado de forma a assegurar boa escalabilidade e manutenção no código. As rotas do projeto foram estruturadas de acordo com os princípios REST.

O foco desta API é aprimorar meu conhecimento no desenvolvimento com PHP, Laravel e outras tecnologias, como Docker e bancos de dados, tornando meu aprendizado mais robusto. Além disso, visa compreender como funciona um serviço de autenticação com envio de e-mail (ex.: confirmação, recuperação de senha, etc.), com rotas para criação de usuários e rotas designadas para administradores.

# Stack

- Linguagem:  PHP 8.4
- Framework: Laravel 12
- Autenticação: Laravel Sanctum
- Banco de dados: MySQL 8
- Cache/Queue: Redis
- Infraestrutura: Docker & docker compose
- Servidor Web: Nginx
- Ferramentas: Mailhog (SMTP Test) & Supervisor
- Documentação: Swagger/OpenAPI 

# Preparando o ambiente

Para preparar o ambiente e testar este projeto, siga os passos abaixo:

## 1 - Clonando o repositório

```bash

git clone https://github.com/VP-Santos/api-auth.git

cd api-auth
```

### Ambiente de desenvolvimento
O projeto foi desenhado para ser "Plug and Play". Você tem duas formas de configurar os serviços:

### Opção A: Usando os containers do projeto (Padrão)
Basta rodar o comando de subida. O sistema criará o .env automaticamente com as credenciais padrão dos containers (MySQL, Redis, Mailhog).

### Opção B: Usando seus próprios serviços (Local/Externo)
Se sua máquina já possui MySQL, Redis ou algum serviço SMTP rodando em sua maquina ou externo, siga os passos abaixo.

#### passo 1: arquivo .env.building
Edite o arquivo .env.building para ajustar as configurações de conexão dos serviços que tenha localmente:

```env
APP_DEBUG=true
APP_ENV: local

DB_HOST: mysql
DB_PORT: 3306
DB_DATABASE: app_db
DB_USERNAME: app_user
DB_PASSWORD: secret

REDIS_CLIENT: phpredis
REDIS_HOST: redis
REDIS_PASSWORD: a12345678
REDIS_PORT: 6379

MAIL_MAILER: smtp
MAIL_HOST: mailhog
MAIL_PORT: 1025
MAIL_USERNAME: null
MAIL_PASSWORD: null
MAIL_FROM_ADDRESS: "api_auth@example.com"
```

#### passo 2: arquivo docker-compose.override.yml

Altere no arquivo docker-compose.override.yml removendo os serviços que ja tenha configurado.
Caso tenha configurado a conexão de todos os serviços altere a extensão do arquivo para:

```bash
docker-compose.override.txt
```

Arquivo docker-compose.override.yml:
```yml
services:
  mysql:
    container_name: mysql
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: app_db
      MYSQL_USER: app_user
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: rootpass
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"
  redis:
    container_name: redis
    image: redis:7.0
    environment:
      REDIS_PASSWORD: "a12345678"
    command: ["redis-server","--requirepass", "a12345678", "--appendonly", "yes"]
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

  mailhog:
    container_name: mailhog
    image: mailhog/mailhog:latest
    ports:
      - "1025:1025"  
      - "8025:8025"

volumes:
  mysql_data:
  redis_data:
```

Assim que configurado o durante o runtime do container onde são injetado suas dependências será criado o .env com as configurações desejadas, de forma automatizada via arquivo entrypoint

#### passo 3: Seus serviços extras (MySql, Redis ou SMTP) estão em containers

Deve-se fazer com que esses containers utilizem a mesma rede docker que a API auth utiliza. Por padrão o docker cria o seguinte nome da rede:

```bash
api-auth_default
```

para visualizar a rede docker da API rode o comando e visualize a rede:

```bash
docker network ls
```

Conecte cada container à rede usando:

```bash
docker network connect api-auth_default {nome_do_container}
```

Verifique se o container está usando a rede corretamente:

```bash
docker inspect -f '{{json .NetworkSettings.Networks}}' {meu_container}
```

# 2 - Subindo os containers

Execute o comando abaixo para iniciar os containers:

```bash
docker compose up -d
```

Para visualizar os containers que estão rodando use o seguinte comando:

```bash
docker ps
```

Os seguintes serviços vão estar ativos:

Containers essenciais:
- api_nginx
- api_php

Se estiver usado a configuração Padrao do projeto será visualizado também os seguintes serviços. Containers extras (opcionais):

- api_mysql
- api_mailhog
- api_redis


# 3 - Acessando o serviço

- Documentação da API:

```bash
http://localhost:8080
```
  
- Mailhog (se utilizado):

```bash
 http://localhost:8025/
```