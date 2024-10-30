<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Route::get('/dashboard', function () {
//     return view('pages.dashboard', ['type_menu' => 'dashboard']);

// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');




        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('profile', ProfileController::class);


        // Route::group(['middleware' => ['role:staff']], function () {
        //     Route::get('/dashboard', [DashboardController::class, 'index']);
        //     Route::post('/post/create', [PostController::class, 'store']);
        //     Route::put('/post/{post}', [PostController::class, 'update']);
        // });

        // Route::group(['middleware' => ['role:user']], function () {
        //     Route::post('/post/create', [PostController::class, 'store']);
        // });

    //      // Route khusus untuk admin (akses penuh)
    // Route::middleware(['role:admin'])->group(function () {
    //     Route::resource('user', UserController::class);
    //     Route::resource('product', ProductController::class);
    //     Route::resource('profile', ProfileController::class);
    // });

    // // Route untuk staff (menambahkan dan mengedit user, tidak bisa delete)
    // Route::middleware(['role:staff'])->group(function () {
    //     Route::get('user', [UserController::class, 'index'])->name('user.index');
    //     Route::post('user', [UserController::class, 'store'])->name('user.store');
    //     Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    // });

    // // Route untuk user (hanya bisa menambahkan)
    // Route::middleware(['role:user'])->group(function () {
    //     Route::post('user', [UserController::class, 'store'])->name('user.store');
    // });


});
