
# Introdução

Este é o meu primeiro projeto usando o framework Laravel, montado de forma a ser consumido como uma API. Neste projeto, busco mostrar na prática todo o conhecimento que adquiri com o meu primeiro trabalho em desenvolvimento. Contudo, este projeto também tem o objetivo de servir como aprendizado sobre o ecossistema de uma API de autenticação.

A estrutura da aplicação foi construída visando separar as responsabilidades por domínios. Sendo assim, o projeto possui três domínios:

- Auth
- Admin
- Users

Foi montado de forma a assegurar boa escalabilidade e manutenção no código. As rotas do projeto foram estruturadas de acordo com os princípios REST.

O foco desta API é aprimorar meu conhecimento no desenvolvimento com PHP, Laravel e outras tecnologias, como Docker e bancos de dados, tornando meu aprendizado mais robusto. Além disso, visa compreender como funciona um serviço de autenticação com envio de e-mail (ex.: confirmação, recuperação de senha, etc.), com rotas para criação de usuários e rotas designadas para administradores.

Tecnologias utilizadas

# Tecnologias utilizadas

- Laravel
- PHP
- MySQL
- Docker
- Laravel Sanctum
- Mailhog
- Supervisor

# Preparando o ambiente

Para preparar o ambiente e testar este projeto, siga os passos abaixo:

## Clonando o repositório

```bash

git clone https://github.com/VP-Santos/api-auth.git

cd api-auth
```

### Observação!

Se sua máquina já possui MySQL, Redis ou algum serviço SMTP rodando localmente ou via Docker, siga o passo a passo abaixo.

#### arquivo .env-example

Edite o arquivo .env-example para ajustar as configurações de conexão:

```yml

```

Em seguida, altere a extensão do arquivo docker-compose.override.yml para:

```bash
docker-compose.override.txt
```

## Subindo os serviços

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
- api_worker

Caso tenha usado a configuração do docker-compose.override.yml do projeto será visualizado também os seguintes serviços. Containers extras (opcionais):
- api_mysql
- api_mailhog
- api_redis

#### Importante!

Se você alterou o .env-example e a extensão do docker-compose.override, os serviços extras (Redis, Mailhog, MySQL) que estiverem rodando em Docker devem ser conectados à rede da API:

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

# Acessando o serviço

- Documentação da API:

```bash
http://localhost:8080
```

- Mailhog (se utilizado):

```bash
 http://localhost:8025/
```