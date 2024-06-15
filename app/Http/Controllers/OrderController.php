<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    public function store(Request $request): OrderResource|JsonResponse
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $productIds = array_column($data['items'], 'product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        try {
            $order = DB::transaction(function () use ($data, $products) {
                $total = array_reduce($data['items'], function ($carry, $item) use ($products) {
                    $product = $products[$item['product_id']];
                    return $carry + ($product->price * $item['quantity']);
                }, 0);

                $order = Order::create(['total' => $total]);

                $orderItems = array_map(function ($item) use ($order, $products) {
                    $product = $products[$item['product_id']];
                    return [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $data['items']);

                OrderItem::insert($orderItems);

                foreach ($data['items'] as $item) {
                    $products[$item['product_id']]->decrement('stock', $item['quantity']);
                }

                return $order;
            });
        }
        catch (Throwable $e) {
            return response()->json(['error' => 'Ошибка при создании заказа: ' . $e->getMessage()], 500);
        }

        return new OrderResource($order->load('items.product'));
    }
}
