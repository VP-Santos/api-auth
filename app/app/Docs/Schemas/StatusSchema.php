<?php

namespace App\Docs\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StatusResponse",
    type: "object",
    properties: [
        new OA\Property(
            property: "status",
            type: "string",
            example: "connected"
        )
    ]
)]
class StatusSchema {}