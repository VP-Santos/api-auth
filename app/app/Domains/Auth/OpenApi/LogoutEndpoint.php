<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class LogoutEndpoint
{
    #[OA\Delete(
        path: "/api/auth/logout",
        summary: "Encerrar sessão do usuário",
        description: "Remove o token de acesso atual do usuário autenticado.\n\nHeader necessário:\nAuthorization: Bearer {token}",
        tags: ["Auth"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logout realizado com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true,
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Logged out successfully.",
                            description: "Mensagem de retorno da operação"
                        ),
                    ]
                )
            )
        ]
    )]
    public function logout() {}
}
