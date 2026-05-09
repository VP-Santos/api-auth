<?php

namespace App\Domains\Admin\OpenApi;

use OpenApi\Attributes as OA;

class AdminRoleEndpoints
{
    #[OA\Patch(
        path: "/api/admin/users/{id}/promote",
        summary: "Promover usuário",
        description: "Concede privilégios de administrador a um usuário.",
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
                description: "Usuário promovido com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User {name} promoted to admin successfully.")
                    ]
                )
            )
        ]
    )]
    public function promoteUser() {}

    #[OA\Patch(
        path: "/api/admin/users/{id}/demote",
        summary: "Remover privilégios de administrador",
        description: "Remove os privilégios de administrador de um usuário.",
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
                description: "Privilégios de administrador removidos com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User {name} demoted to user successfully.")
                    ]
                )
            )
        ]
    )]
    public function demoteUser() {}
}