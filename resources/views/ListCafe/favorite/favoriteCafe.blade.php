@extends('layouts.public')

@section('title', 'Cafe List')
@section('content')
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
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800 font-sans">
                    {{ __('messages.favorite_all') }}
            </h2>
            
            {{-- <button id="btn-nearest" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-full border border-black transition-all duration-300 {{ request('sort_by_distance') == 'true' ? 'bg-black text-white hover:bg-gray-800' : 'bg-transparent text-black hover:bg-gray-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                {{ request('sort_by_distance') == 'true' ? 'Menampilkan Terdekat' : 'Urutkan Terdekat' }}
            </button> --}}
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
                                    <span class="text-white text-[10px] font-bold uppercase tracking-wider">Promo</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col px-1">
                            <h3 class="font-extrabold text-lg text-gray-900 group-hover:text-amber-700 transition-colors leading-tight">{{ $cafes->name }}</h3>
                            <div class="flex items-center gap-1 mt-1.5 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <p class="text-xs font-medium truncate">{{ $cafes->address }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 md:col-span-4 flex-grow flex flex-col items-center justify-center py-24 text-gray-400">
                    <p class="text-lg italic font-medium">{{ __('messages.no_favorite') }}</p>
                    <p class="text-xs mt-1">{{ __('messages.no_favorite_desc') }}</p>
                </div>
            @endforelse
        </div>
    </main>
{{-- 
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
    </script> --}}
    {{-- @endpush --}}
@endsection