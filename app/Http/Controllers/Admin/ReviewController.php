<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $pending  = Review::with('product')->where('is_approved', false)->latest()->get();
        $approved = Review::with('product')->where('is_approved', true)->latest()->take(50)->get();

        return view('admin.reviews.index', compact('pending', 'approved'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Avis approuvé.');
    }

    public function reject(Review $review)
    {
        // Reject = delete permanently (not just hide)
        $review->delete();
        return back()->with('success', 'Avis supprimé.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Avis supprimé.');
    }
}
