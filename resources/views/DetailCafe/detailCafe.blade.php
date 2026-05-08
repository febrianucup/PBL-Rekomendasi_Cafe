<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$cafe->name</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/addcoment.js')

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-[#FDFBF7] text-[#333]">

    <nav class="flex justify-between items-center px-8 py-6 w-100">
        <div class="text-xl font-bold italic">SAFE</div>
        <div class="flex gap-6 text-sm font-semibold">
            {{-- <a href="#">Journals</a> --}}
            <a href="#" class="border-b-2 border-black">Cafés</a>
            {{-- <a href="#">Roasters</a>
            <a href="#">Curated Sets</a> --}}
        </div>
    </nav>
    @php
        $slides = $cafe->photos && $cafe->photos->isNotEmpty() 
            ? $cafe->photos->map(fn($photo) => str_starts_with($photo->photo_url, 'http') 
                ? $photo->photo_url 
                : asset('storage/' . $photo->photo_url))->toArray()
            : ['https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'];
    @endphp

    <div class="w-full max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <header class="relative w-full h-[500px] overflow-hidden rounded-xl group"
            x-data='{ 
                activeSlide: 0,
                slides: @json($slides),
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
            <div class="absolute bottom-10 left-10 md:left-16 text-white z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="bg-[#D4A373] text-[10px] font-bold tracking-wider uppercase px-2.5 py-1 rounded">
                        Cafe Profile
                    </span>
                    <span class="flex items-center gap-1 text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.784 1.399 8.165-7.333-3.856-7.333 3.856 1.399-8.165-5.934-5.784 8.2-1.192zm0 5.701l-2.023 4.101-4.526.658 3.275 3.192-.772 4.507 4.046-2.126 4.046 2.126-.772-4.507 3.275-3.192-4.526-.658z"/>
                        </svg>
                        {{ $cafe->rating ?? '4.8' }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold tracking-tight">{{ $cafe->name }}</h1>
                <p class="mt-2 text-sm md:text-lg text-white/90 max-w-2xl leading-relaxed">{{ $cafe->address }}</p>
            </div>

            <template x-if="slides.length > 1">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" type="button"
                            :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </template>
        </header>
    </div>

    <main class="max-w-4xl mx-auto py-16 px-4">
        <section class="text-center mb-16 max-w-3xl mx-auto px-4">
            <span class="text-xs font-bold tracking-widest text-[#D4A373] uppercase block mb-2">Vibe & Features</span>
            
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight mb-5">The Atmosphere</h2>
            
            <p class="text-base md:text-lg leading-relaxed text-gray-600 font-normal mb-8">
                {{ $cafe->description ?? 'No description available for this cafe.' }}
            </p>

            <div class="w-16 h-[2px] bg-gray-200 mx-auto mb-8"></div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6">
                
                <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-100 rounded-full shadow-sm transition-all duration-300 hover:bg-gray-100">
                    <span class="w-2 h-2 rounded-full bg-[#D4A373]"></span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 mr-1">Type:</span>
                    <span class="text-sm font-bold text-gray-700">{{ $cafe->type->name ?? 'Standard Cafe' }}</span>
                </div>

                <div class="flex flex-wrap justify-center gap-2">
                    @if($cafe->tags && $cafe->tags->isNotEmpty())
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
        <section class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <p class="text-center text-sm uppercase tracking-widest text-gray-400">Lokasi & Kontak</p>
            <h3 class="text-center text-2xl mt-2 mb-6">{{ $cafe->address }}</h3>
            <div class="w-full h-80 bg-gray-800 rounded-lg mb-6" 
                id="map"
                data-lat="{{ $cafe->latitude }}"
                data-lng="{{ $cafe->longitude }}"
                data-name="{{ $cafe->name }}"
                data-address="{{ $cafe->address }}">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center border-t border-b py-6">
                <div>
                    <h4 class="font-bold text-sm text-gray-500 uppercase">Contact</h4>
                    <p class="mt-2 text-gray-800">{{ $cafe->num_phone }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-gray-500 uppercase">Email</h4>
                    <p class="mt-2 text-gray-800">{{ $cafe->email }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-gray-500 uppercase mb-2">Opening Hours</h4>
                    
                    @if($cafe->operationalTime && $cafe->operationalTime->count() > 0)
                        <ul class="space-y-1">
                            @foreach ($cafe->operationalTime as $time)
                                <li class="flex items-center justify-evenly text-sm text-gray-600 max-w-xs">
                                    <span class="font-medium w-1/2">{{ $time->day_range }}</span>
                                    <span>:</span>
                                    <span class="text-gray-500">
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

            <div class="text-center border-t border-b py-6 mb-6">
                <h4 class="font-bold text-sm text-gray-500 uppercase">Address</h4>
                <p class="mt-2 text-gray-800">{{ $cafe->address }}</p>
            </div>

            <div class="flex justify-between items-center">
                 <a href="{{ $cafe->maps_link }}" class="bg-black text-white px-5 py-3 uppercase text-xs font-bold rounded-lg w-full text-center" target="_blank" rel="noopener">View in Gmaps</a>
            </div>
        </section>

        <section class="mt-16">
            <h2 class="text-3xl text-center mb-8">Menu List</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if ($cafe->menuItems && $cafe->menuItems->count() > 0)
                    @foreach ($cafe->menuItems as $menu)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                            <div> 
                                <img src="{{ $cafe->menuItems ? asset('storage/'.$menu->img_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=80' }}" alt="{{ $cafe->name }}" class="w-48 rounded-xl mr-6">
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">{{ $menu->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $menu->description }}</p>
                                <span class="font-bold text-[#D4A373]">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 text-center py-8 text-gray-500">
                        Belum ada menu yang tersedia.
                    </div>
                @endif
            </div>
        </section>

        <section class="mt-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl">Colomn Comment</h2>
                <button id="btn-add-comment" class="text-sm underline">Add Comment</button>
            </div>
                <div id="comment-form-container" class="hidden mb-12 bg-white p-6 rounded-xl border border-gray-200">
                    <textarea class="w-full p-3 border rounded-lg outline-none focus:ring-1 focus:ring-[#D4A373]" rows="3" placeholder="Write comment..."></textarea>
                    <div class="flex justify-end mt-2">
                        <button id="btn-close-comment" class="mr-4 text-sm text-gray-500">Cancel</button>
                        <button class="bg-black text-white px-4 py-2 rounded text-sm">Post</button>
                    </div>
                </div>

            <div class="mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-300"></div>
                    <div class="flex-1">
                        <p class="font-bold">Muhammad Dwi Febrian <span class="text-xs font-normal text-gray-500">• 3D AGO</span></p>
                        <p class="text-gray-700 mt-1">Tempat ini sangat minimalis dan nyaman untuk work from cafe ataupun nongkrong santai dengan teman-teman, menu nya juga banyak dan enak</p>
                        <div class="mt-2">
                            <button class="text-sm text-gray-500 font-semibold hover:text-black">Reply</button>
                        </div>
                        
                        <!-- Reply Comment Form Placeholder -->
                        <div class="hidden mt-3" id="reply-form-1">
                            <textarea class="w-full border border-gray-300 rounded p-2 text-sm" rows="2" placeholder="Write a reply..."></textarea>
                            <button class="mt-2 bg-black text-white px-3 py-1 text-xs rounded">Send Reply</button>
                        </div>

                        <div class="mt-3 bg-gray-50 p-4 rounded-lg border-l-4 border-[#D4A373]">
                            <p class="font-bold text-sm">KING BARCA<span class="text-xs font-normal text-gray-500">• 1D AGO</span></p>
                            <p class="text-sm text-gray-600">Iya lagi, baru kemarin gw kesana emang enak banget tempatnya apalagi buat gw yang lagi fokus skripsian dan sterss BARCA kalah di UCL</p>
                            <div class="mt-2">
                                <button class="text-xs text-gray-500 font-semibold hover:text-black">Reply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // Simple script to toggle reply form visibility for frontend demonstration
                document.querySelectorAll('button.text-gray-500').forEach(button => {
                    button.addEventListener('click', function() {
                        if(this.textContent === 'Reply') {
                            let form = this.parentElement.nextElementSibling;
                            if(form && form.tagName === 'DIV' && form.querySelector('textarea')) {
                                form.classList.toggle('hidden');
                            }
                        }
                    });
                });
            </script>
        </section>
    </main>
    @vite('resources/js/map.js')
</body>

</html>