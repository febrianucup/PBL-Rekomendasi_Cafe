<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi Input (Profil Dasar + Keamanan)
        $request->validate([
            'username'         => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Maks 2MB
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password'         => ['nullable', 'string', 'min:8', 'confirmed'], // Wajib ada password_confirmation di form
        ]);

        // 2. Update Username & Email
        $user->username = $request->username; 
        $user->email = $request->email;

        // 3. Update Foto Profil (Avatar)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama agar tidak memenuhi storage
            $files = Storage::disk('public')->files('avatars');
            foreach ($files as $file) {
                if (str_starts_with(basename($file), 'avatar_' . $user->id . '.')) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Simpan avatar baru
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = 'avatar_' . $user->id . '.' . $extension;
            
            // Simpan ke storage/app/public/avatars/
            $file->storeAs('avatars', $filename, 'public');
        }

        // 4. Update Password (Hanya jika input password diisi)
        if ($request->filled('password')) {
            // Validasi apakah password lama sesuai dengan database
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Password lama yang Anda masukkan salah.');
            }
            
            // Enkripsi dan ganti password baru
            $user->password = Hash::make($request->password);
        }

        // 5. Simpan semua perubahan
        $user->save();

        // 6. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pengaturan akun dan password berhasil diperbarui!');
    }
}