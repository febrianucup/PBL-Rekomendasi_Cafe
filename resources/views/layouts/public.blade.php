<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Page') | Safe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAF9F6;
        }
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        /* header { 
            background-color: #F5F1EC; 
        } */
        [x-cloak] { 
            display: none !important; 
        }
        .leaflet-control-container {
            position: relative;
            z-index: 10;
        } 
        .rating {
            flex-direction: row-reverse;
        }
        .rating input {
            display: none;
        }
        .rating label {
            float: right;
            cursor: pointer;
            color: #ccc;
            transition: color 0.3s;
        }
        .rating label:before {
            content: '\2605';
            font-size: 70px;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffa63a;
            transition: color 0.3s;
        }
    </style>
</head>
<body class="text-gray-900 min-h-screen flex flex-col">
    
    <header class="w-full border-b border-gray-300 sticky top-0 z-[999] transition-all duration-500 ease-in-out" x-data="{isScrolled:false,mobileMenu:false}" @scroll.window="isScrolled = window.scrollY > 10" :class="isScrolled ? 'bg-[#F5F1EC]/80 backdrop-blur-xl shadow-xl' : 'bg-[#F5F1EC]'">

        <div class="mr-4 ml-4 mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between py-4 gap-4 h-20">

                <div class="font-bold text-xl tracking-wider shrink-0 mr-12">
                    SAFE
                </div>

                <nav class="hidden lg:flex items-center gap-8 text-sm uppercase tracking-widest text-gray-500">

                    <a href="/" class="hover:text-black transition {{ request()->is('/') ? 'text-black border-b border-black pb-1' : '' }}">
                        {{ __('messages.beranda') }}
                    </a>

                    @auth
                        @if(auth()->user()->role->name !== 'owner' && auth()->user()->role->name !== 'admin')
                            <a href="/favorite" class="hover:text-black transition {{ request()->is('favorite') ? 'text-black border-b border-black pb-1' : '' }}">
                                {{ __('messages.navbar_favorite') }}
                            </a>
                        @endif
                        @endauth
                    @isset($navbars)
                        @foreach($navbars as $menu)
                            @if($menu->url !== '/')
                                <a href="{{ $menu->url }}"
                                    class="hover:text-black transition {{ request()->is(trim($menu->url, '/')) ? 'text-black border-b border-black pb-1' : '' }}">
                                    {{ $menu->title }}
                                </a>
                            @endif
                        @endforeach
                    @endisset

                    <a href="/kontak"
                        class="hover:text-black transition {{ request()->is('kontak') ? 'text-black border-b border-black pb-1' : '' }}">
                        {{ __('messages.contact_us') }}
                    </a>

                </nav>

                  <div class="flex items-center gap-3 ml-auto">
                    <div class="hidden sm:flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500">

                        <a href="{{ route('lang.switch', 'en') }}"
                            class="{{ app()->getLocale() == 'en' ? 'text-black border-b border-black' : 'hover:text-black transition' }}">
                            EN
                        </a>

                        <span>|</span>

                        <a href="{{ route('lang.switch', 'id') }}"
                            class="{{ app()->getLocale() == 'id' ? 'text-black border-b border-black' : 'hover:text-black transition' }}">
                            ID
                        </a>

                    </div>

                    @if(request()->routeIs(['cafes.index', 'favorite.cafes']))

                    <div class="hidden lg:flex items-center">

                        <form action="{{ request()->routeIs('favorite.cafes') ? route('favorite.cafes') : route('cafes.index') }}" method="GET" class="flex items-center gap-2 mr-4">

                            <div class="relative">

                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="{{ __('messages.search_cafe_placeholder') }}"
                                    class="w-52 border border-gray-300 rounded-md py-2 pl-3 pr-8 bg-white text-sm focus:outline-none focus:ring-1 focus:ring-black">

                                @if(request('search'))
                                    <a href="{{ url()->current() . (request()->except('search') ? '?' . http_build_query(request()->except('search')) : '') }}"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black">
                                        ✕
                                    </a>
                                @endif

                            </div>

                            <button type="submit"
                                class="bg-black text-white px-4 py-2 rounded-md uppercase text-xs font-bold hover:bg-gray-800 transition">
                                {{ __('messages.search_btn') }}
                            </button>

                        </form>

                       <div x-data="{ open: false }" @click.away="open = false" class="relative">

                            <summary @click="open = !open" class="list-none cursor-pointer border border-gray-300 px-3 py-2 rounded-md text-sm hover:bg-gray-50">

                                @if(request('daerah'))
                                    {{ ucwords(strtolower(\Laravolt\Indonesia\Models\District::find(request('daerah'))->name ?? __('messages.navbar_kecamatan'))) }}
                                @else
                                    {{ __('messages.navbar_kecamatan') }}
                                @endif

                            </summary>

                            <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">

                                <a href="{{ request()->fullUrlWithQuery(['daerah' => null]) }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    {{ __('messages.navbar_semua_kecamatan') }}
                                </a>

                                @foreach($daftarDaerah as $kecamatan)
                                    <a href="{{ request()->fullUrlWithQuery(['daerah' => $kecamatan->id]) }}"
                                        class="block px-4 py-2 text-sm hover:bg-gray-100">
                                        {{ ucwords(strtolower($kecamatan->name)) }}
                                    </a>
                                @endforeach

                            </div>

                        </div>
 
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <summary @click="open = !open" class="list-none cursor-pointer border border-gray-300 px-3 py-2 rounded-md text-sm hover:bg-gray-50">

                                @if(request('type'))
                                    @php
                                        $selectedTypeName = \App\Models\Type::find(request('type'))->type_name ?? null;
                                    @endphp
                                    {{ $selectedTypeName ? (trans()->has('messages.' . strtolower($selectedTypeName)) ? __('messages.' . strtolower($selectedTypeName)) : $selectedTypeName) : __('messages.navbar_tipe_cafe') }}
                                @else
                                    {{ __('messages.navbar_tipe_cafe') }}
                                @endif

                            </summary>

                            <div x-show="open" x-cloak class="absolute left-0 mt-2 w-46 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">

                                <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    {{ __('messages.navbar_semua_tipe') }}
                                </a>

                                @foreach($types as $tipe)
                                    <a href="{{ request()->fullUrlWithQuery(['type' => $tipe->id]) }}"
                                        class="block px-4 py-2 text-sm hover:bg-gray-100">
                                        {{ trans()->has('messages.' . strtolower($tipe->type_name)) ? __('messages.' . strtolower($tipe->type_name)) : $tipe->type_name }}
                                    </a>
                                @endforeach

                            </div>

                        </div>

                    </div>

                    @endif

                @auth

                    <div x-data="{open:false}" @click.outside="open=false" class="relative inline-block text-left">

                        <button @click="open=!open"
                            class="flex items-center gap-2 font-bold text-sm focus:outline-none">

                            {{ \Illuminate\Support\Str::limit(auth()->user()->username ?? 'User',8,'...') }}

                            <svg class="w-4 h-4 transition-transform duration-200"
                                :class="{'rotate-180':open}"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>

                            </svg>

                        </button>

                        <div x-show="open"
                            x-cloak
                            x-transition
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden z-50">

                            <div class="py-1">

                                <span class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">
                                    Profile
                                </span>

                                @if(auth()->user()->role->name == 'owner')

                                    <a href="{{ route('owner.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Owner Dashboard
                                    </a>

                                @elseif(auth()->user()->role->name == 'admin')

                                    <a href="{{ route('admin.cafes') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Admin Dashboard
                                    </a>

                                @endif

                                <a href="{{ route('profile.settings.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Settings
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="button"
                                        x-data @click="$dispatch('open-logout-modal')"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Logout
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                    @else

                    <a href="{{ route('login') }}"
                        class="hidden sm:block border border-black text-black px-4 py-2 uppercase text-xs font-bold hover:bg-black hover:text-white transition">
                        {{ __('messages.login') }}
                    </a>

                    @endauth

                    <button @click="mobileMenu=!mobileMenu"
                        class="lg:hidden p-2 border border-gray-300 rounded-md">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                    </button>

                </div>

            </div>

            <div x-show="mobileMenu"
                x-cloak
                x-transition
                class="lg:hidden border-t border-gray-200 py-4 space-y-4">

                    <nav class="flex flex-col gap-3 text-sm uppercase tracking-widest text-gray-600">
                         <a href="/">{{ __('messages.beranda') }}</a>

                        @isset($navbars)
                            @foreach($navbars as $menu)
                                @if($menu->url !== '/')
                                    <a href="{{ $menu->url }}">
                                        {{ $menu->title }}
                                    </a>
                                @endif
                            @endforeach
                        @endisset
                        @auth
                            @if(auth()->user()->role->name !== 'owner' && auth()->user()->role->name !== 'admin')
                                <a href="/favorite">{{ __('messages.navbar_favorite') }}<a>
                            @endif
                        @endauth
                        
                        <a href="/kontak">{{ __('messages.contact_us') }}</a>
                </nav>

                          @if(request()->routeIs(['cafes.index', 'favorite.cafes']))

                <form action="{{ request()->routeIs('favorite.cafes') ? route('favorite.cafes') : route('cafes.index') }}" method="GET" class="space-y-3">

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_cafe_placeholder') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">

                    <select name="daerah"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">

                        <option value="">{{ __('messages.navbar_semua_kecamatan') }}</option>

                        @foreach($daftarDaerah as $kecamatan)
                            <option value="{{ $kecamatan->id }}"
                                {{ request('daerah') == $kecamatan->id ? 'selected' : '' }}>
                                {{ $kecamatan->name }}
                            </option>
                        @endforeach

                    </select>

                    <select name="type"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">

                        <option value="">{{ __('messages.navbar_semua_tipe') }}</option>

                        @foreach($types as $tipe)
                            <option value="{{ $tipe->id }}"
                                {{ request('type') == $tipe->id ? 'selected' : '' }}>
                                {{ trans()->has('messages.' . strtolower($tipe->type_name)) ? __('messages.' . strtolower($tipe->type_name)) : $tipe->type_name }}
                            </option>
                        @endforeach

                    </select>

                    <button type="submit"
                        class="w-full bg-black text-white py-2 rounded-md text-sm uppercase font-bold">
                        {{ __('messages.search_btn') }}
                    </button>

                </form>

                @endif

            </div>

        </div>

    </header>

    <main class="flex-grow">
        @yield('content')
    </main>
    <x-logout-modal />
    <x-footer />

    @stack('scripts')
    @livewireScripts
</body>
</html>