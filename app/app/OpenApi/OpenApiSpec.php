<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API AUTH DOCUMENTATION",
    version: "1.0.0",
    description: "API de autenticação de usuários"
)]
#[OA\Server(
    url: "http://localhost:8080",
    description: "Servidor local"
)]

#[OA\Tag(
    name: "Status",
    description: "Endpoint para visualizar o serviço ativo."
)]
#[OA\Tag(
    name: "Auth",
    description: "Endpoints para autenticação: login, register, password reset, etc."
)]

#[OA\Tag(
    name: "Users",
    description: "Endpoints para o usuario autenticado (pegar dados, atualizar informações, atualizar senha, deletar conta)."
)]
#[OA\Tag(
    name: "Admin",
    description: "Endpoints para admnistradores (listar, pegar usuário pelo Id, atualizar dados de outro usuário, promover, banir, etc)."
)]
class OpenApiSpec {}
