@extends('layouts.public')

@section('title', 'Cafe List')
@section('content')
    <div class="text-center mb-6 mt-6">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3 tracking-tight">{{ $setting->title ?? 'Beranda' }}</h1>
        <p class="text-gray-500 text-sm md:text-base max-w-lg mx-auto">{{ $setting->description ?? 'Deskripsi default' }}</p>
    </div>
        
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $sliderImages = $setting->slider_images && count($setting->slider_images) > 0 
                ? array_map(function($img) { 
                    $imagePath = is_array($img) ? ($img['image'] ?? '') : $img;
                    return asset("storage/" . $imagePath); 
                }, $setting->slider_images) 
                : [
                    "https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80",
                    "https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80",
                    "https://images.unsplash.com/photo-1468436139062-f60a71c5c892?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80"
                ];
        @endphp
        
        <section class="w-full h-[550px] mb-12 mt-8 bg-gray-200 relative group overflow-hidden rounded-xl"
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

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10"></div>

            <template x-if="slides.length > 1">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index; resetAutoplay()" type="button"
                            :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </template>
        </section>
    </div>

    <main class="flex-grow w-full mx-auto px-6 py-12 flex flex-col">
        <div class="flex justify-center space-x-6 md:space-x-8 text-xs font-semibold uppercase tracking-widest mb-10 border-b border-gray-200 pb-4 overflow-x-auto whitespace-nowrap">
            <a href="{{ request()->fullUrlWithQuery(['tag' => null]) }}" class="{{ !request('tag') ? 'border-b-2 border-black text-black' : 'text-gray-500 hover:text-gray-700' }} pb-4 cursor-pointer transition-colors">
                All Cafe
            </a>
            @if(isset($tags) && $tags->isNotEmpty())
                @foreach($tags as $tag)
                    <a href="{{ request()->fullUrlWithQuery(['tag' => $tag->tag_name]) }}" class="{{ request('tag') == $tag->tag_name ? 'border-b-2 border-black text-black' : 'text-gray-500 hover:text-gray-700' }} pb-4 cursor-pointer transition-colors">
                        {{ $tag->tag_name }}
                    </a>
                @endforeach
            @else
                <span class="text-gray-400 italic">{{ __('messages.no_tags') }}</span>
            @endif
        </div>
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800 font-sans">
                @if(request('sort_by_distance') == 'true')
                    Cafe Terdekat Dari Lokasi Anda
                @else
                    Semua Rekomendasi Cafe
                @endif
            </h2>
            
            <button id="btn-nearest" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-full border border-black transition-all duration-300 {{ request('sort_by_distance') == 'true' ? 'bg-black text-white hover:bg-gray-800' : 'bg-transparent text-black hover:bg-gray-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                {{ request('sort_by_distance') == 'true' ? 'Menampilkan Terdekat' : 'Urutkan Terdekat' }}
            </button>
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
                                @if(isset($cafes->distance))
                                    <p class="text-[11px] text-amber-800 font-semibold mt-1.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-amber-700">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        {{ number_format($cafes->distance, 1) }} km dari Anda
                                    </p>
                                @endif
                            </div>
                            <div class="text-xs font-bold bg-white px-2 py-1 rounded-md shadow-xs border border-gray-100 flex items-center gap-0.5">
                                <span class="text-amber-500">★</span>
                                <span class="text-gray-800">{{ number_format($avarangeRating ?? 4.8, 1) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 md:col-span-4 flex-grow flex flex-col items-center justify-center py-24 text-gray-400">
                    <p class="text-lg italic font-medium">{{ __('messages.no_cafe') }}</p>
                    <p class="text-xs mt-1">{{ __('messages.no_cafe_desc') }}</p>
                </div>
            @endforelse
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnNearest = document.getElementById('btn-nearest');
            if (btnNearest) {
                btnNearest.addEventListener('click', function() {
                    const url = new URL(window.location.href);
                    if (url.searchParams.get('sort_by_distance') === 'true') {
                        url.searchParams.delete('sort_by_distance');
                        url.searchParams.delete('latitude');
                        url.searchParams.delete('longitude');
                        window.location.href = url.pathname + url.search;
                    } else {
                        if (navigator.geolocation) {
                            btnNearest.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg> Meminta Lokasi...
                            `;
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    url.searchParams.set('sort_by_distance', 'true');
                                    url.searchParams.set('latitude', position.coords.latitude);
                                    url.searchParams.set('longitude', position.coords.longitude);
                                    window.location.href = url.pathname + url.search;
                                },
                                function(error) {
                                    alert('Gagal mendapatkan lokasi device Anda. Pastikan GPS aktif dan izin lokasi diberikan.');
                                    window.location.reload();
                                }
                            );
                        } else {
                            alert('Geolocation tidak didukung oleh browser Anda.');
                        }
                    }
                });
            }
        });
    </script>
    @endpush
@endsection