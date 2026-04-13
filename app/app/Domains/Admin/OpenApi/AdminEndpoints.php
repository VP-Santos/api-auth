<?php

namespace App\Domains\Admin\OpenApi;

use OpenApi\Attributes as OA;

class AdminEndpoints
{
    #[OA\Get(
        path: "/api/admin/usuarios",
        summary: "Listar todos os usuários",
        description: "Retorna todos os usuários cadastrados no sistema.",
        tags: ["Admin"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de usuários retornada com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Usuários listados com sucesso."),
                        new OA\Property(property: "users", type: "array", items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "user_name", type: "string", example: "John"),
                                new OA\Property(property: "email", type: "string", example: "john@example.com"),
                                new OA\Property(property: "access_level", type: "string", example: "usuario"),
                                new OA\Property(property: "is_banned", type: "boolean", example: false),
                            ]
                        ))
                    ]
                )
            )
        ]
    )]
    public function getAllUsers() {}

    #[OA\Get(
        path: "/api/admin/usuarios/{id}",
        summary: "Buscar usuário por ID",
        description: "Retorna os dados de um usuário específico com base no ID informado.",
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
                description: "Dados do usuário retornados com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Usuário encontrado com sucesso."),
                        new OA\Property(property: "user", type: "object", properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "user_name", type: "string", example: "John"),
                            new OA\Property(property: "email", type: "string", example: "john@example.com"),
                            new OA\Property(property: "access_level", type: "string", example: "usuario"),
                            new OA\Property(property: "is_banned", type: "boolean", example: false),
                        ])
                    ]
                )
            )
        ]
    )]
    public function getUser() {}

    #[OA\Patch(
        path: "/api/admin/usuarios/{id}",
        summary: "Atualizar usuário",
        description: "Atualiza os dados de um usuário com base no ID informado.",
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
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Denver"),
                    new OA\Property(property: "user_name", type: "string", example: "John"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuário atualizado com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Usuário atualizado com sucesso."),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function updateUser() {}

    #[OA\Delete(
        path: "/api/admin/usuarios/{id}",
        summary: "Excluir usuário",
        description: "Remove um usuário do sistema com base no ID informado.",
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
                description: "Usuário excluído com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Usuário excluído com sucesso.")
                    ]
                )
            )
        ]
    )]
    public function deleteUser() {}

    #[OA\Patch(
        path: "/api/admin/usuarios/{id}/banir",
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
                        new OA\Property(property: "message", type: "string", example: "Usuário banido com sucesso.")
                    ]
                )
            )
        ]
    )]
    public function banUser() {}

    #[OA\Patch(
        path: "/api/admin/usuarios/{id}/promover",
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
                        new OA\Property(property: "message", type: "string", example: "Usuário promovido para administrador com sucesso.")
                    ]
                )
            )
        ]
    )]
    public function promoteUser() {}

    #[OA\Patch(
        path: "/api/admin/usuarios/{id}/rebaixar",
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
                        new OA\Property(property: "message", type: "string", example: "Usuário rebaixado com sucesso.")
                    ]
                )
            )
        ]
    )]
    public function demoteUser() {}
}