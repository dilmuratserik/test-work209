<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'total' => array_reduce($data['items'], function ($total, $item) {
                    $product = Product::find($item['product_id']);
                    return $total + ($product->price * $item['quantity']);
                }, 0),
            ]);

            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        return new OrderResource($order->load('items.product'));
    }
}
