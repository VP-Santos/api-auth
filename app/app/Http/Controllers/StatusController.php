<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    public function status()
    {
        return response()->json([
            'message' => 'API is running.'
        ], 200);
    }
}