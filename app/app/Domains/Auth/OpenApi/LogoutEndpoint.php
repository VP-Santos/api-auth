<?php

namespace App\Domains\Auth\OpenApi;

use OpenApi\Attributes as OA;

class LogoutEndpoint
{

    #[OA\Delete(
        path: "/api/auth/logout",
        summary: "Delete current access token",
        description: "Logs out the current user by deleting the personal access token. 
                  Include the token in the 'Authorization' header: 'Bearer {token}'.",
        tags: ["Auth"],
        security: [["bearerAuth" => []]], // mantém autenticado
        responses: [
            new OA\Response(
                response: 200,
                description: "Logged out successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Logged out successfully."),
                    ]
                )
            )
        ]
    )]
    public function logout() {}
}
