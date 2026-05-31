<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;

class CatalogController extends Controller
{
    public function index()
    {
        $query = Product::where('in_stock', true)->with('category');

        if (request('category'))
            $query->whereHas('category', fn($q) => $q->where('slug', request('category')));

        if (request('search'))
            $query->where('name', 'like', '%' . request('search') . '%');

        if (request('section'))
            $query->where('section', request('section'));

        // FIX: filter by moto name (not slug) because compatible_models stores names like "Cuxi 1, Fiddle 3"
        if (request('moto')) {
            $motoName = \App\Models\MotoType::where('slug', request('moto'))->value('name');
            if ($motoName) {
                $query->where('compatible_models', 'like', '%' . $motoName . '%');
            }
        }

        $products  = $query->latest()->paginate(12);
        $categories = Category::all();
        $sections  = Section::orderBy('sort_order')->get();

        return view('catalog', compact('products', 'categories', 'sections'));
    }
}
