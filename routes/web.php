<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('ListCafe.listCafe');
});

Route::get('/detail/1', function () {
    return view('DetailCafe.detailcafe');
});

Route::redirect('/login', '/login/form');

Route::get('/login/form', [LoginController::class, 'loginForm'])->name('login/form');

Route::post('/login', [LoginController::class, 'login'])->name('login');

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

Route::get('/dashboard', function () {
    return view('Owner.dashboard');
});

Route::get('/add-cafe', function () {
    return view('Owner.profile.add-cafe');
})->name('add-cafe');

Route::get('/cafe', function () {
    return view('Owner.profile.index');
})->name('cafe');       

Route::get('/cafe/edit', function () {
    return view('Owner.profile.edit');
})->name('cafe.edit');
Route::get('/register', [SignUpController::class, 'showRegistrationForm']
)->name('register');

Route::post('/register/guest', [SignUpController::class, 'guestRegister']
)->name('register/guest');

Route::post('/register/owner', [SignUpController::class, 'ownerRegister']
)->name('register/owner');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');
