<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class RegisterEndpoint
{
    #[OA\Post(
        path: "/api/auth/register",
        summary: "Registrar novo usuário",
        description: "Cria uma nova conta de usuário com nome, nome de usuário, e-mail, senha e nível de acesso. 
Após o cadastro, um token de verificação será enviado para o e-mail informado. Utilize `/email/verify` para confirmar o e-mail e concluir o registro.",
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
                        description: "Nome completo do usuário"
                    ),
                    new OA\Property(
                        property: "user_name",
                        type: "string",
                        example: "John",
                        description: "Nome de usuário para login ou exibição"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "john@example.com",
                        description: "E-mail do usuário, utilizado para login e verificação"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "Secret@123",
                        description: "Senha do usuário (deve seguir as regras de segurança definidas)"
                    ),
                    new OA\Property(
                        property: "access_level",
                        type: "string",
                        example: "admin",
                        description: "Nível de acesso do usuário (ex: admin, usuario)"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Conta criada com sucesso. Um token de verificação foi enviado para o e-mail.",
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
                            description: "Token temporário de verificação de e-mail. Utilize em `/email/verify`"
                        )
                    ]
                )
            ),
        ]
    )]
    public function register() {}

    #[OA\Post(
        path: "/api/auth/email/verify",
        summary: "Verificar e-mail",
        description: "Confirma o e-mail do usuário utilizando o token recebido no cadastro. 
        Em caso de sucesso, retorna um `access_token` do Sanctum para acesso às rotas autenticadas.",
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
                        description: "E-mail cadastrado do usuário"
                    ),
                    new OA\Property(
                        property: "token",
                        type: "string",
                        example: "5f44b18f095a512486a88b664a0e0189a517b61b0867b442884fe32d69d8023e",
                        description: "Token de verificação enviado por e-mail (deve ser válido)"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "E-mail verificado com sucesso.",
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
                            description: "Token de acesso do Sanctum para autenticação. Utilize no header: Authorization: Bearer {token}"
                        ),
                    ]
                )
            ),
        ]
    )]
    public function verifyEmail() {}
}
