<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => OrderItemResource::collection($this->collection),
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
