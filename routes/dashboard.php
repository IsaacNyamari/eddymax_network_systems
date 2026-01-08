<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\AddressController as CustomerAddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Home
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        // Profile
        Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/security', [CustomerProfileController::class, 'security'])->name('profile.security');
        Route::patch('/profile/security', [CustomerProfileController::class, 'updateSecurity'])->name('profile.security.update');

        // Addresses
        Route::resource('/addresses', CustomerAddressController::class)->except(['show']);

        // Orders
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/return', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders/returns/page', [CustomerOrderController::class, 'return'])->name('orders.returns');
        Route::get('/orders/returns/page/order/{order}', [CustomerOrderController::class, 'showReturn'])->name('orders.returns.show');
        Route::post('/orders/{order}/track', [CustomerOrderController::class, 'track'])->name('orders.track');

        // filter orders
        Route::get('/orders/filter/{filter}', [CustomerOrderController::class, 'filterOrders'])->name('orders.filter');




        // Wishlist (if you have this feature)
        Route::get('/wishlist', function () {
            return view('dashboard.customer.wishlist');
        })->name('wishlist');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Statistics
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Products Management
        Route::resource('/products', AdminProductController::class);
        Route::get('/product/trash', [AdminProductController::class, 'trash'])->name('product.trash');
        Route::delete('/product/trash/{id}/delete', [AdminProductController::class, 'trashForceDelete'])->name('product.trash.force.delete');
        Route::get('/product/trash/{id}/restore', [AdminProductController::class, 'trashRestore'])->name('product.trash.restore');
        Route::post('/products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock.update');
        Route::post('/products/{product}/images', [AdminProductController::class, 'uploadImages'])->name('products.images.upload');
        Route::delete('/products/{product}/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.delete');

        // Orders Management
        Route::resource('/orders', AdminOrderController::class);
        Route::get('/orders/{order}/ship', [AdminOrderController::class, 'shipOrder'])->name('orders.status.ship');
        Route::get('/orders/{order}/delivered', [AdminOrderController::class, 'deliverOrder'])->name('orders.status.delivered');
        Route::get('/orders/{order}/process', [AdminOrderController::class, 'processOrder'])->name('orders.status.process');
        Route::get('/orders/{order}/cancel', [AdminOrderController::class, 'cancelOrder'])->name('orders.status.cancel');
        Route::get('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.payment-status.update');
        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/returns/page', [AdminOrderController::class, 'return'])->name('orders.returns');
        Route::get('/orders/returns/page/{order}', [AdminOrderController::class, 'showReturn'])->name('orders.returns.show');
        Route::post('/orders/returns/cancelled/{order}', [AdminOrderController::class, 'markOrderReturnCancelled'])->name('orders.returns.cancel');

        // Users Management
        Route::patch('/users/{user}/roles', [AdminUserController::class, 'updateRoles'])->name('users.roles.update');
        Route::patch('/users/{user}/permissions', [AdminUserController::class, 'updatePermissions'])->name('users.permissions.update');
        Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');
        Route::post('/users/stop-impersonating', [AdminUserController::class, 'stopImpersonating'])->name('users.stop-impersonating');
        Route::resource('/users', AdminUserController::class);

        // Categories Management
        Route::resource('/categories', AdminCategoryController::class);
        Route::post('/categories/{category}/products', [AdminCategoryController::class, 'addProduct'])->name('categories.products.add');
        Route::delete('/categories/{category}/products/{product}', [AdminCategoryController::class, 'removeProduct'])->name('categories.products.remove');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
        Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
        Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
        Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::patch('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
        Route::post('/settings/backup-database', [SettingController::class, 'createBackup'])->name('settings.backup.database');
        Route::post('/settings/backup/download/{path}', [SettingController::class, 'downloadFile'])->name('settings.backup.download');
        Route::post('/settings/backup/delete/{path}', [SettingController::class, 'deleteBackup'])->name('settings.backup.delete');
        Route::patch('/settings/shipping', [SettingController::class, 'updateShipping'])->name('settings.shipping.update');
        Route::patch('/settings/email', [SettingController::class, 'updateEmail'])->name('settings.email.update');

        // brands
        Route::resource('/brands', BrandsController::class);
        // Route::get('/brands', [BrandsController::class, 'index'])->name('brands');

        // // System
        // Route::get('/system/logs', function () {
        //     return view('dashboard.admin.system.logs');
        // })->name('system.logs');

        // Route::get('/system/backup', function () {
        //     return view('dashboard.admin.system.backup');
        // })->name('system.backup');
        // Dashboard-specific 404 fallback (must be last)

        // messages 
        // Messages (if you have a messaging system)
        Route::get('/messages/index', function () {
            return view('dashboard.account.messages');
        })->name('messages');
        Route::resource('/messages', controller: MessageController::class);
        Route::post('/messages/mark/read/{message}/',  [MessageController::class, 'markAsRead'])->name('mark.messages.read');
        Route::post('/messages/mark/unread/{message}/',  [MessageController::class, 'markAsUnread'])->name('mark.messages.unread');

        Route::fallback(function () {
            return response()->view('dashboard.errors.404', [], 404);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Common Routes (For all authenticated users)
    |--------------------------------------------------------------------------
    */
    Route::prefix('account')->name('account.')->group(function () {
        // Notifications
        Route::get('/notifications', function () {
            return view('dashboard.account.notifications');
        })->name('notifications');

        Route::post('/notifications/mark-all-read', function () {
            Auth::user()->unreadNotifications->markAsRead();
            return redirect()->back()->with('success', 'All notifications marked as read');
        })->name('notifications.mark-all-read');

        Route::delete('/notifications/{notification}', function ($notificationId) {
            Auth::user()->notifications()->where('id', $notificationId)->delete();
            return redirect()->back()->with('success', 'Notification deleted');
        })->name('notifications.delete');
    });
});
