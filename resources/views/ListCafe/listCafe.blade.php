@extends('layouts.public')

@section('title', 'Cafe List')
@section('content')
    <div class="text-center mb-6 mt-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-3 tracking-tight">{{ $setting->title ?? 'Beranda' }}</h1>
        <p class="text-gray-500 text-sm md:text-base max-w-lg mx-auto">{{ $setting->description ?? 'Deskripsi default' }}</p>
    </div>
        
        {{-- @php
            $slides = $cafe->photos && $cafe->photos->isNotEmpty() 
                ? $cafe->photos->map(fn($photo) => str_starts_with($photo->photo_url, 'http') 
                    ? $photo->photo_url 
                    : asset('storage/' . $photo->photo_url))->toArray()
                : ['https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'];
        @endphp --}}
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
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

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10"></div>
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

    <main class="flex-grow w-full mx-auto px-6 py-12 flex flex-col">
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
@endsection
