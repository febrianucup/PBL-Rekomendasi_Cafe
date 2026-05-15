@extends('layouts.admin')

@section('content')
    <main class="flex-1 flex flex-col h-full overflow-y-auto px-8 py-6">
        
        <!-- Top Header -->
        <header class="flex justify-between items-center mb-10">
            <div class="relative w-1/2 max-w-md">
                <input type="text" placeholder="Search menus..." class="w-full bg-white rounded-full py-3 px-5 pl-12 shadow-sm focus:outline-none text-sm border-transparent focus:border-gray-300">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-4">
                <button class="bg-white p-3 rounded-full shadow-sm text-gray-400 hover:text-gray-600 relative">
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-400 rounded-full border-2 border-white"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <div class="bg-white py-2 px-3 rounded-full shadow-sm flex items-center gap-2 cursor-pointer text-sm font-medium">
                    <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">AU</div>
                    <span>Profile</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </header>

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="font-serif-custom text-4xl text-[#422927] mb-2">Navbar Navigation</h1>
            <p class="text-gray-500 text-sm">Curate and manage your website's main menu links.</p>
        </div>

        @if(session('success'))
            <div class="bg-[#eaf5ef] text-[#2f6846] p-4 rounded-xl mb-6 shadow-sm border border-[#c3e3d2] flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah Menu -->
        <div class="bg-white rounded-3xl p-8 shadow-sm mb-8 relative overflow-hidden">
            <!-- Decorative circle similar to the cards in reference -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F5F1EB] rounded-full translate-x-8 -translate-y-8 opacity-50 pointer-events-none"></div>
            
            <h2 class="text-lg font-semibold text-[#422927] mb-5">Add New Menu</h2>
            
            <form action="{{ route('admin.navbar.store') }}" method="POST">
                @csrf
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Menu Name</label>
                        <input type="text" name="title" placeholder="e.g. About Us" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:border-[#422927] focus:ring-1 focus:ring-[#422927] transition-all" required>
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-600 mb-2">URL / Link</label>
                        <input type="text" name="url" placeholder="e.g. /about" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:border-[#422927] focus:ring-1 focus:ring-[#422927] transition-all" required>
                    </div>
                    <div class="md:mt-7 w-full md:w-auto">
                        <button type="submit" class="w-full md:w-auto bg-[#422927] text-white px-8 py-3 rounded-full hover:bg-[#2d1b1a] transition-colors font-medium shadow-md">
                            Add Destination
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Menu yang Ada -->
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-white">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-serif-custom text-2xl text-[#422927]">Current Menus</h2>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="p-4 pl-6 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">Menu Item</th>
                            <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">Path / Location</th>
                            <th class="p-4 pr-6 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($navbars as $menu)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="p-4 pl-6 border-b border-gray-50">
                                    <span class="font-semibold text-[#422927]">{{ $menu->title }}</span>
                                </td>
                                <td class="p-4 border-b border-gray-50 text-gray-500">
                                    {{ $menu->url }}
                                </td>
                                <td class="p-4 pr-6 border-b border-gray-50 text-right">
                                    <form action="{{ route('admin.navbar.destroy', $menu->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <!-- Tombol hapus diganti tampilannya agar sejalan dengan kolom 'Edit' di referensi -->
                                        <button type="submit" class="text-gray-400 font-medium hover:text-red-500 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-400 italic">
                                    No navigation menus published yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </main>
@endsection