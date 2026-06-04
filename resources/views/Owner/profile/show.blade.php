<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Cafe - {{ $cafe->name }}</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
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
    <nav class="flex items-center justify-between px-7 py-3.5 border-b border-border bg-cream">
        <div class="flex items-center gap-7">
            <span class="font-semibold text-sm">Sensory Editorial</span>
            <div class="flex gap-1">
                <a href="#" class="text-sm font-semibold text-dark border-b-2 border-dark pb-0.5 px-2">Cafe Details</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-muted text-sm">🔔</button>
            <button class="text-muted text-sm">⚙️</button>
            <div class="w-8 h-8 rounded-full bg-[#D6C9BD] flex items-center justify-center text-xs font-semibold text-[#4A4037]">JS</div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-8">
        <a href="{{ route('owner.dashboard') }}" class="text-[11px] uppercase tracking-[0.18em] text-muted flex items-center gap-1 mb-5 inline-flex hover:text-dark transition-colors">
            ← Back to dashboard
        </a>

        <div class="bg-white border border-border rounded-[26px] p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-start gap-6">
                <div class="w-full md:w-2/5 rounded-[22px] overflow-hidden bg-[#F7F3EE]">
                    @if($cafe->thumbnail && $cafe->thumbnail->photo_url)
                        <img src="{{ asset('storage/' . $cafe->thumbnail->photo_url) }}" alt="{{ $cafe->name }} thumbnail" class="w-full h-full object-cover" />
                    @else
                        <div class="h-full min-h-[260px] bg-[#EDE7DE] flex items-center justify-center text-sm text-muted">No thumbnail available</div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-3xl font-semibold text-dark">{{ $cafe->name }}</h1>
                    <p class="text-sm text-muted mt-2">{{ isset($cafe->type->type_name) ? (trans()->has('messages.' . strtolower($cafe->type->type_name)) ? __('messages.' . strtolower($cafe->type->type_name)) : $cafe->type->type_name) : 'Unknown type' }} • {{ $cafe->kecamatan ?? 'Unknown area' }}</p>
                    <p class="text-sm text-muted mt-4">{{ $cafe->description }}</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="bg-stat rounded-3xl p-4">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-muted">Phone</p>
                            <p class="mt-2 text-sm font-semibold text-dark">{{ $cafe->num_phone }}</p>
                        </div>
                        <div class="bg-stat rounded-3xl p-4">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-muted">Email</p>
                            <p class="mt-2 text-sm font-semibold text-dark">{{ $cafe->email }}</p>
                        </div>
                        <div class="bg-stat rounded-3xl p-4">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-muted">Address</p>
                            <p class="mt-2 text-sm text-dark">{{ $cafe->address }}</p>
                        </div>
                        <div class="bg-stat rounded-3xl p-4">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-muted">Maps link</p>
                            <a href="{{ $cafe->maps_link }}" target="_blank" class="mt-2 block text-sm text-brown underline break-all">Open map</a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-muted mb-2">Tags</p>
                        <div class="flex flex-wrap gap-2">
                            @forelse($cafe->tags as $tag)
                                <span class="bg-[#E8E4DE] text-[#4A4037] text-[11px] font-medium px-3 py-1 rounded-full">{{ trans()->has('messages.' . strtolower($tag->tag_name)) ? __('messages.' . strtolower($tag->tag_name)) : $tag->tag_name }}</span>
                            @empty
                                <span class="text-xs text-muted">No tags added.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="bg-[#F7F3EE] rounded-[22px] p-6">
                    <h2 class="text-lg font-semibold text-dark mb-4">Opening Hours</h2>
                    <div class="space-y-3">
                        @forelse($cafe->operationalTime as $time)
                            <div class="rounded-2xl bg-white p-4 border border-border">
                                <p class="text-sm font-semibold text-dark">{{ $time->day_range }}</p>
                                <p class="text-xs text-muted mt-1">{{ preg_replace('/:00$/', '', $time->open_time) }} — {{ preg_replace('/:00$/', '', $time->close_time) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-muted">Opening hours not set.</p>
                        @endforelse
                    </div>
                </div>
                <div class="bg-[#F7F3EE] rounded-[22px] p-6">
                    <h2 class="text-lg font-semibold text-dark mb-4">Menu Highlights</h2>
                    @if($cafe->menuItems->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($cafe->menuItems as $item)
                                <div class="rounded-2xl bg-white p-4 border border-border">
                                    <div class="flex items-start gap-3">
                                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-[#F4EEE4] flex items-center justify-center text-[10px] text-muted">
                                            @if($item->img_url)
                                                <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" />
                                            @else
                                                IMG
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-dark">{{ $item->name }}</p>
                                            <p class="text-xs text-muted mt-1">{{ $item->description }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-muted">No menu items available.</p>
                    @endif
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-semibold text-dark mb-4">Photo Gallery</h2>
                @if($cafe->photos->isNotEmpty())
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($cafe->photos as $photo)
                            <div class="rounded-3xl overflow-hidden bg-[#F7F3EE] h-44">
                                <img src="{{ asset('storage/' . $photo->photo_url) }}" alt="Gallery photo" class="w-full h-full object-cover" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-muted">No gallery photos available.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
