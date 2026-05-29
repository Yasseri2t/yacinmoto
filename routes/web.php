<?php
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

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/order/checkout', [OrderController::class, 'create'])->name('order.create');
Route::post('/order/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

// Admin login
Route::get('/admin/login', function() { return view('admin.login'); })->name('admin.login');
Route::post('/admin/login', function() {
    if (request('password') === env('ADMIN_PASSWORD', 'changeme')) {
        session(['admin_logged_in' => true]);
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['password' => 'Mot de passe incorrect']);
})->name('admin.login.post');
Route::get('/admin/logout', function() {
    session()->forget('admin_logged_in');
    return redirect()->route('admin.login');
})->name('admin.logout');

// Admin protected
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('moto-types', MotoTypeController::class);
});
