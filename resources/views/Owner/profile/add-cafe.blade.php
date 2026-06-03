<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Cafe - Saran Kafe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'sans-serif'] },
                    colors: {
                        cream: '#F7F5F0',
                        dark: '#1B1B18',
                        muted: '#6B635A',
                        border: '#E3E3E0',
                        stat: '#F7F3EE',
                        brown: '#6B4F3B',
                        darkbrown: '#2C2720',
                        active: '#3F4C40',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream font-sans text-dark min-h-screen">

    <!-- TOP NAVBAR -->
    <nav class="flex items-center justify-between px-7 py-3.5 border-b border-border bg-cream">
        <div class="flex items-center gap-7">
            <span class="font-semibold text-sm">Sensory Editorial</span>
            <div class="flex gap-1">
                <a href="#" class="text-sm font-semibold text-dark border-b-2 border-dark pb-0.5 px-2">Branches</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-muted text-sm">🔔</button>
            <button class="text-muted text-sm">⚙️</button>
            <div class="w-8 h-8 rounded-full bg-[#D6C9BD] flex items-center justify-center text-xs font-semibold text-[#4A4037]">JS</div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="max-w-2xl mx-auto px-6 py-8">
        <form id="cafe-form" method="POST" action="{{ route('add-cafe.submit') }}" enctype="multipart/form-data">
            @csrf

            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- BACK LINK -->
            <a href="{{ url('/cafe') }}" class="text-[11px] uppercase tracking-[0.18em] text-muted flex items-center gap-1 mb-5 hover:text-dark transition-colors">
                ← {{ __('messages.back_to_branches') }}
            </a>

        <!-- PAGE TITLE -->
        <h1 class="text-3xl font-semibold text-dark mb-1">{{ __('messages.add_cafe_title') }}</h1>
        <p class="text-xs text-muted mb-8 max-w-sm">{{ __('messages.add_cafe_desc') }}</p>

        <!-- SECTION: General Information -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.general_information') }}</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                <!-- Cafe Name -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.cafe_name') }}</label>
                    <input type="text" name="name" value="{{ auth()->user()->ownerProfile->cafe_name ?? old('name') }}"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                </div>

                <!-- Brand Editorial Description -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.brand_editorial_description') }}</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted resize-none" required>{{ old('description') }}</textarea>
                </div>

                <!-- Establishment Type + Atmospheric Tag -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.establishment_type') }}</label>
                        <div class="relative">
                            <select name="type_id" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark appearance-none focus:outline-none focus:border-muted cursor-pointer" required>
                                <option value="">{{ __('messages.select_a_type') }}</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ trans()->has('messages.' . strtolower($type->type_name)) ? __('messages.' . strtolower($type->type_name)) : $type->type_name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-xs pointer-events-none">▾</span>
                        </div>
                    </div>

                    <div x-data='{ 
                        tags: @json($tags->toArray()), 
                        selectedTags: @json(old("tags", [])).map(String) 
                    }'>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5 font-semibold">
                            {{ __('messages.atmospheric_tags') }}
                        </label>

                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            @foreach($tags as $tag)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden" x-model="selectedTags" />
                                    <span
                                        :class="selectedTags.includes(String({{ $tag->id }})) ? 'bg-active text-white' : 'bg-[#E8E4DE] text-dark'"
                                        class="text-[11px] font-medium px-4 py-1.5 rounded-full transition-all duration-200 inline-block border border-transparent">
                                        {{ trans()->has('messages.' . strtolower($tag->tag_name)) ? __('messages.' . strtolower($tag->tag_name)) : $tag->tag_name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4 p-3 bg-cream rounded-xl border border-border">
                            <p class="text-[10px] text-muted uppercase tracking-wider mb-1">{{ __('messages.selected_data') }}</p>
                            <code class="text-xs text-active font-bold" x-text="selectedTags.length > 0 ? selectedTags.join(', ') : '{{ __('messages.nothing_selected') }}'"></code>
                        </div>
                    </div>

            </div>
        </section>

        <!-- SECTION: Opening Hours -->
        @php
            $defaultSchedules = old('open_time') ?: [
                ['day_range' => 'Mon - Fri', 'open_time' => '07:00', 'close_time' => '19:00'],
                ['day_range' => 'Saturday', 'open_time' => '08:00', 'close_time' => '21:00'],
                ['day_range' => 'Sunday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ];
        @endphp

        <section class="mb-8" x-data='{
            schedules: @json($defaultSchedules),
            addSchedule() {
                this.schedules.push({ day_range: "", open_time: "00:00", close_time: "00:00" });
            },
            removeSchedule(index) {
                this.schedules.splice(index, 1);
            }
        }'>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-dark">{{ __('messages.opening_hours') }}</h2>
                <button type="button" @click="addSchedule()" 
                    class="text-[11px] text-active border border-active rounded-full px-3 py-1 hover:bg-active hover:text-white transition-colors">
                    {{ __('messages.add_schedule') }}
                </button>
            </div>

            <div class="bg-white border border-border rounded-2xl overflow-hidden">
                <template x-for="(schedule, index) in schedules" :key="index">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-border last:border-b-0 group">
                        
                        <div class="w-32">
                            <input type="text" x-model="schedule.day_range" placeholder="{{ __('messages.eg_monday') }}"
                                :name="`open_time[${index}][day_range]`"
                                class="text-sm font-semibold text-dark bg-transparent border-b border-transparent focus:border-active focus:outline-none w-full" required />
                        </div>

                        <div class="flex items-center gap-3 flex-1">
                            <input type="time" x-model="schedule.open_time" 
                                :name="`open_time[${index}][open_time]`"
                                class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" required />
                            
                            <span class="text-muted text-sm">—</span>
                            
                            <input type="time" x-model="schedule.close_time" 
                                :name="`open_time[${index}][close_time]`"
                                class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" required />
                        </div>

                        <button type="button" @click="removeSchedule(index)" 
                            class="ml-4 opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </section>

        <!-- SECTION: Contact Details -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.contact_details') }}</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.phone_number') }}</label>
                        <input type="tel" name="phone_number" value="{{ old('phone_number') }}"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.email_address') }}</label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? old('email') }}"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Location & Maps -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.location_and_maps') }}</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">
                
                <!-- Search Location -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5 font-semibold">Cari Lokasi / Alamat</label>
                    <div class="flex gap-2">
                        <input type="text" id="map-search-input" placeholder="Ketik nama jalan, cafe, atau tempat..."
                            class="flex-grow bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                        <button type="button" id="btn-search-map" class="bg-active text-white text-xs font-semibold rounded-xl px-5 py-2.5 hover:bg-[#2d372e] transition-colors">
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Leaflet Map Container -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5 font-semibold">Pilih di Peta (Geser penanda / klik peta untuk menentukan koordinat)</label>
                    <div id="map" class="h-64 rounded-xl border border-border z-0"></div>
                </div>

                <!-- Hidden Coordinates Input -->
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" />
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" />

                <!-- Visual Readonly Coordinate Display -->
                <div class="bg-cream border border-border rounded-xl p-3 text-xs text-muted flex justify-around items-center">
                    <div>Latitude: <strong id="val-latitude" class="text-dark">{{ old('latitude', '-') }}</strong></div>
                    <div class="h-4 w-[1px] bg-border"></div>
                    <div>Longitude: <strong id="val-longitude" class="text-dark">{{ old('longitude', '-') }}</strong></div>
                </div>

                <!-- Cafe Rating Field -->
                <!-- <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5 font-semibold">Rating Awal Cafe</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" step="0.1" value="{{ old('rating', '4.5') }}"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                </div> -->

                <div class="mb-4">
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" required
                            class="w-full h-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($daftarDaerah as $kecamatan)
                            <option value="{{ $kecamatan->id }}">
                                {{ ucwords(strtolower($kecamatan->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Address</label>
                    <input type="text" name="address" value="{{ old('address', $cafe->address ?? '') }}"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                </div>
                
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Google Maps Link</label>
                    <input type="url" name="maps" id="maps" placeholder="https://maps.google.com/maps?q=..." value="{{ old('maps') }}"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                </div>
            </div>
        </section>

        <!-- SECTION: Photo Gallery -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.photo_gallery') }}</h2>
            <div class="bg-white border border-border rounded-2xl p-5">
                <div class="grid grid-cols-4 gap-3" id="photo-gallery">

                    <!-- Upload Area -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square border-2 border-dashed border-border flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" onclick="document.getElementById('photo-input').click()" id="photo-upload-area">
                        <span class="text-lg text-muted">⊕</span>
                        <span class="text-[10px] text-muted mt-1 uppercase tracking-wider">{{ __('messages.upload') }}</span>
                        <input type="file" name="photos[]" id="photo-input" accept="image/*" multiple style="display: none;" onchange="handlePhotoUpload(event)" />
                    </div>
                </div>
                <p class="text-[10px] text-muted mt-3">{{ __('messages.upload_multiple_images') }}</p>
            </div>
        </section>
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.thumbnail') }}</h2>
            <div class="bg-white border border-border rounded-2xl p-5">

                <div class="grid grid-cols-4 gap-3" id="thumbnail-gallery">

                    <!-- Upload Area (HARUS di dalam thumbnail-gallery) -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square border-2 border-dashed border-border flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" 
                        onclick="document.getElementById('thumbnail-input').click()" 
                        id="thumbnail-upload-area">
                        <span class="text-lg text-muted">⊕</span>
                        <span class="text-[10px] text-muted mt-1 uppercase tracking-wider">{{ __('messages.upload') }}</span>
                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" style="display: none;" onchange="handleThumbnailInput(event)" />
                    </div>

                </div> <!-- Penutup thumbnail-gallery -->
            </div> <!-- Penutup bg-white -->
        </section>

        <section class="mb-10">
        <h2 class="text-base font-semibold text-dark mb-4">{{ __('messages.featured_menu') }}</h2>
        <div class="bg-white border border-border rounded-2xl overflow-hidden" id="menu-section">

            <div id="menu-list">
                </div>

            <div id="new-menu-form" class="hidden px-5 py-4 border-b border-border space-y-3">
                <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.menu_name') }}</label>
                        <input type="text" id="menu-name" placeholder="{{ __('messages.menu_name') }}" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.description') }}</label>
                        <input type="text" id="menu-description" placeholder="{{ __('messages.description') }}" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.price_rupiah') }}</label>
                        <input type="text" id="menu-price" placeholder="Rp 35.000" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" onblur="formatPriceInput(this)" />
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-3 items-end">
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">{{ __('messages.photo') }}</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="document.getElementById('menu-image-input').click()" class="bg-[#F2EEE7] border border-border text-dark text-sm font-semibold rounded-xl px-4 py-2.5 hover:bg-stat transition-colors">{{ __('messages.upload_image') }}</button>
                            <span id="menu-image-name" class="text-[10px] text-muted">{{ __('messages.no_file_chosen') }}</span>
                        </div>
                        <input type="file" id="menu-image-input" accept="image/*" style="display: none;" onchange="handleMenuImageUpload(event)" />
                    </div>
                    <div class="col-span-12 md:col-span-8">
                        <div id="menu-image-preview" class="h-20 rounded-2xl border border-border bg-[#F7F5F0] flex items-center justify-center text-[10px] text-muted overflow-hidden">
                            {{ __('messages.preview_image_here') }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="saveMenuItem()" class="bg-darkbrown text-white text-sm font-semibold rounded-full px-5 py-3 hover:bg-[#1e1a16] transition-colors">{{ __('messages.add_menu') }}</button>
                    <button type="button" onclick="toggleNewMenuForm(false)" class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-5 py-3 hover:bg-stat transition-colors">{{ __('messages.cancel') }}</button>
                </div>
            </div>

            <div class="flex items-center justify-center px-5 py-3.5 cursor-pointer hover:bg-stat transition-colors" onclick="toggleNewMenuForm(true)">
                <span class="text-xs text-muted font-medium">{{ __('messages.add_menu_item') }}</span>
            </div>

        </div>
    </section>

    <section class='mb-10'>
                <!-- From Uiverse.io by Javierrocadev --> 
        <label class="relative inline-flex items-center cursor-pointer">
            <input class="sr-only peer" value="1" type="checkbox" name="is_published">
            <div class="group peer ring-0 bg-gray-50 border-2 border-amber-900 rounded-full outline-none duration-700 after:duration-200 w-14 h-7  shadow-md peer-checked:bg-[#6B4F3B]  peer-focus:outline-none after:content-[''] after:rounded-full after:absolute after:bg-amber-900 after:outline-none after:h-5 after:w-5 after:top-1 after:left-1  peer-checked:after:translate-x-7 peer-hover:after:scale-95">

                <svg y="0" xmlns="http://www.w3.org/2000/svg" x="0" width="100" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet" height="100" class="absolute  top-1 left-1 fill-green-400 w-5 h-5">
                <path d="M50,18A19.9,19.9,0,0,0,30,38v8a8,8,0,0,0-8,8V74a8,8,0,0,0,8,8H70a8,8,0,0,0,8-8V54a8,8,0,0,0-8-8H38V38a12,12,0,0,1,23.6-3,4,4,0,1,0,7.8-2A2₀.₁,2₀.₁,0,₀,₀,5₀,₁₈Z" class="svg-fill-primary">
                </path>
                </svg>

                <svg y="0" xmlns="http://www.w3.org/2000/svg" x="0" width="100" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet" height="100" class="absolute top-1 left-8 fill-red-600 w-5 h-5">
                <path fill-rule="evenodd" d="M30,46V38a20,20,0,0,1,40,0v8a8,8,0,0,1,8,8V74a8,8,0,0,1-8,8H30a8,8,0,0,1-8-8V54A8,8,0,0,1,30,46Zm32-8v8H38V38a12,12,0,0,1,24,0Z">
                </path>
                </svg>
            </div>
                <span class="ml-3 text-sm font-medium text-[#1B1B18] font-semibold" >Publish</span>
        </label>
    </section>

        <!-- BOTTOM ACTIONS -->
        <div class="flex items-center gap-3 pb-10">
            <button type="submit" class="flex-1 bg-darkbrown text-white text-sm font-semibold rounded-full py-3.5 hover:bg-[#1e1a16] transition-colors">
                {{ __('messages.publish_changes') }}
            </button>
            <button type="reset" class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-8 py-3.5 hover:bg-stat transition-colors">
                {{ __('messages.discard') }}
            </button>
        </div>
        </form>

    </div>

    <script>
        function handlePhotoUpload(event) {
            const files = Array.from(event.target.files);
            const gallery = document.getElementById('photo-gallery');
            const uploadArea = document.getElementById('photo-upload-area');
            const currentPhotos = gallery.querySelectorAll('[class*="group"]').length - 1; // Exclude upload area
            
            // Limit to 12 photos total
            if (currentPhotos + files.length > 12) {
                alert('Maximum 12 photos allowed. You already have ' + currentPhotos + ' photos.');
                return;
            }

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'relative group rounded-xl overflow-hidden aspect-square';
                    photoDiv.innerHTML = `
                        <img src="${e.target.result}" alt="cafe photo" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    `;
                    gallery.insertBefore(photoDiv, uploadArea.nextSibling);
                };
                reader.readAsDataURL(file);
            });
        }

        function handleThumbnailInput(event) {
            const files = Array.from(event.target.files);
            const gallery = document.getElementById('thumbnail-gallery');
            const uploadArea = document.getElementById('thumbnail-upload-area');
            const currentPhotos = gallery.querySelectorAll('[class*="group"]').length - 1; // Exclude upload area
            
            // Limit to 12 photos total
            if (currentPhotos + files.length > 1) {
                alert('Maximum 1 photos allowed. You already have ' + currentPhotos + ' photos.');
                return;
            }

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'relative group rounded-xl overflow-hidden aspect-square';
                    photoDiv.innerHTML = `
                        <img src="${e.target.result}" alt="cafe photo" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    `;
                    gallery.insertBefore(photoDiv, uploadArea.nextSibling);
                };
                reader.readAsDataURL(file);
            });
        }

        function removePhoto(button) {
            button.closest('.relative').remove();
        }

        // Variabel global untuk menyimpan file gambar menu asli (agar bisa dikirim ke server)
        let menuImages = [];

        function toggleNewMenuForm(show) {
            const form = document.getElementById('new-menu-form');
            if (show) {
                form.classList.remove('hidden');
                document.getElementById('menu-name').focus();
            } else {
                form.classList.add('hidden');
                clearNewMenuFields();
            }
        }

        function clearNewMenuFields() {
            document.getElementById('menu-name').value = '';
            document.getElementById('menu-description').value = '';
            document.getElementById('menu-price').value = '';
            document.getElementById('menu-image-input').value = '';
            document.getElementById('menu-image-name').textContent = '{{ __("messages.no_file_chosen") }}';
            const preview = document.getElementById('menu-image-preview');
            preview.innerHTML = '{{ __("messages.preview_image_here") }}';
            delete preview.dataset.image;
        }

        function formatPriceInput(input) {
            input.value = formatRupiah(input.value);
        }

        function formatRupiah(value) {
            const angka = value.replace(/[^0-9]/g, '');
            if (!angka) return '';
            return 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function handleMenuImageUpload(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('menu-image-preview');
            const fileName = document.getElementById('menu-image-name');
            
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.innerHTML = `<img src="${escapeHtml(e.target.result)}" alt="menu preview" class="w-full h-full object-cover" />`;
                preview.dataset.image = e.target.result;
                fileName.textContent = file.name;
            };
            reader.readAsDataURL(file);
        }

        // FUNGSI UTAMA UNTUK MENYIMPAN MENU KE DAFTAR DAN MENAMBAHKAN INPUT HIDDEN
        function saveMenuItem() {
            const nameInput = document.getElementById('menu-name');
            const descInput = document.getElementById('menu-description');
            const priceInput = document.getElementById('menu-price');
            const imageInput = document.getElementById('menu-image-input');

            const name = nameInput.value.trim();
            const description = descInput.value.trim();
            const rawPrice = priceInput.value.replace(/[^0-9]/g, '');
            const priceFormatted = formatRupiah(priceInput.value.trim());

            const imagePreview = document.getElementById('menu-image-preview');
            const imageData = imagePreview.dataset.image || '';

            if (!name) {
                alert('Masukkan nama menu terlebih dahulu.');
                nameInput.focus();
                return;
            }
            if (!rawPrice) {
                alert('Masukkan harga menu.');
                priceInput.focus();
                return;
            }

            const menuList = document.getElementById('menu-list');
            const index = menuList.getElementsByClassName('menu-item').length;

            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item flex items-center justify-between px-5 py-4 border-b border-border';
            menuItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl overflow-hidden ${imageData ? '' : 'bg-[#f5f1ec] flex items-center justify-center text-xs text-muted'}">
                        ${imageData ? `<img src="${escapeHtml(imageData)}" alt="menu image" class="w-full h-full object-cover" />` : 'IMG'}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-dark">${escapeHtml(name)}</p>
                        <p class="text-xs text-muted">${escapeHtml(description)}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="menu-price text-sm font-semibold text-dark">${escapeHtml(priceFormatted)}</span>
                    <button type="button" class="text-muted hover:text-red-500 transition-colors text-sm" onclick="removeMenuItem(this, ${index})">✕</button>
                </div>

                <input type="hidden" name="menu_items[${index}][name]" value="${escapeHtml(name)}">
                <input type="hidden" name="menu_items[${index}][description]" value="${escapeHtml(description)}">
                <input type="hidden" name="menu_items[${index}][price]" value="${escapeHtml(rawPrice)}">
            `;

            if (imageInput.files[0]) {
                const hiddenFileInput = document.createElement('input');
                hiddenFileInput.type = 'file';
                hiddenFileInput.style.display = 'none';
                hiddenFileInput.name = `menu_items[${index}][image]`;
                hiddenFileInput.id = `hidden-file-${index}`;

                const dt = new DataTransfer();
                dt.items.add(imageInput.files[0]);
                hiddenFileInput.files = dt.files;

                menuItem.appendChild(hiddenFileInput);
            }

            menuList.appendChild(menuItem);
            toggleNewMenuForm(false);
            clearNewMenuFields();
        }

        function removeMenuItem(button, index) {
            const menuItem = button.closest('.menu-item');
            if (menuItem) {
                menuItem.remove();
                reindexMenuItems(); // Urutkan kembali indeks agar tidak terputus
            }
        }

        // Fungsi untuk merapikan kembali nomor indeks array input setelah ada yang dihapus
        function reindexMenuItems() {
            const items = document.querySelectorAll('#menu-list .menu-item');
            items.forEach((item, newIndex) => {
                item.querySelector(`input[name*="[name]"]`).name = `menu_items[${newIndex}][name]`;
                item.querySelector(`input[name*="[description]"]`).name = `menu_items[${newIndex}][description]`;
                item.querySelector(`input[name*="[price]"]`).name = `menu_items[${newIndex}][price]`;
                
                const fileInput = item.querySelector(`input[type="file"]`);
                if (fileInput) {
                    fileInput.name = `menu_items[${newIndex}][image]`;
                    fileInput.id = `hidden-file-${newIndex}`;
                }

                // Perbarui parameter di tombol hapus
                const removeBtn = item.querySelector('button[onclick^="removeMenuItem"]');
                removeBtn.setAttribute('onclick', `removeMenuItem(this, ${newIndex})`);
            });
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Leaflet Map Initialization and Geocoding Logic
        document.addEventListener('DOMContentLoaded', function() {
            let initialLat = -7.983908;
            let initialLng = 112.621391;
            
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const mapsInput = document.getElementById('maps');
            
            const oldLat = latInput.value;
            const oldLng = lngInput.value;
            if (oldLat && oldLng) {
                initialLat = parseFloat(oldLat);
                initialLng = parseFloat(oldLng);
            }

            const map = L.map('map').setView([initialLat, initialLng], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                const latLng = marker.getLatLng();
                updateInputs(latLng.lat, latLng.lng);
            });

            // Update coordinates when map is clicked
            map.on('click', function(e) {
                const latLng = e.latlng;
                marker.setLatLng(latLng);
                updateInputs(latLng.lat, latLng.lng);
            });

            function updateInputs(lat, lng) {
                // Update hidden inputs
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
                mapsInput.value = `https://www.google.com/maps?q=${lat.toFixed(8)},${lng.toFixed(8)}`;
                // Update visual display
                const valLat = document.getElementById('val-latitude');
                const valLng = document.getElementById('val-longitude');
                if (valLat) valLat.textContent = lat.toFixed(6);
                if (valLng) valLng.textContent = lng.toFixed(6);
            }

            // Validate that coordinates are set before form submit
            const cafeForm = document.getElementById('cafe-form');
            if (cafeForm) {
                cafeForm.addEventListener('submit', function(e) {
                    if (!latInput.value || !lngInput.value) {
                        e.preventDefault();
                        const coordBox = document.getElementById('val-latitude');
                        if (coordBox) {
                            coordBox.closest('.bg-cream').style.borderColor = '#ef4444';
                            coordBox.closest('.bg-cream').style.boxShadow = '0 0 0 2px #fee2e2';
                        }
                        alert('⚠️ Harap klik atau geser penanda di peta terlebih dahulu untuk menentukan lokasi kafe.');
                        document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return false;
                    }
                });
            }

            // Geocode Kecamatan when selected
            // const kecamatanSelect = document.getElementById('kecamatan');
            // kecamatanSelect.addEventListener('change', function() {
            //     const selectedOption = this.options[this.selectedIndex];
            //     if (selectedOption && selectedOption.value) {
            //         const kecamatanName = selectedOption.text.trim();
            //         const query = `Kecamatan ${kecamatanName}, Malang, Jawa Timur, Indonesia`;
            //         geocodeAddress(query);
            //     }
            // });

            // Geocode Search Input
            const btnSearch = document.getElementById('btn-search-map');
            const searchInput = document.getElementById('map-search-input');
            btnSearch.addEventListener('click', function() {
                const query = searchInput.value.trim();
                if (query) {
                    let fullQuery = query;
                    if (!query.toLowerCase().includes('malang')) {
                        fullQuery += ', Malang, Jawa Timur, Indonesia';
                    }
                    geocodeAddress(fullQuery);
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    btnSearch.click();
                }
            });

            function geocodeAddress(query) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 14);
                            marker.setLatLng([lat, lon]);
                            updateInputs(lat, lon);
                        } else {
                            alert('Lokasi tidak ditemukan. Coba cari dengan kata kunci lain.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal mencari lokasi. Pastikan koneksi internet aktif.');
                    });
            }
        });
    </script>

</body>
</html>