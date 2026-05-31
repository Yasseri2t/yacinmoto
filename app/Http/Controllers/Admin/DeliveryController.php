<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DeliveryPrice;

class DeliveryController extends Controller
{
    public function index()
    {
        $prices = DeliveryPrice::orderBy('wilaya_number')->get();
        return view('admin.delivery.index', compact('prices'));
    }

    public function update()
    {
        $homes   = request('home_price', []);
        $offices = request('office_price', []);

        foreach ($homes as $id => $price) {
            DeliveryPrice::where('id', $id)->update([
                'home_price'   => (float) $price,
                'office_price' => (float) ($offices[$id] ?? 0),
            ]);
        }

        return back()->with('success', 'Prix de livraison mis à jour!');
    }

    // API endpoint — returns delivery prices for a wilaya (called by JS in checkout)
    public function forWilaya(int $wilaya)
    {
        $price = DeliveryPrice::where('wilaya_number', $wilaya)->first();
        return response()->json($price ?? ['home_price' => 400, 'office_price' => 300]);
    }
}
