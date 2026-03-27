<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class PasswordEndpoints
{
    #[OA\Post(
        path: "/api/auth/password/forgot",
        summary: "Request password reset email",
        description: "Sends a password reset link/token to the user's email. 
                      The user can then use this token to reset their password.",
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
                        description: "The email address of the account to reset the password for"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Password reset email successfully sent.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "message", 
                            type: "string", 
                            example: "Password reset email sent. Please check your inbox."
                        ),
                        new OA\Property(property: "token", type: "string", example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e"),
                    ]
                )
            )
        ]
    )]
    public function forgotPassword() {}

    #[OA\Patch(
        path: "/api/auth/password/reset",
        summary: "Reset password using token",
        description: "Resets the user's password using a valid token sent via email. 
                      Requires the new password and its confirmation.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["token", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: 'token', type: "string", example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e"),
                    new OA\Property(property: 'password', format: 'password', type: "string", example: "Secret@123", description: "New password"),
                    new OA\Property(property: 'password_confirmation', format: 'password', type: "string", example: "Secret@123", description: "Confirmation of the new password"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Password successfully reset.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Password has been reset successfully."),
                        new OA\Property(property: "token", type: "string", example: "303081"),
                    ]
                )
            )
        ]
    )]
    public function resetPassword() {}

    #[OA\Post(
        path: "/api/auth/password/resend-token",
        summary: "Resend password reset token",
        description: "Resends the password reset token to the user's email if they did not receive it initially.",
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
                        description: "The email address of the account to resend the password reset token"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Password reset token successfully resent.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Password reset token sent to your email."),
                        new OA\Property(property: "token", type: "string", example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e"),
                    ]
                )
            )
        ]
    )]
    public function resendTokenPassword() {}
}