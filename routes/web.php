<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('ListCafe.listCafe');
});

Route::get('/detail/1', function () {
    return view('DetailCafe.detailcafe');
});

Route::redirect('/login', '/login/form');

Route::get('/login/form', [LoginController::class, 'loginForm'])->name('login/form');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return redirect('/admin/cafes');
    });

    Route::get('/cafes', function () {
        return view('admin.cafes');
    });

    // ACCOUNTS
    Route::get('/accounts', function () {
        return view('admin.accounts');
    });

    Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
    Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');

    Route::get('/comments', function () {
        return view('admin.comments');
    });

    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    Route::post('/settings', function (Request $request) {
        $user = Auth::user();

        if (!$user) {
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
                return back()->withErrors([
                    'current_password' => 'Current password does not match'
                ]);
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

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::get('/dashboard', function () {
    return view('Owner.dashboard');
});

Route::get('/add-cafe', function () {
    return view('Owner.profile.add-cafe');
})->name('add-cafe');

Route::get('/cafe', function () {
    return view('Owner.profile.index');
})->name('cafe');

Route::get('/cafe/edit', function () {
    return view('Owner.profile.edit');
})->name('cafe.edit');

Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');

Route::post('/register/guest', [SignUpController::class, 'guestRegister'])->name('register/guest');

Route::post('/register/owner', [SignUpController::class, 'ownerRegister'])->name('register/owner');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');