<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: "sanctumAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "API Token",
    description: "Use your Laravel Sanctum token here"
)]
class SanctumAuth {}
