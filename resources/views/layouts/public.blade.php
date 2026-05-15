<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Page') | Safe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/addcoment.js')
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAF9F6;
        }
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        header { 
            background-color: #F5F1EC; 
        }
        [x-cloak] { 
            display: none !important; 
        }
            .leaflet-control-container {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="text-gray-900 min-h-screen flex flex-col">
    <header class="w-full px-6 border-b border-gray-200">
        <div class="mx-auto px-6 py-6 flex justify-between items-center">
            <div class="font-bold text-xl tracking-wider">SAFE</div>

            <nav class="hidden md:flex space-x-8 text-sm uppercase tracking-widest text-gray-500">
                @isset($navbars)
                    @foreach($navbars as $menu)
                        <a href="{{ $menu->url }}" class="hover:text-black transition {{ request()->is(trim($menu->url, '/')) || (request()->is('/') && $menu->url === '/') ? 'text-black border-b border-black pb-1' : '' }}">
                        {{ $menu->title }}
                        </a>
                    @endforeach
                @else
                        <a href="/" class="text-black border-b border-black pb-1">Beranda</a>
                @endisset
            </nav>

            <div class="flex items-center space-x-6">
                @if (request()->routeIs('cafes.index'))
                     <form class="flex items-center">
                        <label for="voice-search" class="sr-only">Search</label>
                        <input type="text" id="voice-search" class="border-b border-black py-1.5 px-3 bg-transparent text-sm focus:outline-none" placeholder="Search..." required>
                        <button type="submit" class="bg-black text-white px-4 py-2 uppercase text-xs font-bold ml-2 transition hover:bg-gray-800">Search</button>
                    </form>
                @endif

                @auth

                <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
                    <button @click="open = !open" class="flex items-center gap-2 font-bold focus:outline-none text-sm">
                        {{ auth()->user()->username ?? 'User Profile' }}
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg z-50">
                        <div class="py-1">
                            <span class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">Profile</span>
                            @if (auth()->user()->role->name == 'owner')
                                <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                                    Owner Dashboard
                                </a>
                            @elseif (auth()->user()->role->name == 'admin')
                                <a href="{{ route('admin.cafes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">Settings</a>
                            <div class="border-t border-gray-100 mt-1"></div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="button" @click='$dispatch("open-logout-modal")' class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                    <a class="bg-transparent border border-black text-black px-4 py-2 uppercase text-xs font-bold hover:bg-black hover:text-white transition" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-logout-modal />

    @stack('scripts')
</body>
</html>