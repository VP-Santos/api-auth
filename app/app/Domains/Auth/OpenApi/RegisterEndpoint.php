<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class RegisterEndpoint
{
    #[OA\Post(
        path: "/api/auth/register",
        summary: "Create a new user account",
        description: "Registers a new user with name, username, email, password, and access level. On success, a temporary verification token is sent via email. Use `/email/verify` to confirm the email and complete registration.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "user_name", "email", "password", "access_level"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "John Denver",
                        description: "Full name of the user"
                    ),
                    new OA\Property(
                        property: "user_name",
                        type: "string",
                        example: "John",
                        description: "Username for login or display purposes"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "User's email address, used for login and verification"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "Secret@123",
                        description: "User's password, should follow security rules"
                    ),
                    new OA\Property(
                        property: "access_level",
                        type: "string",
                        example: "adm",
                        description: "User's role or access level (e.g., admin, user)"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Account created successfully. A verification token has been sent to the user's email.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Account created. Please check your email for verification."
                        ),
                        new OA\Property(
                            property: "token",
                            type: "string",
                            example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e",
                            description: "Temporary email verification token. Use in `/email/verify` to confirm email. Expires after a short period."
                        )
                    ]
                )
            ),
        ]
    )]
    public function register() {}

    #[OA\Post(
        path: "/api/auth/email/verify",
        summary: "Verify user email",
        description: "Confirms the user's email using the temporary verification token received during registration. On success, returns a Sanctum `access_token` for authenticated requests.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "token"],
                properties: [
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "User's registered email address"
                    ),
                    new OA\Property(
                        property: "token",
                        type: "string",
                        example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e",
                        description: "Temporary verification token sent via email. Must be valid and not expired."
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Email verification successful. Returns Sanctum access token.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Email verification completed."
                        ),
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                            example: "1|zDD2mEyVYKVbKbHG7IIBQkDapXK3hpQT0N1rqLWy5a701043",
                            description: "Sanctum personal access token to authenticate future requests. Use in 'Authorization: Bearer {token}' header."
                        ),
                    ]
                )
            ),
        ]
    )]
    public function verifyEmail() {}
}
