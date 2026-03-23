Este projeto marca minha primeira API desenvolvida com Laravel, consolidando na prática o conhecimento adquirido ao longo de um ano de experiência profissional em desenvolvimento de software.

A aplicação foi construída seguindo o padrão arquitetural MVC, com endpoints estruturados de acordo com os princípios REST, garantindo organização, escalabilidade e manutenibilidade do código.

O projeto também demonstra a implementação de autenticação de usuários, controle de acesso e uso eficiente do ecossistema Laravel, aplicando boas práticas amplamente utilizadas no desenvolvimento de APIs modernas.

Mais do que um projeto introdutório, este trabalho evidencia minha capacidade de projetar e desenvolver soluções backend robustas, com foco em clareza, padronização e qualidade de código.

# 🚀 API Auth – Guia de Execução e Consumo

## 📥 Clonando o repositório
```bash
git clone https://github.com/VP-Santos/api-auth.git
cd api-auth
```

## ▶️ Executando a aplicação
```bash
docker compose up -d
```

## 🌐 Consumo da API

Você pode testar a API utilizando ferramentas como Postman ou Insomnia.

### 🔗 URL base
```bash
    http://localhost:8080/api
```

### 📌 Headers utilizados
|Key | Value | quando usar |
| :--- | :--- | :--- |
| Accept | Application/json | em todas as rotas |
| Authorization | Bearer {token sanctum} | Rotas autenticada |

## 📦 Padrão de Resposta

### ✅ Sucesso
```json
{
	"success": true,
	"message": "...",
}
```

### ❌ Erro

##### 🔹 String
```json
{
	"success": false,
	"message": "message"
}
```

##### 🔹 Array
```json
{
	"success": false,
	"message": {
        "campo" : "message"
	}
}
```

## 🛣️ Documentação das Rotas

### 🟢 Status e Verificação
| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `GET` | `/status` | Verifica se a conexão com a API está ativa | Nenhuma |

#### Body:
```json
{
	"status": "connected"
}
```

### 🔐 Autenticação (/auth)
| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/register` | Cadastro de novos usuários no sistema | Nenhuma |

#### Body:
```json
{
    "name": "João Silva",
    "user_name": "joaosilva_dev",
    "email": "joao.silva@exemplo.com",
    "password": "SenhaSegura@123",
    "access_level": "user"
}
```

#### response
```json
{
	"success": true,
	"message": "Account created. Please check your email for verification.",
	"token": "7d641f4fcd783dee7e30e696c6e69896769a27208dc6062ef3ef6948c713c0e2"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/login`	| Realiza a autenticação e login do usuário | banned |

#### Body:
```json
{
	"email" : "joao.silva@exemplo.com",
	"password" : "SenhaSegura@123"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/email/verify` | Validação do endereço de e-mail | banned |

#### Body:
```json
{
	"token" : "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/two-factor/verify` | Validação do token de dois fatores (2FA) | banned |

#### Body:
```json
{
	"email": "joao.silva@exemplo.com",
	"code" : "303081"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/password/reset` | Redefinição final da senha com o token | banned |

#### Body:
```json
{
	"token" : "2bdc0abc8f18c4525dac51d1c484fd6a515abb861e225a2b739cc274fab217c7",
	"password" : "SenhaSegura@123",
	"password_confirmation": "SenhaSegura@123"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `POST` |	`/auth/password/resend-token` | Reenvia o token para troca de senha | banned |
| `POST` |	`/auth/two-factor/resend` | Reenvia o código de autenticação 2FA | banned |
| `POST` |	`/auth/password/forgot` | Solicitação de recuperação de senha | banned |

#### Body:
```json
{
	"email" : "joao.silva@exemplo.com"
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `DELETE` | `/auth/logout` | Revoga o token e encerra a sessão ativa | auth:sanctum |


### 👤 Perfil do Usuário (/users)
| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `GET` | `/users/me` | Retorna os dados do perfil autenticado | auth:sanctum, banned |

#### response:
```json
{
	"success": true,
	"message": "User retrieved successfully.",
	"data": {
		"id": 1,
		"name": "joaosilva_dev",
		"email": "joao.silva@exemplo.com"
	}
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `PATCH` |	`/users/me` | Atualiza as informações do perfil do usuário |auth:sanctum, banned |

#### Body:
```json
{
    "name": "João Silva",
    "user_name": "joaosilva_dev",
    "email": "joao.silva@exemplo.com",
    "password": "SenhaSegura@123"
}
```

#### Response:
```json
{
	"success": true,
	"message": "...",
    "data" : {}
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `PATCH` | `/users/me/password` | Realiza a alteração da própria senha |auth:sanctum, banned |

#### Body:
```json
{
	"password" : "SenhaSegura@123",
	"password_confirmation": "SenhaSegura@123"
}
```

#### Response:
```json

```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `DELETE` | `/users/me` | Permite que o usuário exclua a própria conta | auth:sanctum, banned |
s
### 🛡️ Administração (/admin)
| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `GET` |	`/admin/users` | Lista todos os usuários cadastrados (Admin) | admin, auth:sanctum |

#### Response:
```json
{
    "success" : true,
    "message" : "Users retrieved successfully.",
    "users" : {
    }
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `GET` |	`/admin/users/{id}` | Busca detalhes de um usuário específico por ID | admin, auth:sanctum |

#### Response:
```json
{
    "success" : true,
    "message" : "Users retrieved successfully.",
    "user" : {
    }
}
```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `PATCH` |	`/admin/users/{id}` | Atualiza dados de qualquer usuário via Admin | admin, auth:sanctum |

#### Body:
```json
{
    "name": "João Silva",
    "user_name": "joaosilva_dev",
    "email": "joao.silva@exemplo.com",
    "password": "SenhaSegura@123"
}
```

#### Response:
```json

```

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `DELETE` | `/admin/users/{id}` | Remove um usuário do sistema permanentemente | admin, auth:sanctum |
| `PATCH` |	`/admin/users/{id}/ban` | Aplica ou remove restrição (ban) de um usuário | admin, auth:sanctum |
| `PATCH` |	`/admin/users/{id}/promote` | Promove um usuário comum ao nível de Admin | admin, auth:sanctum |

#### Response:
```json
{
	"success": true,
	"message": "...",
}
```
