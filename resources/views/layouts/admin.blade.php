<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | PBL Cafe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-cream font-sans text-gray-800 antialiased selection:bg-soft-green selection:text-white">
    @php
        $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()?->name ?? 'Admin User').'&background=D6CFC7&color=4B2E2B';
        if (auth()->check()) {
            $files = \Illuminate\Support\Facades\Storage::disk('public')->files('avatars');
            foreach ($files as $file) {
                if (str_starts_with(basename($file), 'avatar_' . auth()->id() . '.')) {
                    $avatarUrl = asset('storage/' . $file);
                    break;
                }
            }
        }
    @endphp
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl shadow-light-beige/50 z-20 flex flex-col justify-between" x-data="{ currentRoute: '{{ request()->path() }}' }">
            <div>
                <!-- Logo -->
                <div class="h-24 flex items-center px-8 border-b-2 border-cream">
                    <h1 class="font-serif text-3xl font-bold tracking-tight text-dark-brown italic">PBL.</h1>
                </div>

                <!-- Navigation -->
                <nav class="p-6 space-y-2">
                    <a href="/admin/cafes" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is('admin/cafes') || request()->is('admin') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="font-medium">The Collection</span>
                    </a>
                    
                    <a href="/admin/accounts" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is('admin/accounts') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="font-medium">Accounts</span>
                    </a>
                    
                    <a href="/admin/comments" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is('admin/comments') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span class="font-medium">Comments</span>
                    </a>
                </nav>
            </div>

            <div class="p-6 space-y-2 border-t-2 border-cream">
                <a href="/admin/beranda-settings" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300 {{ request()->is('admin/beranda-settings') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : '' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Beranda</span>
                </a>
                <a href="/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300 {{ request()->is('admin/settings') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : '' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-medium">Settings</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
                 <div class="mt-4 pt-4 border-t-2 border-cream flex items-center gap-3 px-2">
                    <div class="h-10 w-10 rounded-full bg-light-beige overflow-hidden ring-2 ring-offset-2 ring-white flex-shrink-0">
                        <img src="{{ $avatarUrl }}" alt="Admin" class="h-full w-full object-cover">
                    </div>
                    <div class="text-sm truncate">
                        <p class="font-semibold tracking-tight text-dark-brown">{{ auth()->user()?->name ?? 'Admin User' }}</p>
                        <p class="text-xs text-gray-400">Chief Curator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Top Bar -->
            <header class="h-24 px-12 flex items-center justify-between">
                <!-- Search -->
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Search the collection..." class="w-full pl-11 pr-4 py-3.5 bg-white/70 backdrop-blur-md border border-light-beige/30 rounded-3xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] text-sm focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all placeholder-gray-400 text-dark-brown" />
                </div>

                <!-- Right items -->
                <div class="flex items-center gap-6">
                    <button class="relative p-2.5 text-gray-400 bg-white rounded-full hover:text-dark-brown shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] transition-all hover:shadow-md">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-2 right-2 h-2.5 w-2.5 bg-soft-red rounded-full ring-2 ring-white"></span>
                    </button>
                    <!-- Topbar Profile with Dropdown -->
                    <div x-data="{ profileOpen: false }" class="relative hidden lg:block">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 bg-white pl-2 pr-4 py-1.5 rounded-full shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-light-beige/20 cursor-pointer hover:shadow-md transition-all">
                            <div class="h-8 w-8 rounded-full bg-light-beige overflow-hidden">
                                <img src="{{ $avatarUrl }}" alt="Admin" class="h-full w-full object-cover">
                            </div>
                            <span class="text-sm font-medium text-dark-brown">Profile</span>
                            <svg class="h-4 w-4 text-gray-400" :class="{'rotate-180': profileOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.2s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-light-beige/50 py-2 z-50" x-cloak>
                            <a href="/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cream hover:text-dark-brown transition-colors">Settings</a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-soft-red hover:bg-soft-red/5 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto px-12 pb-12 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: var(--color-light-beige);
            border-radius: 20px;
        }
    </style>
</body>
</html>
