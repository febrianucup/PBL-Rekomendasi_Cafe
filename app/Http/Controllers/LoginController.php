<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm(){
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $remember = $request->has('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'loginError' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->status == 'pending') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda sedang dalam masa peninjauan oleh Admin. Silakan tunggu.',
            ]);
        }

        if ($user->status == 'rejected') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Maaf, pendaftaran akun Anda ditolak oleh Admin.',
            ]);
        }

        if ($user->role->name == 'admin') {
            return redirect('/admin/cafes');
        } else if ($user->role->name == 'owner') {
            return redirect('/dashboard');
        }

        return redirect()->intended('/');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login/form');
    }
}
