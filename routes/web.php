<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Rute yang dilindungi oleh middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    // Rute untuk halaman "All Users" (dapat diakses oleh admin, staff, dan user)
    Route::get('user', [UserController::class, 'index'])->name('user.index');

    // Rute untuk create dan store user (dapat diakses oleh admin, staff, dan user)
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');

    // Rute untuk edit dan update user (hanya untuk admin dan staff)
    Route::middleware(['role:admin,staff'])->group(function () {
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    });

    // Rute khusus untuk destroy user (hanya untuk admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Rute untuk produk, hanya create dan store untuk admin, staff, dan user
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');

    // Rute untuk edit, update, dan destroy produk, hanya untuk admin dan staff
    Route::middleware(['role:admin,staff'])->group(function () {
        Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    // Rute untuk melihat produk (dapat diakses oleh semua pengguna yang diautentikasi)
    Route::resource('product', ProductController::class)->only(['index', 'show']);

    // Rute untuk profil (akses untuk semua yang sudah autentikasi)
    Route::resource('profile', ProfileController::class);
});

