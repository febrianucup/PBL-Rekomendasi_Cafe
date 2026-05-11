<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sensory Editorial - Discovery</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAF9F6; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        header { background-color: #F5F1EC; }
        /* Menyembunyikan elemen sebelum AlpineJS termuat sempurna */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="text-gray-900 min-h-screen flex flex-col">

    <header class="w-full border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="font-bold text-xl tracking-wider">SAFE</div>
            
            <nav class="hidden md:flex space-x-8 text-sm uppercase tracking-widest text-gray-500">
                <a href="#" class="text-black border-b border-black pb-1">Beranda</a>
            </nav>
            
            <div class="flex items-center space-x-6">
                <form class="flex items-center">   
                    <label for="voice-search" class="sr-only">Search</label>
                    <input type="text" id="voice-search" class="border-b border-black py-1.5 px-3 bg-transparent text-sm focus:outline-none" placeholder="Search..." required>
                    <button type="submit" class="bg-black text-white px-4 py-2 uppercase text-xs font-bold ml-2 transition hover:bg-gray-800">Search</button>
                </form>

                @auth
                    {{-- Dropdown untuk User --}}
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
                    <a class="bg-transparent border border-black text-black px-4 py-2 uppercase text-xs font-bold hover:bg-black hover:text-white transition" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </header>

<div class="text-center mb-6 mt-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-3 tracking-tight">{{ $setting->title ?? 'Beranda' }}</h1>
            <p class="text-gray-500 text-sm md:text-base max-w-lg mx-auto">{{ $setting->description ?? 'Cari tempat ternyaman dan cafe favoritmu dengan mudah.' }}</p>
        </div>
        
        {{-- @php
            $slides = $cafe->photos && $cafe->photos->isNotEmpty() 
                ? $cafe->photos->map(fn($photo) => str_starts_with($photo->photo_url, 'http') 
                    ? $photo->photo_url 
                    : asset('storage/' . $photo->photo_url))->toArray()
                : ['https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'];
        @endphp --}}
        <div class="w-full max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $sliderImages = $setting->slider_images && count($setting->slider_images) > 0 
                    ? array_map(function($img) { return asset("storage/" . $img); }, $setting->slider_images) 
                    : [
                        "https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80",
                        "https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80",
                        "https://images.unsplash.com/photo-1468436139062-f60a71c5c892?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80"
                    ];
            @endphp
            <section class="w-full h-[550px] mb-12 bg-gray-200 relative group overflow-hidden rounded-xl"
        x-data='{ 
            activeSlide: 0,
            slides: @json($sliderImages),
            autoplayInterval:null,
            init() {
                this.startAutoplay();
            },
            next() {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            },
            prev() {
                this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
            },
            startAutoplay() {
                if (this.slides.length > 1) {
                    this.autoplayInterval = setInterval(() => {
                        this.next();
                    }, 2000); // 4000 ms = Gambar bergeser otomatis setiap 4 detik
                }
            },
            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            }
        }'>

                <div class="w-full h-full relative z-0">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                            x-transition:enter="transition ease-out duration-5000"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-5000"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute inset-0 w-full h-full">
                            <img :src="slide" alt="Cafe Image" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10"></div>

                    <template x-if="slides.length > 1">
                        <div class="absolute inset-0 flex items-center justify-between px-4 z-20">
                            <button @click="prev(); resetAutoplay()" type="button" 
                                class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-sm">
                                &#10094;
                            </button>
                            
                            <button @click="next(); resetAutoplay()" type="button" 
                                class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-sm">
                                &#10095;
                            </button>
                        </div>
                    </template>
                    <template x-if="slides.length > 1">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="activeSlide = index" type="button"
                                :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50 w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>
                </template>
            </section>
        </div>

    <main class="flex-grow w-screen max-w-7xl mx-auto px-6 py-12 flex flex-col">
        <div class="flex justify-center space-x-6 md:space-x-8 text-xs font-semibold uppercase tracking-widest mb-10 border-b border-gray-200 pb-4 overflow-x-auto whitespace-nowrap">
            <span class="border-b-2 border-black pb-4 text-black cursor-pointer">All Spaces</span>
            <span class="text-gray-400 hover:text-black cursor-pointer transition">Quiet</span>
            <span class="text-gray-400 hover:text-black cursor-pointer transition">Social</span>
            <span class="text-gray-400 hover:text-black cursor-pointer transition">Minimalist</span>
            <span class="text-gray-400 hover:text-black cursor-pointer transition">Industrial</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 content-start flex-grow">
            @forelse($cafe as $cafes)
                <div class="group">
                    <a href="{{ route('cafes.show', $cafes->id) }}" class="block">
                        <div class="aspect-[4/3] bg-gray-200 mb-3 overflow-hidden rounded-xl shadow-xs relative">
                            <img src="{{ $cafes->thumbnail ? asset('storage/'.$cafes->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=80' }}" 
                                 alt="{{ $cafes->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        </div>
                        <div class="flex justify-between items-start px-1">
                            <div>
                                <h3 class="font-bold text-base text-gray-800 group-hover:text-black transition-colors">{{ $cafes->name }}</h3>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $cafes->address }}</p>
                            </div>
                            <div class="text-xs font-bold bg-white px-2 py-1 rounded-md shadow-xs border border-gray-100 flex items-center gap-0.5">
                                <span class="text-amber-500">★</span> 4.8
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 md:col-span-3 flex-grow flex flex-col items-center justify-center py-24 text-gray-400">
                    <p class="text-lg italic font-medium">Belum ada cafe yang tersedia saat ini.</p>
                    <p class="text-xs mt-1">Silakan kembali lagi nanti untuk melihat pembaruan data.</p>
                </div>
            @endforelse
        </div>
    </main>
    
</body>
</html>