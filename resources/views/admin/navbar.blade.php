<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Navbar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Kelola Menu Navbar</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- Form Tambah Menu -->
        <form action="{{ route('admin.navbar.store') }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded border">
            @csrf
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Nama Menu</label>
                    <input type="text" name="title" placeholder="Contoh: Tentang Kami" class="w-full border p-2 rounded" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">URL / Link</label>
                    <input type="text" name="url" placeholder="Contoh: /about" class="w-full border p-2 rounded" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Tambah</button>
                </div>
            </div>
        </form>

        <!-- Daftar Menu yang Ada -->
        <h2 class="text-xl font-semibold mb-3">Daftar Menu Saat Ini</h2>
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left">Nama Menu</th>
                    <th class="border p-2 text-left">URL</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($navbars as $menu)
                    <tr>
                        <td class="border p-2">{{ $menu->title }}</td>
                        <td class="border p-2">{{ $menu->url }}</td>
                        <td class="border p-2 text-center">
                            <form action="{{ route('admin.navbar.destroy', $menu->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-4 text-center text-gray-500">Belum ada menu yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>