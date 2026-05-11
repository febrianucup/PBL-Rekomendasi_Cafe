<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Users extends Controller
{
    public function show(){
        $user=Auth::user();

        return view('admin.settings', compact('user'));
    }
}
