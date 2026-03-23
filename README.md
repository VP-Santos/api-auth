Este projeto marca minha primeira API desenvolvida com Laravel, consolidando na prática o conhecimento adquirido ao longo de um ano de experiência profissional em desenvolvimento de software.

A aplicação foi construída seguindo o padrão arquitetural MVC, com endpoints estruturados de acordo com os princípios REST, garantindo organização, escalabilidade e manutenibilidade do código.

O projeto também demonstra a implementação de autenticação de usuários, controle de acesso e uso eficiente do ecossistema Laravel, aplicando boas práticas amplamente utilizadas no desenvolvimento de APIs modernas.

Mais do que um projeto introdutório, este trabalho evidencia minha capacidade de projetar e desenvolver soluções backend robustas, com foco em clareza, padronização e qualidade de código.

# 🚀 Como executar o projeto

Clone o repositório:
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
```

## 🛣️ Documentação das Rotas

| Método | Endpoint | Descrição | Proteção |
| :--- | :--- | :--- | :--- |
| `GET` | `/status` | Verifica se a conexão com a API está ativa | Nenhuma |
| `POST` |	`/auth/register` | Cadastro de novos usuários no sistema | Nenhuma|
| `POST` |	`/auth/login`	| Realiza a autenticação e login do usuário | banned|
| `POST` |	`/auth/email/verify` | Validação do endereço de e-mail | banned|
| `POST` |	`/auth/two-factor/verify` | Validação do token de dois fatores (2FA) | banned|
| `POST` |	`/auth/password/forgot` | Solicitação de recuperação de senha | banned|
| `POST` |	`/auth/password/reset` | Redefinição final da senha com o token | banned|
| `POST` |	`/auth/password/resend-token` | Reenvia o token para troca de senha | banned|
| `POST` |	`/auth/two-factor/resend` | Reenvia o código de autenticação 2FA | banned|
| `DELETE` | `/auth/logout` | Revoga o token e encerra a sessão ativa | auth:sanctum|
| `GET` | `/users/me` | Retorna os dados do perfil autenticado | auth:sanctum, banned|
| `PATCH` |	`/users/me` | Atualiza as informações do perfil do usuário |auth:sanctum, banned|
| `PATCH` | `/users/me/password` | Realiza a alteração da própria senha |auth:sanctum, banned|
| `DELETE` | `/users/me` | Permite que o usuário exclua a própria conta | auth:sanctum, banned|
| `GET` |	`/admin/users` | Lista todos os usuários cadastrados (Admin) | admin, auth:sanctum|
| `GET` |	`/admin/users/{id}` | Busca detalhes de um usuário específico por ID | admin, auth:sanctum|
| `PATCH` |	`/admin/users/{id}` | Atualiza dados de qualquer usuário via Admin | admin, auth:sanctum|
| `DELETE` | `/admin/users/{id}` | Remove um usuário do sistema permanentemente | admin, auth:sanctum|
| `PATCH` |	`/admin/users/{id}/ban` | Aplica ou remove restrição (ban) de um usuário | admin, auth:sanctum|
| `PATCH` |	`/admin/users/{id}/promote` | Promove um usuário comum ao nível de Admin | admin, auth:sanctum|
