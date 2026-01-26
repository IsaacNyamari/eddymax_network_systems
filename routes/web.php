<?php

use App\Http\Controllers\CheckPayment;
use App\Http\Controllers\FrontStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Models\Product;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Store Routes
Route::name('store.')->group(function () {
    Route::get('/', [FrontStoreController::class, 'index'])->name('home');
    Route::get('/shop', [FrontStoreController::class, 'shop'])->name('shop');
    Route::get('/search/quick', [SearchController::class, 'quickSearch'])->name('search.index');
    Route::get('/shop/category/{category}', [FrontStoreController::class, 'filterCategory'])->name('filter.category');
    Route::get('/cart', [FrontStoreController::class, 'cart'])->name('cart');
    Route::get('/checkout', [FrontStoreController::class, 'checkout'])->name('checkout');
    Route::get('/contact', [FrontStoreController::class, 'contact'])->name('contact');
    Route::get('/order-confirmation', [FrontStoreController::class, 'orderConfirmation'])->name('order.confirmation');
});

// Product Display Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});
// Sitemap Routes - Add these at the beginning
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/sitemap-static.xml', [SitemapController::class, 'staticPages']);
Route::get('/sitemap-products-{page}.xml', [SitemapController::class, 'products'])
    ->where('page', '[0-9]+');

// Informational Pages
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/contact', [FrontStoreController::class, 'contact'])->name('contact');
    Route::get('/return-refund', [FrontStoreController::class, 'returnRefund'])->name('return-refund');
    Route::get('/privacy-policy', [FrontStoreController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms-conditions', [FrontStoreController::class, 'termsConditions'])->name('terms-conditions');
});

// User Account Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

// Admin Routes (if you have admin functionality)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/products', ProductController::class);
    // Add more admin routes here
});


Route::post('/logout', function () {
    Auth::logout();                  // Log out the user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate CSRF token
    return redirect()->route('store.home'); // Redirect to homepage (or login)
})->name('logout')->middleware('auth');

Route::get('/check/transaction/{ref}', [CheckPayment::class, 'verifyPaystackTransaction'])->name('check.transaction');
Route::get('/refund/transaction/{ref}', [CheckPayment::class, 'refundPaystackTransaction'])->name('refund.transaction');
Route::get('/check/balance/', [CheckPayment::class, 'checkMyBalance'])->name('check.balance');
Route::get('/navigation', function () {
    return view('livewire.welcome.navigation');
});

Route::get('/compress-images', function () {
    // Set unlimited time and memory
    set_time_limit(0); // Unlimited execution time
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '2048M'); // 2GB memory

    $products = Product::all();
    $total = $products->count();
    $optimized = 0;

    Log::info("Starting optimization for {$total} products...");

    foreach ($products as $index => $product) {
        try {
            $imagePath = public_path('storage/' . $product->image);

            if (file_exists($imagePath)) {
                ImageOptimizer::optimize($imagePath);
                $optimized++;

                // Log progress every 10 images
                if (($index + 1) % 10 === 0) {
                    Log::info("Progress: " . ($index + 1) . "/{$total} optimized");
                }
            } else {
                Log::warning("Image not found: " . $imagePath);
            }

            // Add small delay every 20 images to prevent timeout
            if (($index + 1) % 20 === 0) {
                sleep(1);
            }
        } catch (\Exception $e) {
            Log::error("Failed to optimize {$product->image}: " . $e->getMessage());
        }
    }

    Log::info("Optimization completed! {$optimized}/{$total} images optimized");
    return "Image optimization completed! {$optimized}/{$total} images optimized";
})->name('compress.images');

// Dashboard 
require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
