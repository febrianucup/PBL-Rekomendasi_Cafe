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
        $credenttials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt($credenttials)){
            $user = Auth::user();

            if($user->status == 'pending'){
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda sedang dalam masa peninjauan oleh Admin. Silakan tunggu.',
                ]);
            }else if($user->status == 'rejected'){
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Maaf, pendaftaran akun Anda ditolak oleh Admin.',
                ]);
            }

           if (Auth::attempt($credenttials)) {
                $request->session()->regenerate();

                
                if($user->role->name == 'admin'){
                    return redirect('/admin/cafes');
                }else if($user->role->name == 'owner'){
                    return redirect('/dashboard');
                }else if($user->role->name == 'guest'){
                    return redirect()->intended('/');
                }

                return redirect()->intended('dashboard');
            }

            $remember = $request->filled('remember');
            if(Auth::attempt($credenttials, $remember)){
                $request->session()->regenerate();

                return redirect()->intended('/');
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/form');
    }
}
