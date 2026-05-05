<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('ListCafe.listCafe');
});

Route::get('/detail/1', function () {
    return view('DetailCafe.detailcafe');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/cafes');
    });
    
    Route::get('/cafes', function () {
        return view('admin.cafes');
    });
    
    Route::get('/accounts', function () {
        return view('admin.accounts');
    });
    
    Route::get('/comments', function () {
        return view('admin.comments');
    });
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

// Rute untuk halaman admin kelola navbar
Route::middleware('auth')->group(function () {
    Route::get('/admin/navbar', [NavbarController::class, 'index'])->name('admin.navbar');
    Route::post('/admin/navbar', [NavbarController::class, 'store'])->name('admin.navbar.store');
    Route::delete('/admin/navbar/{id}', [NavbarController::class, 'destroy'])->name('admin.navbar.destroy');
});
// Menampilkan form lupa password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Memproses pengiriman link ke Gmail
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');