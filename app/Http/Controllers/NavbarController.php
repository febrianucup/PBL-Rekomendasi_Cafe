<?php
namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    // Menampilkan halaman kelola navbar
    public function index()
    {
        $navbars = Navbar::orderBy('sort_order', 'asc')->get();
        return view('admin.navbar', compact('navbars'));
    }

    // Menyimpan menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        Navbar::create([
            'title' => $request->title,
            'url' => $request->url,
            'is_active' => true,
            'sort_order' => Navbar::count() + 1
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // Menghapus menu
    public function destroy(string $id)
    {
        Navbar::findOrFail($id)->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }
}