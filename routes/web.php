<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminReviewController; // Import the new controller
use App\Http\Controllers\AdminSlideController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File; // Thêm dòng này ở đầu file web.php
use App\Http\Controllers\CheckoutController;

Route::get('/init-db', function () {
    try {
        // Bước A: Xóa thư mục/link storage cũ trong public (NẾU CÓ)
        // Việc này giúp lệnh storage:link ở dưới không bị báo lỗi "already exists"
        $publicStoragePath = public_path('storage');
        if (File::exists($publicStoragePath)) {
            // Nếu là link ảo (symlink) thì xóa link, nếu là thư mục thì xóa thư mục
            is_link($publicStoragePath) ? unlink($publicStoragePath) : File::deleteDirectory($publicStoragePath);
        }

        // 1. Khởi tạo lại Database
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true,
        ]);

        // 2. Tạo link kết nối MỚI
        Artisan::call('storage:link');

        // 3. Xóa cache
        Artisan::call('config:clear');

        Artisan::call('optimize:clear');

        Artisan::call('optimize');

        return "Khởi tạo thành công! Link Storage đã được làm mới.";
    } catch (\Exception $e) {
        return "Có lỗi xảy ra: " . $e->getMessage();
    }
});

/**
 * Frontend Routes
 */
Route::get('/', [ProductController::class, 'index'])->name('fe.home');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('fe.product.detail');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('fe.checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('fe.checkout.store');
Route::get('/thank-you/{order}', [CheckoutController::class, 'success'])->name('fe.checkout.success');

/**
 * Admin Routes
 * Các route này được bảo vệ bởi middleware 'auth' (đã đăng nhập) 
 * và 'admin' (kiểm tra quyền quản trị viên).
 */
Route::prefix('admin')->name('admin.')->group(function () {
    // Trang chủ Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý User (index, create, store, edit, update, destroy)
    Route::resource('users', UserManagementController::class);

    // Quản lý Sản phẩm (index, create, store, edit, update, destroy)
    Route::resource('products', ProductManagementController::class);

    // Quản lý Đơn hàng
    Route::resource('orders', OrderManagementController::class);

    // Quản lý Đánh giá
    Route::resource('reviews', AdminReviewController::class);

    // Quản lý Slide
    Route::resource('slides', AdminSlideController::class);
});
