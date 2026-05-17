<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($cafe) ? 'Edit Cafe' : 'Add Cafe' }} - Saran Kafe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        <form method="POST" action="{{ isset($cafe) ? route('cafe.update', $cafe->id) : route('add-cafe.submit') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($cafe))
                @method('PUT')
            @endif

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
            <a href="{{ route('owner.dashboard') }}" class="text-[11px] uppercase tracking-[0.18em] text-muted flex items-center gap-1 mb-5 hover:text-dark transition-colors">
                ← BACK TO BRANCHES
            </a>

            <!-- PAGE TITLE -->
            <h1 class="text-3xl font-semibold text-dark mb-1">{{ isset($cafe) ? 'Edit Cafe' : 'Add Cafe' }}</h1>
            <p class="text-xs text-muted mb-8 max-w-sm">Refine your café's presence. Update your story, operating rhythm, and sensory offerings for your community.</p>

            <!-- SECTION: General Information -->
            <section class="mb-8">
                <h2 class="text-base font-semibold text-dark mb-4">General Information</h2>
                <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                    <!-- Cafe Name -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Cafe Name</label>
                        <input type="text" name="name" value="{{ old('name', $cafe->name ?? '') }}"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                    </div>

                    <!-- Brand Editorial Description -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Brand Editorial Description</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted resize-none" required>{{ old('description', $cafe->description ?? '') }}</textarea>
                    </div>

                    <!-- Establishment Type + Atmospheric Tag -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Establishment Type</label>
                            <div class="relative">
                                <select name="type_id" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark appearance-none focus:outline-none focus:border-muted cursor-pointer" required>
                                    <option value="">Select a type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id', $cafe->type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-xs pointer-events-none">▾</span>
                            </div>
                        </div>

                        <div x-data='{ 
                            tags: @json($tags->toArray()), 
                            selectedTags: @json(old("tags", isset($cafe) ? $cafe->tags->pluck("id")->toArray() : [])).map(String) 
                        }'>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5 font-semibold">
                                Atmospheric Tags (Multi-select)
                            </label>

                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                @foreach($tags as $tag)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden" x-model="selectedTags" />
                                        <span
                                            :class="selectedTags.includes(String({{ $tag->id }})) ? 'bg-active text-white' : 'bg-[#E8E4DE] text-dark'"
                                            class="text-[11px] font-medium px-4 py-1.5 rounded-full transition-all duration-200 inline-block border border-transparent">
                                            {{ $tag->tag_name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-4 p-3 bg-cream rounded-xl border border-border">
                                <p class="text-[10px] text-muted uppercase tracking-wider mb-1">Data Terpilih (ID):</p>
                                <code class="text-xs text-active font-bold" x-text="selectedTags.length > 0 ? selectedTags.join(', ') : 'Belum ada yang dipilih'"></code>
                            </div>
                        </div>

                </div>
            </section>

            <!-- SECTION: Opening Hours -->
            @php
                if (isset($cafe) && $cafe->operationalTime->isNotEmpty()) {
                    $defaultSchedules = $cafe->operationalTime->map(function($time) {
                        return [
                            'day_range' => $time->day_range,
                            'open_time' => $time->open_time,
                            'close_time' => $time->close_time,
                        ];
                    })->toArray();
                } else {
                    $defaultSchedules = old('open_time') ?: [
                        ['day_range' => 'Mon - Fri', 'open_time' => '07:00', 'close_time' => '19:00'],
                        ['day_range' => 'Saturday', 'open_time' => '08:00', 'close_time' => '21:00'],
                        ['day_range' => 'Sunday', 'open_time' => '09:00', 'close_time' => '17:00'],
                    ];
                }
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
                    <h2 class="text-base font-semibold text-dark">Opening Hours</h2>
                    <button type="button" @click="addSchedule()" 
                        class="text-[11px] text-active border border-active rounded-full px-3 py-1 hover:bg-active hover:text-white transition-colors">
                        + Add Schedule
                    </button>
                </div>

                <div class="bg-white border border-border rounded-2xl overflow-hidden">
                    <template x-for="(schedule, index) in schedules" :key="index">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-border last:border-b-0 group">
                            
                            <div class="w-32">
                                <input type="text" x-model="schedule.day_range" placeholder="e.g. Monday"
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
                <h2 class="text-base font-semibold text-dark mb-4">Contact Details</h2>
                <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Phone Number</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $cafe->num_phone ?? '') }}"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $cafe->email ?? '') }}"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Address</label>
                        <input type="text" name="address" value="{{ old('address', $cafe->address ?? '') }}"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                    </div>

                </div>
            </section>

            <!-- SECTION: Location & Maps -->
            <section class="mb-8">
                <h2 class="text-base font-semibold text-dark mb-4">Location & Maps</h2>
                 <div class="bg-white border border-border rounded-2xl p-5 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Latitude</label>
                            <input type="text" name="latitude" placeholder="e.g., 47.6062" value="{{ old('latitude', $cafe->latitude ?? '') }}"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Longitude</label>
                            <input type="text" name="longitude" placeholder="e.g., -122.3321" value="{{ old('longitude', $cafe->longitude ?? '') }}"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($daftarDaerah as $kecamatan)
                                <option value="{{ $kecamatan->id }}" data-meta="{{ json_encode($kecamatan->meta) }}" {{ $cafe->kecamatan == $kecamatan->name ? 'selected' : '' }}>
                                    {{ ucwords(strtolower($kecamatan->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                        
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Google Maps Link</label>
                        <input type="url" name="maps" placeholder="https://maps.google.com/maps?q=..." value="{{ old('maps', $cafe->maps_link ?? '') }}"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" required />
                </div>
            </section>

            <!-- SECTION: Photo Gallery -->
            <section class="mb-8">
                <h2 class="text-base font-semibold text-dark mb-4">Photo Gallery</h2>
                <div class="bg-white border border-border rounded-2xl p-5">
                    <div class="grid grid-cols-4 gap-3" id="photo-gallery">

                        <!-- Existing Photos -->
                        @if(isset($cafe) && $cafe->photos->isNotEmpty())
                            @foreach($cafe->photos as $photo)
                                <div class="relative group rounded-xl overflow-hidden aspect-square">
                                    <img src="{{ asset('storage/' . $photo->photo_url) }}" alt="cafe photo" class="w-full h-full object-cover" />
                                    <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                                </div>
                            @endforeach
                        @endif

                        <!-- Upload Area -->
                        <div class="relative group rounded-xl overflow-hidden aspect-square border-2 border-dashed border-border flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" onclick="document.getElementById('photo-input').click()" id="photo-upload-area">
                            <span class="text-lg text-muted">⊕</span>
                            <span class="text-[10px] text-muted mt-1 uppercase tracking-wider">Upload</span>
                            <input type="file" name="photos[]" id="photo-input" accept="image/*" multiple style="display: none;" onchange="handlePhotoUpload(event)" />
                        </div>
                    </div>
                    <p class="text-[10px] text-muted mt-3">Upload multiple images (recommended: at least 4-6 photos). Maximum 12 images.</p>
                </div>
            </section>

            <!-- SECTION: Thumbnail -->
            <section class="mb-8">
                <h2 class="text-base font-semibold text-dark mb-4">Thumbnail</h2>
                <div class="bg-white border border-border rounded-2xl p-5">

                    <div class="grid grid-cols-4 gap-3" id="thumbnail-gallery">

                        <!-- Existing Thumbnail -->
                        @if(isset($cafe) && $cafe->thumbnail)
                            <div class="relative group rounded-xl overflow-hidden aspect-square">
                                <img src="{{ asset('storage/' . $cafe->thumbnail->photo_url) }}" alt="thumbnail" class="w-full h-full object-cover" />
                                <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                            </div>
                        @endif

                        <!-- Upload Area (HARUS di dalam thumbnail-gallery) -->
                        <div class="relative group rounded-xl overflow-hidden aspect-square border-2 border-dashed border-border flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" 
                            onclick="document.getElementById('thumbnail-input').click()" 
                            id="thumbnail-upload-area">
                            <span class="text-lg text-muted">⊕</span>
                            <span class="text-[10px] text-muted mt-1 uppercase tracking-wider">Upload</span>
                            <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" style="display: none;" onchange="handleThumbnailInput(event)" />
                        </div>

                    </div> <!-- Penutup thumbnail-gallery -->
                </div> <!-- Penutup bg-white -->
            </section>

            <!-- SECTION: Featured Menu -->
            <section class="mb-10">
                <h2 class="text-base font-semibold text-dark mb-4">Featured Menu</h2>
                <div class="bg-white border border-border rounded-2xl overflow-hidden" id="menu-section">

                    <div id="menu-list">
                        <!-- Existing Menu Items -->
                        @if(isset($cafe) && $cafe->menuItems->isNotEmpty())
                            @foreach($cafe->menuItems as $index => $item)
                                <div class="menu-item flex items-center justify-between px-5 py-4 border-b border-border">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl overflow-hidden {{ $item->img_url ? '' : 'bg-[#f5f1ec] flex items-center justify-center text-xs text-muted' }}">
                                            @if($item->img_url)
                                                <img src="{{ asset('storage/' . $item->img_url) }}" alt="menu image" class="w-full h-full object-cover" />
                                            @else
                                                IMG
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-dark">{{ $item->name }}</p>
                                            <p class="text-xs text-muted">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="menu-price text-sm font-semibold text-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        <button type="button" class="text-muted hover:text-red-500 transition-colors text-sm" onclick="removeMenuItem(this, {{ $index }})">✕</button>
                                    </div>

                                    <input type="hidden" name="menu_items[{{ $index }}][name]" value="{{ $item->name }}">
                                    <input type="hidden" name="menu_items[{{ $index }}][description]" value="{{ $item->description }}">
                                    <input type="hidden" name="menu_items[{{ $index }}][price]" value="{{ $item->price }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div id="new-menu-form" class="hidden px-5 py-4 border-b border-border space-y-3">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Menu Name</label>
                                <input type="text" id="menu-name" placeholder="Menu name" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                            </div>
                            <div class="col-span-12 md:col-span-5">
                                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Description</label>
                                <input type="text" id="menu-description" placeholder="Short description" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Price (Rupiah)</label>
                                <input type="text" id="menu-price" placeholder="Rp 35.000" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" onblur="formatPriceInput(this)" />
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-3 items-end">
                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Photo</label>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="document.getElementById('menu-image-input').click()" class="bg-[#F2EEE7] border border-border text-dark text-sm font-semibold rounded-xl px-4 py-2.5 hover:bg-stat transition-colors">Upload Image</button>
                                    <span id="menu-image-name" class="text-[10px] text-muted">No file chosen</span>
                                </div>
                                <input type="file" id="menu-image-input" accept="image/*" style="display: none;" onchange="handleMenuImageUpload(event)" />
                            </div>
                            <div class="col-span-12 md:col-span-8">
                                <div id="menu-image-preview" class="h-20 rounded-2xl border border-border bg-[#F7F5F0] flex items-center justify-center text-[10px] text-muted overflow-hidden">
                                    Preview image akan muncul di sini
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" onclick="saveMenuItem()" class="bg-darkbrown text-white text-sm font-semibold rounded-full px-5 py-3 hover:bg-[#1e1a16] transition-colors">Add Menu</button>
                            <button type="button" onclick="toggleNewMenuForm(false)" class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-5 py-3 hover:bg-stat transition-colors">Cancel</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-center px-5 py-3.5 cursor-pointer hover:bg-stat transition-colors" onclick="toggleNewMenuForm(true)">
                        <span class="text-xs text-muted font-medium">+ add menu item</span>
                    </div>

                </div>
            </section>

            <section class='mb-10'>
                            <!-- From Uiverse.io by Javierrocadev --> 
                <label class="relative inline-flex items-center cursor-pointer">
                    <input class="sr-only peer" value="" type="checkbox" name="is_published">
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
                    {{ isset($cafe) ? 'Save Changes' : 'Publish Changes' }}
                </button>
                <button type="reset" class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-8 py-3.5 hover:bg-stat transition-colors">
                    Discard
                </button>
            </div>
        </form>

    </div>

    <script>
        function handlePhotoUpload(event) {
            const files = Array.from(event.target.files);
            const gallery = document.getElementById('photo-gallery');
            const uploadArea = document.getElementById('photo-upload-area');
            const currentPhotos = gallery.querySelectorAll('[class*="group"]').length - 1;
            
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
            const currentPhotos = gallery.querySelectorAll('[class*="group"]').length - 1;
            
            if (currentPhotos + files.length > 1) {
                alert('Maximum 1 thumbnail allowed. You already have ' + currentPhotos + ' thumbnail.');
                return;
            }

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'relative group rounded-xl overflow-hidden aspect-square';
                    photoDiv.innerHTML = `
                        <img src="${e.target.result}" alt="thumbnail" class="w-full h-full object-cover" />
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
            document.getElementById('menu-image-name').textContent = 'No file chosen';
            const preview = document.getElementById('menu-image-preview');
            preview.innerHTML = 'Preview image akan muncul di sini';
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
                reindexMenuItems();
            }
        }

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

                const removeBtn = item.querySelector('button[onclick^="removeMenuItem"]');
                removeBtn.setAttribute('onclick', `removeMenuItem(this, ${newIndex})`);
            });
        }
    </script>

</body>
</html>
