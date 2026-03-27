<?php

namespace App\Domains\Admin\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Tag(name: "Admin", description: "Endpoints for user management, accessible only by admin users.")]
class AdminEndpoints
{
    #[OA\Get(
        path: "/api/admin/users",
        summary: "Get all users",
        description: "Retrieve a list of all users in the system. Requires admin privileges.",
        tags: ["Admin"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of users retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Users retrieved successfully."),
                        new OA\Property(property: "users", type: "array", items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "user_name", type: "string", example: "John"),
                                new OA\Property(property: "email", type: "string", example: "john@example.com"),
                                new OA\Property(property: "access_level", type: "string", example: "user"),
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
        path: "/api/admin/users/{id}",
        summary: "Get single user",
        description: "Retrieve details of a single user by ID. Admin access required.",
        tags: ["Admin"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the user",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User retrieved successfully."),
                        new OA\Property(property: "user", type: "object", properties: [
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
    public function getUser() {}

    #[OA\Patch(
        path: "/api/admin/users/{id}",
        summary: "Update user",
        description: "Update user details such as name, email, or access level. Requires admin privileges.",
        tags: ["Admin"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the user to update",
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
                    new OA\Property(property: "access_level", type: "string", example: "adm"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User updated successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User John updated successfully."),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function updateUser() {}

    #[OA\Delete(
        path: "/api/admin/users/{id}",
        summary: "Delete user",
        description: "Deletes a user by ID. Requires admin privileges.",
        tags: ["Admin"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the user to delete",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User deleted successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User John deleted successfully.")
                    ]
                )
            )
        ]
    )]
    public function deleteUser() {}

    #[OA\Patch(
        path: "/api/admin/users/{id}/ban",
        summary: "Ban user",
        description: "Bans a user from accessing the system. Admin access required.",
        tags: ["Admin"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the user to ban",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User banned successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User John banned successfully.")
                    ]
                )
            )
        ]
    )]
    public function banUser() {}

    #[OA\Patch(
        path: "/api/admin/users/{id}/promote",
        summary: "Promote user to admin",
        description: "Promotes a user to admin role. Requires admin privileges.",
        tags: ["Admin"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the user to promote",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User promoted successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User John promoted to admin successfully.")
                    ]
                )
            )
        ]
    )]
    public function promoteUser() {}
}