<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentImageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use \App\Http\Controllers;
use App\Http\Controllers\PromosiController;
// use App\Http\Controllers\UsersController;


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [CafeController::class, 'index'])->name('cafes.index');
Route::get('/kontak', function () {
    return view('contact'); // Pastikan file kontak.blade.php ada
});
Route::get('/detail/{id}', [CafeController::class, 'show'])->name('cafes.show');

Route::post('/detail/{id}/favorite', [FavoriteController::class, 'favoriteToggle'])->name('cafes.favorite');
Route::post('/detail/{id}/rate', [CafeController::class, 'submitRating'])->name('cafes.rate');
Route::get('/favorite', [FavoriteController::class, 'show'])->name('favorite.cafes');

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login/form');

    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function(){
    Route::middleware(['isAdmin'])->prefix('admin')->group(function(){
        Route::get('/', function () {
            return redirect('/admin/cafes');
        });
        
        Route::get('/cafes', [\App\Http\Controllers\Admin\CafeController::class, 'index'])->name('admin.cafes');
        Route::get('/cafes/create', [\App\Http\Controllers\Admin\CafeController::class, 'create'])->name('admin.cafes.create');
        Route::post('/cafes', [\App\Http\Controllers\Admin\CafeController::class, 'store'])->name('admin.cafes.store');
        Route::get('/cafes/{id}/edit', [\App\Http\Controllers\Admin\CafeController::class, 'edit'])->name('admin.cafes.edit');
        Route::put('/cafes/{id}', [\App\Http\Controllers\Admin\CafeController::class, 'update'])->name('admin.cafes.update');
        Route::delete('/cafes/{id}', [\App\Http\Controllers\Admin\CafeController::class, 'destroy'])->name('admin.cafes.destroy');
        
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
        
        Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments');
        Route::patch('/comments/{id}/status', [\App\Http\Controllers\Admin\CommentController::class, 'updateStatus'])->name('admin.comments.status');
        Route::delete('/comments/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');

        Route::get('/owners', [\App\Http\Controllers\Admin\OwnerController::class, 'index'])->name('admin.owners.index');
        Route::get('/owners/create', [\App\Http\Controllers\Admin\OwnerController::class, 'create'])->name('admin.owners.create');
        Route::post('/owners', [\App\Http\Controllers\Admin\OwnerController::class, 'store'])->name('admin.owners.store');
        Route::get('/owners/{id}/edit', [\App\Http\Controllers\Admin\OwnerController::class, 'edit'])->name('admin.owners.edit');
        Route::put('/owners/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'update'])->name('admin.owners.update');
        Route::delete('/owners/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'destroy'])->name('admin.owners.destroy');


        Route::get('/beranda-settings', [\App\Http\Controllers\Admin\LandingPageSettingController::class, 'index'])->name('admin.beranda_settings');
        Route::post('/beranda-settings', [\App\Http\Controllers\Admin\LandingPageSettingController::class, 'update'])->name('admin.beranda_settings.update');

        Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
        Route::patch('/accounts/{id}/status', [AccountController::class, 'updateStatus'])->name('accounts.status');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
        Route::get('/navbar-settings', [NavbarController::class, 'index'])->name('admin.navbar');
    });

    Route::middleware('isOwner')->group(function(){
        Route::get('/promosi', [PromosiController::class, 'index'])->name('owner.promosi');
        Route::get('/promosi/create', [PromosiController::class, 'create'])->name('owner.promosi.create');
        Route::post('/promosi', [PromosiController::class, 'store'])->name('owner.promosi.store');
        Route::get('/promosi/{id}/edit', [PromosiController::class, 'edit'])->name('owner.promosi.edit');
        Route::put('/promosi/{id}', [PromosiController::class, 'update'])->name('owner.promosi.update');
        Route::delete('/promosi/{id}', [PromosiController::class, 'destroy'])->name('owner.promosi.destroy');
        Route::get('/dashboard/{id?}', [CafeController::class, 'ownerDashboard'])->name('owner.dashboard');

        Route::get('/add-cafe', [CafeController::class, 'create'])->name('add-cafe');
        Route::post('/add-cafe', [CafeController::class, 'addCafe'])->name('add-cafe.submit');

        Route::get('/cafe', function () {
            return view('Owner.profile.index');
        })->name('cafe');       

        Route::delete('/cafe/{id}', [CafeController::class, 'delete'])->name('cafe.delete');

        Route::get('/cafe/{id}', [CafeController::class, 'showOwner'])->name('cafe.show');
        Route::get('/cafe/{id}/show', [CafeController::class, 'showOwner'])->name('cafe.show.alt');
        Route::get('/cafe/{id}/edit', [CafeController::class, 'edit'])->name('cafe.edit');
        Route::put('/cafe/{id}', [CafeController::class, 'updateCafe'])->name('cafe.update');
        Route::delete('/cafe/{id}', [CafeController::class, 'delete'])->name('cafe.delete');
    });
});

Route::middleware(['auth'])->group(function(){
    Route::get('/profile/settings', [UsersController::class, 'show'])->name('profile.settings.show');

    Route::put('/profile/settings', [UsersController::class, 'update'])->name('profile.settings.update');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/register', [SignUpController::class, 'showRegistrationForm']
)->name('register');

Route::post('/register/guest', [SignUpController::class, 'guestRegister']
)->name('register/guest');

Route::post('/register/owner', [SignUpController::class, 'ownerRegister']
)->name('register/owner');

Route::get('/permission-denied', function(){
    return view('errPermission');
})->name('permissionErr');
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

Route::post('/comments/upload-image', [CommentImageController::class, 'upload'])->name('comments.upload-image')->middleware('auth');
