<?php

use App\Http\Controllers\CheckPayment;
use App\Http\Controllers\FrontStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Livewire\SiteSettings;
use App\Models\Brands;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

// // Get columns for a specific table
// Route::get('/tables/{tableName}', function ($tableName) {

//     // Check if table exists - FIXED: Add quotes around table name
//     $tableExists = DB::select("SHOW TABLES LIKE '{$tableName}'");

//     if (empty($tableExists)) {
//         return response()->json([
//             'error' => 'Table not found',
//             'message' => "Table '{$tableName}' does not exist in the database."
//         ], 404);
//     }

//     // Get columns for the specified table
//     $columns = DB::select("DESCRIBE `{$tableName}`");

//     // Format columns data
//     $columnList = array_map(function ($column) {
//         return [
//             'name' => $column->Field,
//             'type' => $column->Type,
//             'null' => $column->Null,
//             'key' => $column->Key,
//             'default' => $column->Default,
//             'extra' => $column->Extra,
//         ];
//     }, $columns);

//     return response()->json([
//         'table' => $tableName,
//         'columns' => $columnList,
//         'column_count' => count($columns)
//     ]);
// });

// Dashboard 

Route::get('/editor', function () {
    $brand  = Brands::where('name', 'like', '%acc%')->first()->id;
    $products = Product::where('price', '<=', 10)->get();
    dd($products);
});
require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
