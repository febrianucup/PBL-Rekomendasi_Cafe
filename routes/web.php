<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('../ListCafe/listCafe');
});

Route::get('/detail/1', function () {
    return view('../DetailCafe/detailcafe');
});
Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('Owner.Dashboard');
});
