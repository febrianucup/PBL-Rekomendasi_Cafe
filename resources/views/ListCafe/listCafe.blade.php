<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sensory Editorial - Discovery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAF9F6; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        header {background-color: #F5F1EC}
    </style>
</head>
<body class="text-gray-900">

    <header class="max-w-6xl mx-auto px-6 py-8 flex justify-between items-center border-b border-gray-200">
        <div class="font-bold text-xl">SAFE</div>
        <nav class="space-x-8 text-sm uppercase tracking-widest text-gray-500">
            <a href="#" class="text-black border-b border-black">Beranda</a>
        </nav>
        <div class="flex items-center space-x-4">
            @auth
                <!-- Dropdown for User/Profile, Settings, Logout -->
                <div class="relative group">
                    <button class="flex items-center gap-2 font-bold focus:outline-none">
                        {{ auth()->user()->name ?? 'User Profile' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg hidden group-hover:block z-50">
                        <div class="py-1">
                            <span class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">Profile</span>
                            <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">Settings</a>
                            <div class="border-t border-gray-100 mt-1"></div>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <form class="flex items-center">   
                    <label for="voice-search" class="sr-only">Search</label>
                    <input type="text" id="voice-search" class="border-b border-black py-2 px-5 bg-transparent" placeholder="Search..." required>
                    <button type="submit" class="bg-black text-white px-5 py-3 uppercase text-xs font-bold ml-2">Search</button>
                </form>
                <a class="bg-transparent border border-black text-black px-5 py-3 uppercase text-xs font-bold hover:bg-black hover:text-white transition" href="{{ route('login') }}">Login</a>
            @endauth
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4">Beranda</h1>
            <p class="text-gray-600 max-w-lg mx-auto">Cari cafe favoritmu dengan mudah.</p>
        </div>

        <div class="flex justify-center space-x-8 text-xs font-semibold uppercase tracking-widest mb-12 border-b border-gray-100 pb-4">
            <span class="border-b border-black pb-4">All Spaces</span>
            <span class="text-gray-400">Quiet</span>
            <span class="text-gray-400">Social</span>
            <span class="text-gray-400">Minimalist</span>
            <span class="text-gray-400">Industrial</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @for ($i = 0; $i < 6; $i++)
            <div class="group">
                <a href="detail/1">
                <div class="aspect-[4/3] bg-gray-300 mb-4 overflow-hidden">
                    <div class="w-full h-full bg-gray-200 animate-pulse"></div>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg">Nama Cafe {{$i+1}}</h3>
                        <p class="text-sm text-gray-500">Lokasi, Kota</p>
                    </div>
                    <div class="text-sm font-semibold">★ 4.8</div>
                </div>
                </a>
            </div>
            @endfor
        </div>
    
</body>
</html>