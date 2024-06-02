<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'type' => 'order-items',
            'id' => (string) $this->id,
            'attributes' => [
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'price' => $this->price,
            ],
            'relationships' => [
                'product' => [
                    'data' => new ProductResource($this->whenLoaded('product')),
                ],
            ],
        ];
    }
}
