<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/detail/1', function () {
    return view('../DetailCafe/detailcafe');
});