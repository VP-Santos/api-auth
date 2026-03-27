<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Status",
    description: "Endpoints to check API health and status"
)]
class StatusEndpoint
{
    #[OA\Get(
        path: "/api/status",
        summary: "Check API status",
        description: "Returns a simple response to indicate that the API is running.",
        tags: ["Status"],
        responses: [
            new OA\Response(
                response: 200,
                description: "API is up and running.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "API is running."),
                    ]
                )
            )
        ]
    )]
    public function status() {}
}