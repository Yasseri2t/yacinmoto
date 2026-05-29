<?php
namespace App\Http\Controllers;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('reviews')->firstOrFail();
        return view('product', compact('product'));
    }
}
