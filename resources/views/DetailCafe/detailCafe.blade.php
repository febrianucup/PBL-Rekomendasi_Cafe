@extends('layouts.public')

@section('title', ($cafe->name ?? 'Cafe Detail'))

@section('content')
@vite('resources/js/map.js')
    @php
        $slides = $cafe->photos && $cafe->photos->isNotEmpty() 
            ? $cafe->photos->map(fn($photo) => str_starts_with($photo->photo_url, 'http') 
                ? $photo->photo_url 
                : asset('storage/' . $photo->photo_url))->toArray()
            : ['https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'];
    @endphp

    <div class="w-full h-[550px] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="relative w-full h-full overflow-hidden rounded-xl group"
            x-data='{ 
                activeSlide: 0,
                slides: @json($slides),
                autoplayInterval: null,
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
                        }, 4000);
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
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 w-full h-full">
                        <img :src="slide" alt="Cafe Image" class="w-full h-full object-cover">
                    </div>
                </template>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>

            <template x-if="slides.length > 1">
                <div class="absolute inset-0 flex items-center justify-between px-4 z-20">
                    <button @click="prev(); resetAutoplay()" type="button" 
                        class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-sm text-lg">
                        &#10094;
                    </button>
                    
                    <button @click="next(); resetAutoplay()" type="button" 
                        class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-sm text-lg">
                        &#10095;
                    </button>
                </div>
            </template>

            <div class="absolute bottom-10 left-6 md:left-16 right-6 text-white z-30 pointer-events-none">
                <div class="flex items-center gap-3 mb-3">
                    <span class="bg-[#D4A373] text-[10px] font-bold tracking-wider uppercase px-2.5 py-1 rounded">
                        Cafe Profile
                    </span>
                    <span class="flex items-center gap-1 text-sm font-semibold bg-black/30 backdrop-blur-xs px-2 py-0.5 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.784 1.399 8.165-7.333-3.856-7.333 3.856 1.399-8.165-5.934-5.784 8.2-1.192zm0 5.701l-2.023 4.101-4.526.658 3.275 3.192-.772 4.507 4.046-2.126 4.046 2.126-.772-4.507 3.275-3.192-4.526-.658z"/>
                        </svg>
                        {{ $averageRating>0 ? number_format($averageRating, 1) : '-' }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-6xl font-bold tracking-tight uppercase drop-shadow-md">{{ $cafe->name }}</h1>
                <p class="mt-2 text-sm md:text-lg text-white/90 max-w-2xl leading-relaxed drop-shadow-xs">{{ $cafe->address }}</p>
                
                @php
                    $isOwner = (Auth::id() === $cafe->user_id);
                    $isAdmin = (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'admin');
                @endphp

                @if (!$isOwner && !$isAdmin)
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        @auth
                            <form action="{{ route('cafes.favorite', $cafe->id) }}" method="POST">
                                @csrf
                                <button type="submit" x-on:click.stop class="pointer-events-auto bg-white text-black px-5 py-2.5 rounded-full font-semibold text-sm transition hover:bg-[#D4A373] hover:text-white shadow-md">
                                    {{ auth()->user()->favoriteCafes->contains($cafe->id) ? '💔 Hapus dari Favorit' : '❤️ Tambah ke Favorit' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-black px-5 py-2.5 rounded-full font-semibold text-sm transition hover:bg-[#D4A373] hover:text-white shadow-md">
                                Login untuk Favorite
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>

    <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16">
        
        <section class="text-center mb-16 max-w-3xl mx-auto px-4">
            <span class="text-xs font-bold tracking-widest text-[#D4A373] uppercase block mb-2">Vibe & Features</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight mb-5">The Atmosphere</h2>
            <p class="text-base md:text-lg leading-relaxed text-gray-600 font-normal mb-8">
                {{ $cafe->description ?? 'No description available for this cafe.' }}
            </p>

            <div class="w-16 h-[2px] bg-gray-200 mx-auto mb-8"></div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6">
                <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-100 rounded-full shadow-xs transition-all duration-300 hover:bg-gray-100">
                    <span class="w-2 h-2 rounded-full bg-[#D4A373]"></span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 mr-1">Type:</span>
                    <span class="text-sm font-bold text-gray-700">#{{ $cafe->type->type_name ?? 'Standard Cafe' }}</span>
                </div>

                <div class="flex flex-wrap justify-center gap-2">
                    @if(isset($cafe->tags) && $cafe->tags->isNotEmpty())
                        @foreach($cafe->tags as $tag)
                            <span class="text-xs font-medium px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg border border-slate-200/60 shadow-xs uppercase tracking-wide hover:scale-105 transition-transform">
                                #{{ $tag->tag_name }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-xs italic text-gray-400 px-3 py-1.5 bg-gray-50 rounded-lg">
                            No specific tags
                        </span>
                    @endif
                </div>
            </div>
        </section>

        <section class="bg-white p-6 md:p-8 rounded-xl shadow-xs border border-gray-100 mb-16">
            <p class="text-center text-sm uppercase tracking-widest text-gray-400">Lokasi & Kontak</p>
            <h3 class="text-center text-xl md:text-2xl mt-2 mb-6 font-semibold text-gray-800">{{ $cafe->address }}</h3>
            
            <div class="w-full h-[400px] md:h-[500px] bg-gray-100 rounded-lg mb-8 shadow-inner border border-gray-200" 
                id="map"
                data-lat="{{ $cafe->latitude }}"
                data-lng="{{ $cafe->longitude }}"
                data-name="{{ $cafe->name }}"
                data-address="{{ $cafe->address }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-6 border-t border-b border-gray-100">
                <div class="flex flex-col items-center">
                    <h4 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Contact</h4>
                    @if($cafe->num_phone)
                        <div x-data="{ copyText: '{{ $cafe->num_phone }}', copied: false }" class="w-full max-w-[220px]">
                            <button @click="navigator.clipboard.writeText(copyText); copied = true; setTimeout(() => copied = false, 2000)" 
                                class="group flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-xl transition-all border border-gray-100 w-full">
                                <p class="text-sm font-bold text-gray-800 mb-1">{{ $cafe->num_phone }}</p>
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <template x-if="!copied">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                                            Salin Nomor
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="text-green-600 font-medium flex items-center gap-1">✓ Tersalin!</span>
                                    </template>
                                </span>
                            </button>
                        </div>
                    @else
                        <span class="text-sm text-gray-400 italic">No phone available</span>
                    @endif
                </div>

                <div class="flex flex-col items-center">
                    <h4 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Email</h4>
                    @if($cafe->email)
                        <div x-data="{ copyText: '{{ $cafe->email }}', copied: false }" class="w-full max-w-[220px]">
                            <button @click="navigator.clipboard.writeText(copyText); copied = true; setTimeout(() => copied = false, 2000)" 
                                class="group flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-xl transition-all border border-gray-100 w-full">
                                <p class="text-sm font-bold text-gray-800 mb-1 truncate w-full text-center">{{ $cafe->email }}</p>
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <template x-if="!copied">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                                            Salin Email
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="text-green-600 font-medium flex items-center gap-1">✓ Tersalin!</span>
                                    </template>
                                </span>
                            </button>
                        </div>
                    @else
                        <span class="text-sm text-gray-400 italic">No email available</span>
                    @endif
                </div>

                <div class="flex flex-col items-center">
                    <h4 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Opening Hours</h4>
                    @if($cafe->operationalTime && $cafe->operationalTime->count() > 0)
                        <ul class="space-y-1 w-full max-w-[250px]">
                            @foreach ($cafe->operationalTime as $time)
                                <li class="flex items-center justify-between text-sm text-gray-600">
                                    <span class="font-medium text-left w-20">{{ $time->day_range }}</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="text-gray-600 font-mono text-right flex-1">
                                        {{ \Carbon\Carbon::parse($time->open_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($time->close_time)->format('H:i') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-sm text-gray-400 italic">Open daily</span>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                 <a href="{{ $cafe->maps_link }}" class="block bg-black hover:bg-gray-800 text-white px-5 py-3.5 uppercase text-xs font-bold rounded-lg w-full text-center tracking-wider transition-colors" target="_blank" rel="noopener">
                    View in Google Maps
                 </a>
            </div>
        </section>

        <section class="bg-white p-6 md:p-8 rounded-xl shadow-xs border border-gray-100 mb-16">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800 mb-6">Promosi</h2>
            @if($cafe->promotions && $cafe->promotions->isNotEmpty())
                <div class="flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide">
                    @foreach($cafe->promotions as $promotion)
                        <article class="flex-none w-full md:w-[600px] snap-center rounded-[2rem] overflow-hidden border border-gray-100 shadow-lg bg-white transition-transform hover:shadow-xl">
                            @if($promotion->image_url)
                                <button type="button" @click="$dispatch('open-image', '{{ $promotion->image_url }}')" class="group block w-full relative">
                                    <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}" class="w-full h-[800px] object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                    <div class="absolute inset-x-0 bottom-0 p-6 text-white text-left">
                                        <span class="text-xs uppercase tracking-widest text-indigo-300 font-bold">Promosi</span>
                                        <h3 class="mt-2 text-2xl font-bold">{{ $promotion->title }}</h3>
                                        <h2 class="mt-1 text-sm text-gray-300 line-clamp-3">{{ $promotion->description }}</h2>
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            <span class="px-3 py-1 text-xs rounded-full bg-white/20 backdrop-blur-md">
                                                {{ $promotion->start_date?->format('d M') }} - {{ $promotion->end_date?->format('d M Y') }}
                                            </span>
                                            <span class="px-3 py-1 text-xs rounded-full font-semibold {{ now()->between($promotion->start_date, $promotion->end_date) ? 'bg-green-500/80' : 'bg-rose-500/80' }}">
                                                {{ now()->between($promotion->start_date, $promotion->end_date) ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            @endif
                        </article>
                    @endforeach
                </div>
                <p class="text-center text-xs text-gray-400 mt-2">Geser ke samping untuk melihat promosi lainnya</p>
            @else
                <div class="text-center py-16 text-gray-500 border border-dashed border-gray-200 rounded-xl bg-gray-50">
                    Belum ada promosi aktif untuk cafe ini.
                </div>
            @endif
        </section>

        <section x-data class="bg-white p-6 md:p-8 rounded-xl shadow-xs border border-gray-100 mb-16">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Menu List</h2>
            <div class="w-12 h-[3px] mx-auto mb-10"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="menu">
                @if ($cafe->menuItems && $cafe->menuItems->count() > 0)
                    @foreach ($cafe->menuItems as $menu)
                        @php
                            $imageUrl = $menu->img_url ? asset('storage/'.$menu->img_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80';
                        @endphp
                        <div class="bg-[#F5F1EC]  p-4 rounded-xl shadow-xs border border-gray-100 flex items-center hover:shadow-md transition-shadow">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100"> 
                                <img src="{{ $imageUrl }}" alt="{{ $menu->name }}" class="w-full h-full object-cover cursor-pointer" @click="$dispatch('open-image', '{{ $imageUrl }}')">
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <h4 class="font-bold text-base text-gray-800 truncate">{{ $menu->name }}</h4>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $menu->description ?? 'No description available' }}</p>
                                <div class="mt-2 text-sm font-bold text-[#D4A373]">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if (isset($menus) && $menus->hasPages())
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 mt-8">
                            {{ $menus->fragment('menu')->links() }}
                        </div>
                    @endif
                @else
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-gray-400 border border-dashed border-gray-200 rounded-xl bg-gray-50">
                        Belum ada menu yang tersedia.
                    </div>
                @endif
            </div>
        </section>
        <section x-data="{ activeTab: 'review' }" class="w-full mt-12 p-6 bg-white rounded-2xl border border-stone-100 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
            <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Review and Comment</h2>
            @auth
                <livewire:cafe-comment-section :cafeId="$cafe->id" />
            @else
                <div class="text-center py-8">
                    <p class="text-stone-600">Silakan <a href="{{ route('login') }}" class="text-blue-600 font-semibold underline">login</a> untuk memberikan komentar.</p>
                </div>
            @endauth
        </section>
        <x-image-modal />
    </main>
    {{-- @include('components.image-modal') --}}
@endsection