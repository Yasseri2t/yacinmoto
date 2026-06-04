<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;

class HomeController extends Controller
{
    public function index()
    {
        $pieceOfDay = Product::where('in_stock', true)->where('is_piece_of_day', true)->first();
        $featured   = Product::where('in_stock', true)->latest()->take(4)->get();
        $dbSections = Section::orderBy('sort_order')->get();

        $allProducts = Product::where('in_stock', true)
            ->whereIn('section', $dbSections->pluck('slug'))
            ->latest()
            ->get()
            ->groupBy('section');

        $sections = $dbSections->map(fn($s) => [
            'name'     => $s->name,
            'slug'     => $s->slug,
            'icon'     => $s->icon,
            'products' => ($allProducts[$s->slug] ?? collect())->take(4),
        ]);

        return view('home', compact('pieceOfDay', 'featured', 'sections'));
    }
}
