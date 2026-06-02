<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Product $product)
    {
        // FIX 4: Honeypot check — bots fill hidden fields, humans leave them empty
        // The 'website' field is hidden via CSS in the form; any value = bot submission
        if (request('website') !== null && request('website') !== '') {
            // Silently redirect without saving — don't tell bots they were caught
            return back()->with('success', 'Avis publié!');
        }

        request()->validate([
            'name'    => 'required|string|max:100',
            'stars'   => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // FIX 6: Strip HTML tags from all user text inputs before storing
        Review::create([
            'product_id'  => $product->id,
            'name'        => strip_tags(request('name')),
            'stars'       => (int) request('stars'),
            'comment'     => strip_tags(request('comment')),
            'is_approved' => false, // FIX 4: always starts unapproved
        ]);

        return back()->with('success', 'Merci pour votre avis! Il sera publié après modération.');
    }
}
