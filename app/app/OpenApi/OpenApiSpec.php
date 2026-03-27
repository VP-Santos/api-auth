<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API AUTH",
    version: "1.0.0",
    description: "API de autenticação de usuários"
)]
#[OA\Server(
    url: "http://localhost:8080",
    description: "Servidor local"
)]
class OpenApiSpec {}