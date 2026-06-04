<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DeliveryPrice;

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

        $cartData = json_decode(request('cart_data'), true);
        if (is_string($cartData)) $cartData = json_decode($cartData, true);

        if (!$cartData || count($cartData) === 0) {
            return back()->withErrors(['cart_data' => 'Panier vide!']);
        }

        $productTotal = 0;
        foreach ($cartData as $item) {
            $product = Product::find($item['id']);
            if ($product) $productTotal += $product->price * $item['qty'];
        }
        // Also verify delivery_cost against DB
        $deliveryRow = DeliveryPrice::where('wilaya_number', request('wilaya'))->first();
        $deliveryCost = $deliveryRow
            ? (request('delivery_type') === 'office' ? $deliveryRow->office_price : $deliveryRow->home_price)
            : 0;
        $total = $productTotal + $deliveryCost;

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
        $order->load('items.product');
        return view('order-success', compact('order'));
    }
}
