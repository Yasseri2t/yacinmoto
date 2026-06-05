<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $period = request('period', 'all');

        $revenueQuery = Order::where('status', 'delivered');
        $ordersQuery  = Order::query();

        match($period) {
            'today' => [
                $revenueQuery->whereDate('created_at', today()),
                $ordersQuery->whereDate('created_at', today()),
            ],
            'week' => [
                $revenueQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            ],
            'month' => [
                $revenueQuery->whereMonth('created_at', now()->month),
                $ordersQuery->whereMonth('created_at', now()->month),
            ],
            default => null,
        };

        $totalOrders   = $ordersQuery->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalRevenue  = $revenueQuery->sum('total');
        $recentOrders  = Order::with('items')->latest()->take(8)->get();
        $orderStats    = Order::selectRaw('status, count(*) as count')->groupBy('status')->get();

        return view('admin.dashboard', compact(
            'totalOrders','pendingOrders','totalProducts',
            'totalRevenue','recentOrders','orderStats','period'
        ));
    }
}
