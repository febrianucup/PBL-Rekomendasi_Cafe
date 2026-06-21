@extends('layouts.public')

@section('title', 'Cafe List')
@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-20 relative">
        <!-- Modern Decorative Background Blobs -->
        <div class="absolute top-10 left-10 w-96 h-96 bg-amber-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0 hidden lg:block pointer-events-none"></div>
        <div class="absolute bottom-10 right-[30%] w-80 h-80 bg-orange-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0 hidden lg:block pointer-events-none"></div>
        
        <div class="flex flex-col lg:flex-row gap-12 items-center relative z-10">
            
            <!-- Text Content (Left Side) -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 lg:pr-12 text-center lg:text-left py-8 lg:py-0">
                
                <div class="inline-flex items-center justify-center lg:justify-start gap-2 mb-6">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-widest uppercase text-amber-600">{{ __('messages.best_recommendation') }}</span>
                </div>

                <h1 class="serif-title text-6xl md:text-7xl font-extrabold mb-4 tracking-[0.05em] text-[#3E2723] leading-tight" style="font-family: 'Playfair Display', serif;">
                    SAFE<span class="text-amber-500">.</span><br>
                    <span class="block text-xl md:text-2xl font-medium tracking-[0.3em] uppercase not-italic mt-2 text-[#5D4037]">
                        {{ __('messages.cafe_suggestions') }}
                    </span>
                </h1>
                
                <div class="h-1.5 w-20 bg-amber-500 rounded-full mb-8 mx-auto lg:mx-0"></div>

                <h2 class="text-2xl md:text-3xl font-bold mb-4 text-gray-800">{{ $setting->title ?? 'Temukan Kenyamanan di Setiap Seduhan' }}</h2>
                
                <p class="text-gray-500 text-base md:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0 mb-8">
                    {{ $setting->description ?? 'Jelajahi berbagai pilihan cafe terbaik dengan suasana nyaman, kopi nikmat, dan promo menarik di sekitar Anda. Jangan lewatkan penawaran spesial setiap harinya.' }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-10">
                    <a href="{{ request()->fullUrlWithQuery(['tag' => 'promo']) }}" class="px-8 py-3.5 bg-white border border-gray-200 text-[#3E2723] hover:border-amber-500 hover:text-amber-600 text-sm font-bold uppercase tracking-widest rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                        {{ __('messages.see_promo') }}
                    </a>
                </div>
                
                <div class="flex items-center justify-center lg:justify-start gap-8 pt-6 border-t border-gray-200/60">
                    <div class="text-center lg:text-left">
                        <p class="text-2xl font-extrabold text-[#3E2723]">{{ \App\Models\Cafes::where('published', true)->count() }}+</p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold mt-1">{{ __('messages.registered_cafes') }}</p>
                    </div>
                    <div class="w-[1px] h-10 bg-gray-200"></div>
                    <div class="text-center lg:text-left">
                        <p class="text-2xl font-extrabold text-[#3E2723]">{{ number_format(\App\Models\Cafes::where('published', true)->avg('rating') ?? 4.5, 1) }}<span class="text-amber-500 text-lg ml-1">★</span></p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold mt-1">{{ __('messages.average_rating') }}</p>
                    </div>
                    <div class="w-[1px] h-10 bg-gray-200 hidden sm:block"></div>
                    <div class="text-center lg:text-left hidden sm:block">
                        <p class="text-2xl font-extrabold text-[#3E2723]">100%</p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold mt-1">{{ __('messages.trusted') }}</p>
                    </div>
                </div>
            </div>

            <!-- Slider (Right Side) -->
            <div class="w-full lg:w-1/2 relative perspective-1000 group/slider-container">
                <!-- Aesthetic Frame Behind Slider -->
                <div class="absolute inset-0 bg-gradient-to-tr from-amber-400 to-orange-500 rounded-[2.5rem] transform rotate-3 scale-100 opacity-20 transition-all duration-700 group-hover/slider-container:rotate-6 group-hover/slider-container:scale-105 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-bl from-[#3E2723] to-[#5D4037] rounded-[2.5rem] transform -rotate-2 scale-100 opacity-10 transition-all duration-700 group-hover/slider-container:-rotate-4 group-hover/slider-container:scale-105 z-0"></div>

                @php
                    $sliderData = [];
                    if(isset($promoCafes) && $promoCafes->count() > 0) {
                        foreach($promoCafes as $cafe_item) {
                            $image = $cafe_item->thumbnail ? asset('storage/'.$cafe_item->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80';
                            $rating = $cafe_item->ratings_avg_rating_score ? number_format($cafe_item->ratings_avg_rating_score, 1) : __('messages.new_status');
                            $sliderData[] = [
                                'image' => $image,
                                'link' => route('cafes.show', $cafe_item->id),
                                'name' => $cafe_item->name,
                                'rating' => $rating,
                                'address' => $cafe_item->address
                            ];
                        }
                    } else {
                        $sliderData = [
                            [
                                'image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80',
                                'link' => '#',
                                'name' => __('messages.explore_great_cafes'),
                                'rating' => '-',
                                'address' => __('messages.find_best_coffee')
                            ]
                        ];
                    }
                @endphp
                
                <section class="w-full h-[400px] md:h-[500px] lg:h-[550px] bg-gray-200 relative group overflow-hidden rounded-[2.5rem] shadow-2xl border-4 border-white/40 backdrop-blur-sm z-10"
                    x-data='{ 
                        activeSlide: 0,
                        slides: @json($sliderData),
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
                                }, 5000); 
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
                                x-transition:enter="transition ease-out duration-1000"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-1000"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute inset-0 w-full h-full">
                                <a :href="slide.link" class="block w-full h-full relative group/link">
                                    <img :src="slide.image" :alt="slide.name" class="w-full h-full object-cover transition-transform duration-[15s] group-hover/link:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#2d1e13]/90 via-black/40 to-transparent z-10"></div>
                                    
                                    <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 z-20 text-white transform translate-y-4 group-hover/link:translate-y-0 transition-transform duration-500">
                                        <div class="flex gap-2 mb-3">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/90 backdrop-blur-sm text-white rounded-full text-xs font-bold shadow-lg border border-amber-400/50">
                                                <span>★</span> <span x-text="slide.rating"></span>
                                            </div>
                                            <div class="inline-flex items-center gap-1 px-3 py-1 bg-red-600/95 backdrop-blur-sm text-white rounded-full text-xs font-bold shadow-lg border border-red-500/50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <span class="uppercase tracking-wider">{{ __('messages.promo') }}</span>
                                            </div>
                                        </div>
                                        <h2 class="serif-title text-3xl md:text-4xl font-extrabold mb-2 tracking-tight text-white drop-shadow-md" style="font-family: 'Playfair Display', serif;" x-text="slide.name"></h2>
                                        <p class="text-sm md:text-base text-white/90 max-w-md font-light drop-shadow-sm flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <span x-text="slide.address" class="line-clamp-1"></span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>

                    <template x-if="slides.length > 1">
                        <div class="absolute bottom-6 right-6 flex gap-2.5 z-20">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="activeSlide = index; resetAutoplay()" type="button"
                                    :class="activeSlide === index ? 'bg-amber-500 w-8' : 'bg-white/50 w-2.5 hover:bg-white/80'"
                                    class="h-2.5 rounded-full transition-all duration-300 shadow-sm"></button>
                            </template>
                        </div>
                    </template>
                </section>
            </div>

        </div>
    </div>

    <main class="flex-grow w-full mx-auto px-6 py-12 flex flex-col">
        <div class="flex justify-center space-x-6 md:space-x-8 text-xs font-semibold uppercase tracking-widest mb-10 border-b border-gray-200 pb-4 overflow-x-auto whitespace-nowrap">
            <a href="{{ request()->fullUrlWithQuery(['tag' => null]) }}" class="{{ !request('tag') ? 'border-b-2 border-black text-black' : 'text-gray-500 hover:text-gray-700' }} pb-4 cursor-pointer transition-colors">
                {{ __('messages.all_cafes') }}
            </a>
            @if(isset($tags) && $tags->isNotEmpty())
                @foreach($tags as $tag)
                    <a href="{{ request()->fullUrlWithQuery(['tag' => $tag->tag_name]) }}" class="{{ request('tag') == $tag->tag_name ? 'border-b-2 border-black text-black' : 'text-gray-500 hover:text-gray-700' }} pb-4 cursor-pointer transition-colors">
                       #{{ trans()->has('messages.' . strtolower($tag->tag_name)) ? __('messages.' . strtolower($tag->tag_name)) : $tag->tag_name }}
                    </a>
                @endforeach
            @else
                <span class="text-gray-400 italic">{{ __('messages.no_tags') }}</span>
            @endif
        </div>
        <h2 class="text-lg font-bold text-gray-800 font-sans">
                @if(request('sort_by_distance') == 'true')
                    {{ __('messages.nearest_cafes') }}
                @elseif(request('sort_by_rating') == 'true')
                    {{ __('messages.sort_by_rating_title') }}
                @elseif(request('sort_by_views') == 'true')
                    {{ __('messages.most_views_title') }}
                @else
                    {{ __('messages.all_recommendations') }}
                @endif
            </h2>
        <div class="flex justify-end mb-6 mr-6">
            <div class="relative inline-block text-left" 
                x-data="{ open: false }" 
                @click.away="open = false">
                
                <button type="button" 
                        @click="open = !open"
                        class="flex items-center gap-2 px-5 py-2.5 list-none cursor-pointer border border-gray-300 px-3 py-2 rounded-md text-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m11.25-3v10.5m0 0l-3.75-3.75m3.75 3.75l3.75-3.75" />
                    </svg>
                    <span>
                        @if(request('sort_by_distance') == 'true')
                            {{ __('messages.nearest') }}
                        @elseif(request('sort_by_rating') == 'true')
                            {{ __('messages.rating') }}
                        @elseif(request('sort_by_views') == 'true')
                            {{ __('messages.views_most') }}
                        @else
                            {{ __('messages.filter') }}
                        @endif
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" 
                        class="w-3 h-3 ml-1 transition-transform duration-300"
                        :class="{ 'rotate-180': open }">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
 
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute left-0 mt-2 w-36 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto z-50"
                    style="display: none;"> <div class="py-1">
                        <button id="btn-nearest" 
                                @click="open = false"
                                class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-xs font-medium transition-colors hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            {{ __('messages.nearest') }}
                        </button>
 
                        <a href="{{ request()->fullUrlWithQuery(['sort_by_rating' => request('sort_by_rating') == 'true' ? null : 'true', 'sort_by_distance' => null, 'latitude' => null, 'longitude' => null, 'sort_by_views' => null]) }}"
                        @click="open = false"
                        class="flex items-center gap-2 px-4 py-2.5 text-xs font-medium transition-colors hover:bg-gray-100">
                            <span>★</span> {{ __('messages.rating_highest') }}
                        </a>
 
                        <a href="{{ request()->fullUrlWithQuery(['sort_by_views' => request('sort_by_views') == 'true' ? null : 'true', 'sort_by_distance' => null, 'latitude' => null, 'longitude' => null, 'sort_by_rating' => null]) }}"
                        @click="open = false"
                        class="flex items-center gap-2 px-4 py-2.5 text-xs font-medium transition-colors hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            {{ __('messages.views_most') }}
                        </a>
                        @if(request('sort_by_distance') || request('sort_by_rating') || request('sort_by_views'))
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ request()->fullUrlWithQuery(['sort_by_rating' => null, 'sort_by_distance' => null, 'latitude' => null, 'longitude' => null, 'sort_by_views' => null]) }}"
                            @click="open = false"
                            class="flex items-center justify-center py-2 text-[11px] font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                {{ __('messages.clear_filter') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 content-start flex-grow">
            @forelse($cafe as $cafes)
                <div class="group">
                    <a href="{{ route('cafes.show', $cafes->id) }}" class="block bg-white rounded-[2rem] p-3 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="aspect-[4/3] bg-gray-200 mb-4 overflow-hidden rounded-[1.5rem] shadow-inner relative group-hover:shadow-md transition-all duration-300">
                            <img src="{{ $cafes->thumbnail ? asset('storage/'.$cafes->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=80' }}"
                                alt="{{ $cafes->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                            
                            <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1 border border-white/20">
                                <span class="text-amber-500 text-[10px] font-black">★</span>
                                <span class="text-gray-900 text-xs font-bold">{{ $cafes->ratings->avg('rating_score') ? number_format($cafes->ratings->avg('rating_score'), 1) : '-' }}</span>
                            </div>
                            
                            @if(isset($cafes->tags) && $cafes->tags->contains(function($tag) { return strtolower($tag->tag_name) === 'promo'; }))
                                <div class="absolute top-3 left-3 bg-red-600/95 backdrop-blur-md px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1 border border-red-500/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span class="text-white text-[10px] font-bold uppercase tracking-wider">{{ __('messages.promo') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col px-1">
                            <h3 class="font-extrabold text-lg text-gray-900 group-hover:text-amber-700 transition-colors leading-tight">{{ $cafes->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-1 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 shrink-0 text-gray-400">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span class="truncate">{{ $cafes->address }}</span>
                            </p>
                            
                            @if(isset($cafes->distance))
                                <p class="text-[11px] text-amber-700 font-semibold mt-2.5 flex items-center gap-1 bg-amber-50 self-start px-2.5 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-amber-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    {{ number_format($cafes->distance, 1) }} km {{ __('messages.from_you') }}
                                </p>
                            @elseif(isset($cafes->views_count))
                                <p class="text-[11px] text-indigo-700 font-semibold mt-2.5 flex items-center gap-1 bg-indigo-50 self-start px-2.5 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 text-indigo-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                   {{ $cafes->views_count }} Views
                                </p>
                            @endif
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
                        url.searchParams.delete('sort_by_rating');
                        url.searchParams.delete('sort_by_views');
                        if (navigator.geolocation) {
                            btnNearest.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg> {{ __('messages.requesting_location') }}
                            `;
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    url.searchParams.set('sort_by_distance', 'true');
                                    url.searchParams.set('latitude', position.coords.latitude);
                                    url.searchParams.set('longitude', position.coords.longitude);
                                    window.location.href = url.pathname + url.search;
                                },
                                function(error) {
                                    alert("{{ __('messages.gps_error') }}");
                                    window.location.reload();
                                }
                            );
                        } else {
                            alert("{{ __('messages.geolocation_unsupported') }}");
                        }
                    }
                });
            }
        });
        
        window.addEventListener('beforeunload', () => {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        window.addEventListener('load', () => {
            const scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
                sessionStorage.removeItem('scrollPosition');
            }
        });
    </script>
    @endpush
@endsection