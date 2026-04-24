<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes (maintenance mode applies)
|--------------------------------------------------------------------------
*/
Route::middleware('maintenance')->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Product listing & detail
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    // Review submission
    Route::post('/products/{product:slug}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Cart
    Route::prefix('cart')->name('cart.')->group(function (): void {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{key}', [CartController::class, 'update'])->name('update');
        Route::patch('/update-attributes/{key}', [CartController::class, 'updateAttributes'])->name('update-attributes');
        Route::delete('/remove/{key}', [CartController::class, 'remove'])->name('remove');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function (): void {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::get('/order-now', [CheckoutController::class, 'orderNow'])->name('order-now');
        Route::post('/order-now', [CheckoutController::class, 'storeOrderNow'])->name('store-order-now');
        Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('confirmation');
    });

    // About Us
    Route::get('/about', [HomeController::class, 'about'])->name('about');

    // Terms & Conditions
    Route::get('/terms-and-conditions', [HomeController::class, 'terms'])->name('terms');

    // Return Policy
    Route::get('/return-policy', [HomeController::class, 'returnPolicy'])->name('return-policy');

    // Customer Reviews
    Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews.index');
});

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (no admin.auth middleware — for guests)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function (): void {
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // Change password
    Route::get('/change-password', [Admin\AuthController::class, 'showChangePassword'])->name('change-password');
    Route::put('/change-password', [Admin\AuthController::class, 'changePassword'])->name('change-password.update');

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn () => redirect()->route('admin.dashboard'));

    // Products
    Route::resource('products', Admin\ProductController::class);

    // Sliders
    Route::resource('sliders', Admin\SliderController::class);

    // Orders
    Route::prefix('orders')->name('orders.')->group(function (): void {
        Route::get('/', [Admin\OrderController::class, 'index'])->name('index');
        Route::get('/export', [Admin\OrderController::class, 'export'])->name('export');
        Route::get('/{order}', [Admin\OrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('update-status');
    });

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Discounts
    Route::prefix('discounts')->name('discounts.')->group(function (): void {
        Route::get('/', [Admin\DiscountController::class, 'index'])->name('index');
        Route::patch('/{product}', [Admin\DiscountController::class, 'update'])->name('update');
        Route::post('/bulk', [Admin\DiscountController::class, 'bulkUpdate'])->name('bulk');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function (): void {
        Route::get('/', [Admin\ReviewController::class, 'index'])->name('index');
        Route::patch('/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('approve');
        Route::patch('/{review}/reject', [Admin\ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [Admin\ReviewController::class, 'destroy'])->name('destroy');
    });

    // Settings
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
