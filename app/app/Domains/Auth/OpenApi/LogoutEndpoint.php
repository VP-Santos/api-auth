<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class LogoutEndpoint
{

    #[OA\Delete(
        path: "/api/auth/logout",
        summary: "deletar o token de accesso atual",
        description: "Rota autenticada para deletar o token de acesso. 
                 'Authorization' header: 'Bearer {token}'.",
        tags: ["Auth"],
        security: [],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logged out successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Logged out successfully."),
                    ]
                )
            )
        ]
    )]
    public function logout() {}
}
