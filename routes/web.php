<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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
