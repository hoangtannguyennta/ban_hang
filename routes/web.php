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

Route::get('/init-db', function () {
    try {
        // 1. Khởi tạo lại Database (Xóa sạch và tạo mới)
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        // 2. Tạo link kết nối thư mục storage với public
        Artisan::call('storage:link');

        // 3. (Tùy chọn) Xóa cache cấu hình để nhận thông số mới nhất
        Artisan::call('config:clear');

        return "Chúc mừng! Database đã migrate, seed và tạo Storage Link thành công!";
    } catch (\Exception $e) {
        return "Có lỗi xảy ra: " . $e->getMessage();
    }
});
/**
 * Frontend Routes
 */
Route::get('/', [ProductController::class, 'index'])->name('fe.home');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('fe.product.detail');

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
    Route::resource('orders', OrderManagementController::class)->only(['index', 'show', 'update', 'destroy']);

    // Quản lý Đánh giá
    Route::resource('reviews', AdminReviewController::class);

    // Quản lý Slide
    Route::resource('slides', AdminSlideController::class);
});
