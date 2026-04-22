<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OwnerProfile;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SignUpController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function ownerRegister(Request $request){
        $data = $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'cafe_name' => 'required|string',
            'address' => 'required|string',
        ]);

        DB::transaction(function() use ($data){
            $roleOwner = Role::where('name', 'owner')->first();

            $user = User::create([
                'role_id' => $roleOwner->id,
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'pending',
            ]);

            OwnerProfile::create([
                'user_id' => $user->id,
                'cafe_name' => $data['cafe_name'],
                'address' => $data['address'],
            ]);
        });

        return redirect('/login/form')->with('success', 'Registrasi berhasil, tunggu persetujuan admin.');
    }

    public function guestRegister(Request $request){
        $data = $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $roleGuest = Role::where('name', 'guest')->first();

        User::create([
            'role_id' => $roleGuest->id,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect('/login/form')->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }
}
