<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\V1\Clients;
use App\Http\Resources\V1\ClientsResource;

class BusinessesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "clients" => ClientsResource::collection($this->whenLoaded("clients")),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
