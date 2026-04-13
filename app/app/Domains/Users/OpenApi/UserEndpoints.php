<?php

namespace App\Domains\Users\OpenApi;

use OpenApi\Attributes as OA;

class UserEndpoints
{
    #[OA\Get(
        path: "/api/user/me",
        summary: "Obtenha os dados de perfil do usuário autenticado",
        description: "Recupera os dados do perfil do usuário autenticado atual.",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Perfil do usuário recuperado.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User retrieved successfully."),
                        new OA\Property(property: "data", type: "object", properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "user_name", type: "string", example: "John"),
                            new OA\Property(property: "email", type: "string", example: "john@example.com"),
                            new OA\Property(property: "access_level", type: "string", example: "user"),
                            new OA\Property(property: "is_banned", type: "boolean", example: false),
                        ])
                    ]
                )
            )
        ]
    )]
    public function me() {}

    #[OA\Patch(
        path: "/api/user/me",
        summary: "Atualizar perfil de usuário autenticado",
        description: "Atualize as informações do perfil do usuário autenticado, como nome, e-mail ou nome de usuário (name, user_name, email).",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
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
                description: "Perfil do usuário atualizado.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User data updated successfully."),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function updateMe() {}

    #[OA\Patch(
        path: "/api/user/me/password",
        summary: "Atualizar senha do usuário autenticado",
        description: "Atualize a senha do usuário autenticado. Requer a senha atual e a nova senha.",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "current_password", type: "string", format: "password", example: "OldSecret@123"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "NewSecret@123"),
                    new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "NewSecret@123"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Senha atualizada",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Password updated successfully."),
                    ]
                )
            )
        ]
    )]
    public function updatePassword() {}

    #[OA\Delete(
        path: "/api/user/me",
        summary: "Excluir conta de usuário autenticado",
        description: "Exclui permanentemente a conta do usuário autenticado.",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "conta do usuario apagada.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Your account deleted successfully.")
                    ]
                )
            )
        ]
    )]
    public function deleteMe() {}
}
