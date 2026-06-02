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
            'wilaya'         => 'required|integer|min:1|max:58',
            'address'        => 'required|string|max:500',
            'cart_data'      => 'required|string',
            'delivery_type'  => 'required|in:home,office',
        ]);

        // Decode cart_data — handle single or double JSON-encoded string
        $cartData = json_decode(request('cart_data'), true);
        if (is_string($cartData)) {
            $cartData = json_decode($cartData, true);
        }

        if (empty($cartData) || !is_array($cartData)) {
            return back()->withErrors(['cart_data' => 'Panier vide ou invalide.']);
        }

        // ── FIX 1: Recalculate product total from DB prices — ignore client prices entirely ──
        $productTotal = 0;
        $validatedItems = [];

        foreach ($cartData as $item) {
            $id  = (int) ($item['id'] ?? 0);
            $qty = (int) ($item['qty'] ?? 1);

            if ($id <= 0 || $qty <= 0 || $qty > 100) {
                continue; // skip invalid/suspicious items
            }

            $product = Product::where('id', $id)->where('in_stock', true)->first();

            if (!$product) {
                continue; // product not found or out of stock — skip silently
            }

            $lineTotal     = $product->price * $qty;
            $productTotal += $lineTotal;

            $validatedItems[] = [
                'product' => $product,
                'qty'     => $qty,
                'price'   => $product->price, // real DB price, never client value
            ];
        }

        if (empty($validatedItems)) {
            return back()->withErrors(['cart_data' => 'Aucun produit valide dans le panier.']);
        }

        // ── FIX 2: Recalculate delivery cost from DB — ignore client delivery_cost entirely ──
        $wilaya       = (int) request('wilaya');
        $deliveryType = request('delivery_type');

        $deliveryRow = DeliveryPrice::where('wilaya_number', $wilaya)->first();

        if (!$deliveryRow) {
            // Fallback defaults if wilaya not seeded (should not happen with 58 rows)
            $deliveryCost = $deliveryType === 'office' ? 300.0 : 400.0;
        } else {
            $deliveryCost = $deliveryType === 'office'
                ? (float) $deliveryRow->office_price
                : (float) $deliveryRow->home_price;
        }

        $total = $productTotal + $deliveryCost;

        // Create order with fully server-calculated total
        $order = Order::create([
            'customer_name'  => strip_tags(request('customer_name')),
            'customer_phone' => strip_tags(request('customer_phone')),
            'wilaya'         => $wilaya,
            'commune'        => strip_tags(request('commune', '')),
            'address'        => strip_tags(request('address')),
            'delivery_type'  => $deliveryType,
            'notes'          => strip_tags(request('notes', '')),
            'total'          => $total,
            'status'         => 'pending',
        ]);

        // Create order items using validated DB prices
        foreach ($validatedItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product']->id,
                'quantity'   => $item['qty'],
                'price'      => $item['price'], // snapshot of real price at order time
            ]);
        }

        return redirect()->route('order.success', $order);
    }

    public function success(Order $order)
    {
        $order->load('items.product');
        return view('order-success', compact('order'));
    }
}
