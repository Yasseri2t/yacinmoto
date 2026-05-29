<?php
namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Product $product)
    {
        request()->validate([
            'name'    => 'required|string|max:100',
            'stars'   => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        Review::create([
            'product_id' => $product->id,
            'name'       => request('name'),
            'stars'      => request('stars'),
            'comment'    => request('comment'),
        ]);
        return back()->with('success', 'Avis publié!');
    }
}
