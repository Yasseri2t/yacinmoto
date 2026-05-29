<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        $query = Product::where('in_stock', true)->with('category');
        if (request('category')) $query->whereHas('category', fn($q) => $q->where('slug', request('category')));
        if (request('search')) $query->where('name', 'like', '%'.request('search').'%');
        if (request('section')) $query->where('section', request('section'));
        if (request('moto')) $query->where('compatible_models', 'like', '%'.request('moto').'%');
        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        return view('catalog', compact('products', 'categories'));
    }
}
