<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

class StatusController extends Controller
{
    #[OA\Get(
        path: "/api/status",
        summary: "Teste de API",
        tags: ["Status"],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/StatusResponse"
                )
            )
        ]
    )]
    public function status()
    {
        return response()->json([
            'status' => 'connected'
        ], 200);
    }
}