<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'flowers' => FlowerResource::collection($this->whenLoaded('flowers')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}