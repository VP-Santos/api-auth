
# Introdução

Este é o meu primeiro projeto usando o framework laravel, montado de forma a ser consumido como uma API, neste projeto busco mostrar na pratica todo o conhecimento que adquiri com o meu primeiro trabalho em desenvolvimento. Contudo, este projeto também é para um conhecimento de como funciona o ecossistema de uma API de autenticação.

A estrutura que a aplicação foi construida, visei separar as responsabilidades por dominios, sendo assim o projeto possui três dominios:

- Auth
- Admin
- Users

Montado de forma que me assegure uma boa escalabilidade e manutenção no codigo. As rotas do projeto foram estruturadas de acordo com os principios REST

O foco desta API foi para melhorar e aperfeiçoar meu conhecimento dentro do mundo de desenvolvimento com PHP, Laravel e outras tecnologias como o Docker e Banco de Dados. Visando melhorar, deixando mais robusto e afiado o meu conhecimento seguindo boas praticas de programação e entender como funciona um serviço de Autenticação com envio de email (ex: confirmação, recuperação de senha, etc.). Com rotas para criação de usuarios e até mesmo rotas designadas para Adms.

# Tecnologias utilizadas

- Laravel
- PHP
- MySQL
- Docker
- Laravel Sanctum
- Mailhog

# Preparando o ambiente

Para preparar o ambiente e assim testar este projeto, siga os passos abaixo:

## Clonando o repositório

```bash

git clone https://github.com/VP-Santos/api-auth.git

cd api-auth
```

### Atenção!
Caso sua maquina tenha mysql, redis rodando em docker ou na propria maquina deve alterar o .env antes de subir o projeto.

se possui outro serviço para SMTP, também deve ser alterado no .env.

```env
DB_CONNECTION=mysql
DB_HOST=mysql 
DB_PORT=3306
DB_DATABASE=app_db
DB_USERNAME=app_user
DB_PASSWORD=secret

REDIS_CLIENT=phpredis
REDIS_HOST=api_redis
REDIS_PASSWORD=a12345678
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="api_auth@egmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

No arquivo docker-compose.yml deve ser removido o seguinte bloco:

```yaml
  mysql:
    container_name: api_mysql
    image: mysql:8.0
    environment:
      TZ: America/Sao_Paulo
      MYSQL_DATABASE: app_db
      MYSQL_USER: app_user
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: rootpass
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"
  redis:
    container_name: api_redis
    image: redis:7.0
    environment:
      REDIS_PASSWORD: "a12345678"
    command: ["redis-server","--requirepass", "a12345678", "--appendonly", "yes"]
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

  mailhog:
    container_name: api_mailhog
    image: mailhog/mailhog:latest
    ports:
      - "1025:1025"  
      - "8025:8025"
volumes:
  mysql_data:
  redis_data:
```

## Subindo os serviços

Em seu terminal rode o comando abaixo:

```bash
docker compose up -d
```

Ao executar este comando, os container que vão estar rodando são:
- api_nginx
- api_redis
- api_php
- api_mysql
- api_mailhog

### Atenção!

Caso já possua outros containers seja para Banco de dados, Redis e/ou serviço SMTP e seguiu o passo removendo os que vem no projeto, deve-se apontar esses containers para a mesma rede docker que a aplicação utiliza. 

Em seu terminal rode o comando:

```bash
docker network ls
```

Vai aparecer uma lista de redes das aplicações existentes no docker onde a rede da API é:

- api-auth_default

Em seguida rode o comando alerando o nome para cada container seja ele Redis, Banco de dados e/ou STMP

```bash
docker network connect api-auth_default nome_do_container
```

Para visualizar se o container esta usando a rede docker da api, rode:

```bash
docker inspect -f '{{json .NetworkSettings.Networks}}' meu_container
```

# Acessando o serviço

Para visualizar o serviço pelo navegador, postman ou insominia o endereço do projeto é:

```bash
http://localhost:8080
```

E o mailhog, se for usado o mesmo do projeto

```bash
 http://localhost:8025/
```