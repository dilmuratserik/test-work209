<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'orders',
            'id' => (string) $this->id,
            'attributes' => [
                'total' => $this->total,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'items' => [
                    'data' => OrderItemResource::collection($this->whenLoaded('items')),
                ],
            ],
        ];
    }

    public function with($request)
    {
        return [
            'jsonapi' => [
                'version' => '1.0',
            ],
        ];
    }
}

