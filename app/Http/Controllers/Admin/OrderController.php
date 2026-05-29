<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::with('items')->latest();
        if (request('status')) $query->where('status', request('status'));
        if (request('search')) $query->where('customer_name', 'like', '%'.request('search').'%')->orWhere('customer_phone', 'like', '%'.request('search').'%');
        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product.category');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Order $order)
    {
        $order->update(['status' => request('status')]);
        return back()->with('success', 'Statut mis à jour!');
    }

    public function destroy(Order $order) { $order->delete(); return redirect()->route('admin.orders.index')->with('success', 'Supprimé!'); }
    public function create() {}
    public function store() {}
    public function edit(Order $order) {}
}
