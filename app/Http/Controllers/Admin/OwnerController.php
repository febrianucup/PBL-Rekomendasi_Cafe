<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\OwnerProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    // Display list of owners
    public function index()
    {
        $role = Role::where('name', 'owner')->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Role owner tidak ditemukan.');
        }

        $users = User::with('role', 'ownerProfile')
            ->where('role_id', $role->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.accounts', compact('users'));
    }

    // Show form to add owner
    public function create()
    {
        return view('admin.addOwner');
    }

    // Store new owner
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $role = Role::where('name', 'owner')->first();

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'username' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
                'status' => 'active'
            ]);

            // Create owner profile
            OwnerProfile::create([
                'user_id' => $user->id,
                'address' => $validated['alamat'],
                'cafe_name' => '', // Default empty for now, admin will create cafe later
            ]);

            DB::commit();
            return redirect()->route('admin.owners.index')->with('success', 'Akun Owner berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan Owner: ' . $e->getMessage());
        }
    }

    // Show form to edit owner
    public function edit($id)
    {
        $user = User::with('ownerProfile')->findOrFail($id);
        return view('admin.editAccount', compact('user'));
    }

    // Update owner
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $userData = [
                'username' => $validated['nama'],
                'email' => $validated['email'],
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            // Update owner profile
            $profile = OwnerProfile::firstOrCreate(['user_id' => $user->id]);
            $profile->update([
                'address' => $validated['alamat'],
            ]);

            DB::commit();
            return redirect()->route('admin.owners.index')->with('success', 'Akun Owner berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Owner: ' . $e->getMessage());
        }
    }

    // Delete owner
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete(); // This will cascade to owner profile and cafes if cascade on delete is set
            return redirect()->route('admin.owners.index')->with('success', 'Akun Owner berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Owner: ' . $e->getMessage());
        }
    }
}
