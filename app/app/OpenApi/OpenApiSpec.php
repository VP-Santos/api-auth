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
    description: "Endpoints to check API health and status"
)]
#[OA\Tag(
    name: "Auth",
    description: "Endpoints for authentication: login, register, password reset, etc."
)]

#[OA\Tag(
    name: "Users",
    description: "Endpoints to manage logged-in user profile and settings"
)]
#[OA\Tag(
    name: "Admin",
    description: "Endpoints for admin user management"
)]
class OpenApiSpec {}
