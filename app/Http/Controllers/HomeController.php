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

        // Always show 4 latest as "featured" ignoring section filter
        $featured = Product::where('in_stock', true)->latest()->take(4)->get();

        // Load sections from DB so admin-managed sections show here
        $dbSections = Section::orderBy('sort_order')->get();

        $sections = $dbSections->map(function ($s) {
            return [
                'name'     => $s->name,
                'slug'     => $s->slug,
                'icon'     => $s->icon,
                'products' => Product::where('section', $s->slug)
                                     ->where('in_stock', true)
                                     ->latest()
                                     ->take(4)
                                     ->get(),
            ];
        });

        return view('home', compact('pieceOfDay', 'featured', 'sections'));
    }
}
