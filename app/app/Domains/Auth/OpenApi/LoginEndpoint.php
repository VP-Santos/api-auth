<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class LoginEndpoint
{
    #[OA\Post(
        path: "/api/auth/login",
        summary: "Login do usuário",
        description: "Envia as credenciais do usuário (e-mail e senha). Se forem válidas, um código temporário de 
        autenticação em dois fatores (2FA) será enviado para o e-mail. Utilize o endpoint `/two-factor/verify` e coloque o codigo (2FA)
         no body para concluir o login.",
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
                        description: "Endereço de e-mail cadastrado do usuário"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "Secret@123",
                        description: "Senha do usuário"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Código de verificação enviado para o e-mail.",
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
                            description: "Código temporário de autenticação em dois fatores (6 dígitos), válido por alguns minutos"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Credenciais inválidas",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Incorrect email or password.")
                    ]
                )
            )
        ]
    )]
    public function login() {}

    #[OA\Post(
        path: "/api/auth/two-factor/resend",
        summary: "Reenviar código 2FA",
        description: "Verifica se o codigo foi enviado, se passou do tempo de expiração, gera um código novo  de autenticação em dois fatores (2FA) 
        e reenvia para o e-mail do usuário e invalidando o anterior. Utilize o novo codigo no `/two-factor/verify`.",
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
                        description: "Endereço de e-mail cadastrado do usuário"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Novo código 2FA enviado.",
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
                            example: "Two-factor authentication code sent to your email."
                        ),
                        new OA\Property(
                            property: "code",
                            type: "string",
                            example: "303081",
                            description: "Código temporário de autenticação em dois fatores (6 dígitos), válido por alguns minutos"
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "E-mail não encontrado",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "No account found with this email address.")
                    ]
                )
            )
        ]
    )]
    public function resendTwoFactor() {}

    #[OA\Post(
        path: "/api/auth/two-factor/verify",
        summary: "Verificar código 2FA",
        description: "Valida o código de autenticação em dois fatores (2FA) enviado por e-mail. Em caso de sucesso, retorna um `access_token` do Sanctum para acesso a rotas protegidas.",
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
                        description: "Endereço de e-mail cadastrado do usuário"
                    ),
                    new OA\Property(
                        property: "code",
                        type: "string",
                        example: "303081",
                        description: "Código de autenticação em dois fatores recebido por e-mail (válido por alguns minutos)"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login realizado com sucesso.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Login realizado com sucesso."),
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                            example: "1|aBc123Def456...",
                            description: "Token de acesso do Sanctum para autenticação. Utilize no header: Authorization: Bearer {token}"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Código 2FA inválido ou expirado",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "error", type: "string", example: 'TOKEN_INVALID'),
                        new OA\Property(property: "message", type: "string", example: "Invalid or expired token.")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Código 2FA não encontrado",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "error", type: "string", example: 'TOKEN_NOT_FOUND'),
                        new OA\Property(property: "message", type: "string", example: "Token not found.")
                    ]
                )
            )
        ]
    )]
    public function verifyTwoFactor() {}
}
