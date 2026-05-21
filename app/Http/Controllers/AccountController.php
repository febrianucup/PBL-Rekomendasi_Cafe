<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
    // List all user accounts
    public function index()
    {
        $users = User::with('role')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.accounts', compact('users'));
    }

    // View profile account
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('admin.viewAccount', compact('user'));
    }

    // Edit profile account
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.editAccount', compact('user'));
    }

    // Update account
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string',
        ]);

        $user->update($validated);

        return redirect()->route('accounts.show', $user->id)
                         ->with('success', 'Account updated successfully.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/admin/accounts')
                         ->with('success', 'Account deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:active,rejected',
        ]);

        $user->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
}