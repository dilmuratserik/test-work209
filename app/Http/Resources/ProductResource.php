<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type'       => 'products',
            'id'         => (string) $this->id,
            'attributes' => [
                'name'  => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
            ],
            'links' => [
                'self' => url('/products/' . $this->id),
            ],
        ];
    }
}
