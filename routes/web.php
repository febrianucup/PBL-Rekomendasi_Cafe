<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', [CafeController::class, 'index'])->name('cafes.index');

Route::get('/detail/{id}', [CafeController::class, 'show'])->name('cafes.show');

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login/form');

    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function(){
    Route::middleware(['isAdmin'])->prefix('admin')->group(function(){
        Route::get('/', function () {
            return redirect('/admin/cafes');
        });
        
        Route::get('/cafes', function () {
            return view('admin.cafes');
        });
        
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
        
        Route::get('/comments', function () {
            return view('admin.comments');
        });

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('admin.settings');

        Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');

        Route::post('/settings', function (\Illuminate\Http\Request $request) {
            $user = Auth::user();
            if (!$user) {
                // For testing if not logged in
                return back()->with('error', 'You must be logged in to update profile. (Currently testing without auth)');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'current_password' => 'nullable|string',
                'password' => 'nullable|string|min:8|confirmed',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password does not match']);
                }
                $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
            }

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'avatar_' . $user->id . '.' . $file->getClientOriginalExtension();
                
                $existing = \Illuminate\Support\Facades\Storage::disk('public')->files('avatars');
                foreach ($existing as $exFile) {
                    if (str_starts_with(basename($exFile), 'avatar_' . $user->id . '.')) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($exFile);
                    }
                }
                $file->storeAs('avatars', $filename, 'public');
            }

            $user->save();

            return back()->with('success', 'Profile updated successfully.');
        })->name('admin.settings.update');
    });

    Route::middleware('isOwner')->group(function(){
        Route::get('/dashboard/{id?}', [CafeController::class, 'ownerDashboard'])->name('owner.dashboard');

        Route::get('/add-cafe', [CafeController::class, 'create'])->name('add-cafe');
        Route::post('/add-cafe', [CafeController::class, 'addCafe'])->name('add-cafe.submit');

        Route::get('/cafe', function () {
            return view('Owner.profile.index');
        })->name('cafe');       

        Route::delete('/cafe/{id}', [CafeController::class, 'delete'])->name('cafe.delete');

        Route::get('/cafe/{id}/show', [CafeController::class, 'showOwner'])->name('cafe.show');
        Route::get('/cafe/{id}/edit', [CafeController::class, 'edit'])->name('cafe.edit');
        Route::put('/cafe/{id}', [CafeController::class, 'updateCafe'])->name('cafe.update');

    });
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/register', [SignUpController::class, 'showRegistrationForm']
)->name('register');

Route::post('/register/guest', [SignUpController::class, 'guestRegister']
)->name('register/guest');

Route::post('/register/owner', [SignUpController::class, 'ownerRegister']
)->name('register/owner');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/permission-denied', function(){
    return view('errPermission');
})->name('permissionErr');
// Rute untuk halaman admin kelola navbar
Route::middleware('auth')->group(function () {
    Route::get('/admin/navbar', [NavbarController::class, 'index'])->name('admin.navbar');
    Route::post('/admin/navbar', [NavbarController::class, 'store'])->name('admin.navbar.store');
    Route::delete('/admin/navbar/{id}', [NavbarController::class, 'destroy'])->name('admin.navbar.destroy');
});
// // Menampilkan form lupa password
// Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
//     ->middleware('guest')
//     ->name('password.request');

// // Memproses pengiriman link ke Gmail
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
//     ->middleware('guest')
//     ->name('password.email');
