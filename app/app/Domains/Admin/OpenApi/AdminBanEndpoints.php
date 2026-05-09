<?php

namespace App\Domains\Admin\OpenApi;

use OpenApi\Attributes as OA;

class AdminBanEndpoints
{
    #[OA\Patch(
        path: "/api/admin/users/{id}/ban",
        summary: "Banir usuário",
        description: "Bloqueia o acesso de um usuário ao sistema.",
        tags: ["Admin"],
        security: [
            ["sanctumAuth" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID do usuário",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuário banido com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User {id} banned successfully.")
                    ]
                )
            )
        ]
    )]
    public function unBanUser() {}
    #[OA\Patch(
        path: "/api/admin/users/{id}/unban",
        summary: "Remover banimento do usuário",
        description: "Remover bloquei de ban do usuário solicitado",
        tags: ["Admin"],
        security: [
            ["sanctumAuth" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID do usuário",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuário banido com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User {id} unbanned successfully.")
                    ]
                )
            )
        ]
    )]
    public function banUser() {}

}