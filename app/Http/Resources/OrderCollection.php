<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
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
            'data' => OrderResource::collection($this->collection),
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
