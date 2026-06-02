<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MotoTypeController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/',        [HomeController::class,  'index'])->name('home');
Route::get('/about',   fn() => view('about'))->name('about');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// FIX 4: review route — throttle 3 per hour per IP
Route::post('/product/{product}/review', [ReviewController::class, 'store'])
    ->middleware('throttle:review')
    ->name('review.store');

Route::get('/order/checkout',        [OrderController::class, 'create'])->name('order.create');
Route::post('/order/checkout',       [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

// Delivery price API — called by JS in checkout form
Route::get('/delivery-price/{wilaya}', [DeliveryController::class, 'forWilaya']);

// ── Admin login ──────────────────────────────────────────────────────────────
// Block the obvious /admin/login URL entirely
Route::get('/admin/login',  fn() => abort(404));
Route::post('/admin/login', fn() => abort(404));

Route::get('/admin/loginyacineadminmotos', function () {
    return view('admin.login');
})->name('admin.login');

// FIX 3: throttle 5 attempts per minute per IP to prevent brute-force
Route::post('/admin/loginyacineadminmotos', function () {
    if (request('password') !== env('ADMIN_PASSWORD')) {
        // FIX 7: log every failed attempt with IP for monitoring
        Log::warning('Failed admin login attempt', [
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'at'         => now()->toDateTimeString(),
        ]);
        return back()->withErrors(['password' => 'Mot de passe incorrect.']);
    }

    session(['admin_logged_in' => true]);
    return redirect()->route('admin.dashboard');
})->middleware('throttle:admin-login')->name('admin.login.post');

Route::get('/admin/logout', function () {
    session()->forget('admin_logged_in');
    return redirect()->route('admin.login');
})->name('admin.logout');

// ── Admin protected ───────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products',   AdminProductController::class);
    Route::resource('orders',     AdminOrderController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('moto-types', MotoTypeController::class);
    Route::resource('sections',   SectionController::class);
    Route::get('delivery',        [DeliveryController::class, 'index'])->name('delivery.index');
    Route::put('delivery',        [DeliveryController::class, 'update'])->name('delivery.update');

    // FIX 4: Admin review moderation routes
    Route::get('reviews',                      [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/approve',   [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{review}/reject',    [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{review}',          [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});
