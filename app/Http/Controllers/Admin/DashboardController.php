<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders   = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalRevenue  = Order::where('status', 'delivered')->sum('total');
        $recentOrders  = Order::with('items')->latest()->take(8)->get();
        $orderStats    = Order::selectRaw('status, count(*) as count')->groupBy('status')->get();
        return view('admin.dashboard', compact('totalOrders','pendingOrders','totalProducts','totalRevenue','recentOrders','orderStats'));
    }
}
