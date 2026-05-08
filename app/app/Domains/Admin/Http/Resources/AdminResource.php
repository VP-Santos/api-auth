<?php

namespace App\Domains\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'user_name'         => $this->user_name,
            'access_level'      => $this->access_level,
            'status'            => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'is_banned'         => $this->is_banned,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}