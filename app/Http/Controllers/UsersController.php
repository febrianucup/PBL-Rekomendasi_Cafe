<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function show(){
        $user=Auth::user();

        return view('profile-settings.settings', compact('user'));
    }

    public function update(Request $request){
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

        $user->username = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password does not match']);
            }
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            $existing = Storage::disk('public')->files('avatars');
            foreach ($existing as $exFile) {
                if (str_starts_with(basename($exFile), 'avatar_' . $user->id . '.')) {
                    Storage::disk('public')->delete($exFile);
                }
            }
            $file->storeAs('avatars', $filename, 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');

    }
}
