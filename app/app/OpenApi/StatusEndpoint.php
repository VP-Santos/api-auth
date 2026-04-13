<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

class StatusEndpoint
{
    #[OA\Get(
        path: "/api/status",
        summary: "verificando API status",
        description: "Retorno simples para verificar se a API esta no ar",
        tags: ["Status"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Api subiu e esta rodando",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "API is running."),
                    ]
                )
            )
        ]
    )]
    public function status() {}
}