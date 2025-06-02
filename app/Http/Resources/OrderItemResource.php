<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'flower' => new FlowerResource($this->whenLoaded('flower')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}