<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::with('items')->orderByRaw("
            CASE status
                WHEN 'pending'   THEN 1
                WHEN 'confirmed' THEN 2
                WHEN 'shipped'   THEN 3
                WHEN 'delivered' THEN 4
                WHEN 'cancelled' THEN 5
                ELSE 6
            END
        ")->latest();

        if (request('status')) $query->where('status', request('status'));
        if (request('search')) $query->where(function($q) {
            $q->where('customer_name', 'like', '%'.request('search').'%')
              ->orWhere('customer_phone', 'like', '%'.request('search').'%');
        });
        if (request('period')) {
            match(request('period')) {
                'today' => $query->whereDate('created_at', today()),
                'week'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'month' => $query->whereMonth('created_at', now()->month),
                default => null,
            };
        }

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
    request()->validate([
        'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
    ]);
    $order->update(['status' => request('status')]);
    return back()->with('success', 'Statut mis à jour!');
}

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée!');
    }

    public function create() { abort(404); }
public function store() { abort(404); }
public function edit(Order $order) { abort(404); }
}
