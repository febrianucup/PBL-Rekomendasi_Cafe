<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

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
