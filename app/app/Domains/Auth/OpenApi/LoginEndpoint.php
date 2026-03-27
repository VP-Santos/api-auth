<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class LoginEndpoint
{
    #[OA\Post(
        path: "/api/auth/login",
        summary: "User login",
        description: "Send user credentials (email and password). If valid, a temporary 2FA code will be sent to the user's email. Use `/two-factor/verify` to complete login.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "User's registered email address"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "Secret@123",
                        description: "User's password"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "A two-factor authentication code has been sent to the user's email.",
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
                            example: "Verification code sent to your email."
                        ),
                        new OA\Property(
                            property: "code",
                            type: "string",
                            example: "671573",
                            description: "Temporary two-factor authentication code (6 digits), valid for a few minutes"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Invalid credentials",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Invalid email or password")
                    ]
                )
            )
        ]
    )]
    public function login() {}

    #[OA\Post(
        path: "/api/auth/two-factor/resend",
        summary: "Resend 2FA code",
        description: "Generate and send a new two-factor authentication code to the user's email. The previous code will expire once a new one is issued.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email"],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "User's registered email address"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "A new 2FA code has been sent.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Two-factor authentication code sent to your email."),
                        new OA\Property(
                            property: "code",
                            type: "string",
                            example: "303081",
                            description: "Temporary two-factor authentication code (6 digits), valid for a few minutes"
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Email not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "User with this email not found")
                    ]
                )
            )
        ]
    )]
    public function resendTwoFactor() {}

    #[OA\Post(
        path: "/api/auth/two-factor/verify",
        summary: "Verify 2FA code",
        description: "Verify the two-factor authentication code sent via email. On success, returns a Sanctum `access_token` for authenticating protected endpoints.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "code"],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "User's registered email address"
                    ),
                    new OA\Property(
                        property: "code",
                        type: "string",
                        example: "303081",
                        description: "Two-factor authentication code received via email, valid for a few minutes"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login successful, returns Sanctum access token.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Login successful."),
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                            example: "1|aBc123Def456...",
                            description: "Sanctum personal access token for authenticated requests. Use in 'Authorization: Bearer {token}' header"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Invalid or expired 2FA code",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Invalid or expired 2FA code")
                    ]
                )
            )
        ]
    )]
    public function verifyTwoFactor() {}
}