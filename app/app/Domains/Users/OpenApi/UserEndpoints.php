<?php

namespace App\Domains\Users\OpenApi;

use OpenApi\Attributes as OA;

class UserEndpoints
{
    #[OA\Get(
        path: "/api/user/me",
        summary: "Get authenticated user profile",
        description: "Retrieve the current authenticated user's profile data. Requires user authentication.",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User profile retrieved successfully.",
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
        summary: "Update authenticated user profile",
        description: "Update the current authenticated user's profile information such as name, email, or username. Requires user authentication.",
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
                description: "User profile updated successfully.",
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
        summary: "Update authenticated user password",
        description: "Update the current authenticated user's password. Requires current password and new password.",
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
                description: "Password updated successfully.",
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
        summary: "Delete authenticated user account",
        description: "Delete the currently authenticated user's account permanently. Requires user authentication.",
        tags: ["Users"],
        security: [
            ["sanctumAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "User account deleted successfully.",
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
