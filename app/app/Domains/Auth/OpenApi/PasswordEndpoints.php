<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class PasswordEndpoints
{
    #[OA\Post(
        path: "/api/auth/password/forgot",
        summary: "Solicitar redefinição de senha",
        description: "Envia um token de redefinição de senha para o e-mail do usuário. 
O usuário poderá utilizar esse token para cadastrar uma nova senha. atravéz do endpoint `/api/auth/password/reset`",
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
                        description: "E-mail da conta que terá a senha redefinida"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "E-mail de redefinição enviado com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Password reset email sent. Please check your inbox."
                        ),
                        new OA\Property(
                            property: "token",
                            type: "string",
                            example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e",
                            description: "Token temporário para redefinição de senha"
                        ),
                    ]
                )
            )
        ]
    )]
    public function forgotPassword() {}

    #[OA\Patch(
        path: "/api/auth/password/reset",
        summary: "Redefinir senha",
        description: "Redefine a senha do usuário utilizando um token válido enviado por e-mail. 
É necessário informar a nova senha e sua confirmação.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["token", "password", "password_confirmation"],
                properties: [
                    new OA\Property(
                        property: 'token',
                        type: "string",
                        example: "5f44b18f095a512486a88b664a0e018...",
                        description: "Token de redefinição de senha recebido por e-mail"
                    ),
                    new OA\Property(
                        property: 'password',
                        format: 'password',
                        type: "string",
                        example: "Secret@123",
                        description: "Nova senha"
                    ),
                    new OA\Property(
                        property: 'password_confirmation',
                        format: 'password',
                        type: "string",
                        example: "Secret@123",
                        description: "Confirmação da nova senha"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Senha redefinida.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Password has been reset successfully."
                        )
                    ]
                )
            )
        ]
    )]
    public function resetPassword() {}

    #[OA\Post(
        path: "/api/auth/password/resend-token",
        summary: "Reenviar token de redefinição",
        description: "gera um novo token de redefinição de senha para o e-mail do usuário 
        caso ele não tenha recebido anteriormente ou expirou. Coletando o novo token utilize-o no endpoint `/api/auth/password/reset`.",
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
                        description: "E-mail da conta para reenviar o token de redefinição"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Token reenviado com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Password reset token sent to your email."
                        ),
                        new OA\Property(
                            property: "token",
                            type: "string",
                            example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e",
                            description: "Token temporário de redefinição de senha"
                        ),
                    ]
                )
            )
        ]
    )]
    public function resendTokenPassword() {}
}