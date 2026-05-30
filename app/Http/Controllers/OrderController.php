<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function create()
    {
        return view('order');
    }

    public function store()
    {
        request()->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'wilaya'         => 'required',
            'address'        => 'required|string',
            'cart_data'      => 'required',
        ]);

        $raw = request('cart_data');
        // Handle double-encoded JSON
        $cartData = json_decode($raw, true);
        if (is_string($cartData)) {
            $cartData = json_decode($cartData, true);
        }

        if (!$cartData || count($cartData) === 0) {
            return back()->withErrors(['cart_data' => 'Panier vide!']);
        }

        $total = collect($cartData)->sum(fn($i) => $i['price'] * $i['qty']);

        $order = Order::create([
            'customer_name'  => request('customer_name'),
            'customer_phone' => request('customer_phone'),
            'wilaya'         => request('wilaya'),
            'commune'        => request('commune'),
            'address'        => request('address'),
            'delivery_type'  => request('delivery_type', 'home'),
            'notes'          => request('notes'),
            'total'          => $total,
            'status'         => 'pending',
        ]);

        foreach ($cartData as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'],
                ]);
            }
        }

        return redirect()->route('order.success', $order);
    }

    public function success(Order $order)
    {
        return view('order-success', compact('order'));
    }
}
