<?php

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

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// });