<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $pieceOfDay = Product::where('in_stock', true)->where('is_piece_of_day', true)->first();
        $featured = Product::where('in_stock', true)->latest()->take(4)->get();
        $sections = [
            ['name' => 'Pièces', 'slug' => 'pieces', 'icon' => '⚙️', 'products' => Product::where('section', 'pieces')->where('in_stock', true)->take(4)->get()],
            ['name' => 'Carénage', 'slug' => 'carenage', 'icon' => '🛡️', 'products' => Product::where('section', 'carenage')->where('in_stock', true)->take(4)->get()],
            ['name' => 'Moteur & Électrique', 'slug' => 'moteur', 'icon' => '⚡', 'products' => Product::where('section', 'moteur')->where('in_stock', true)->take(4)->get()],
        ];
        return view('home', compact('pieceOfDay', 'featured', 'sections'));
    }
}
