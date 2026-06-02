@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('page-title', 'Promosi')

@section('content')
<div class="space-y-10">
    @if(session('success'))
        <div class="rounded-3xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-3xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">Promosi</h2>
            <p class="text-gray-500 mt-2 text-lg">Kelola promosi dan lihat ringkasan terbaru di sini.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="flex items-center gap-8 mr-4 bg-white/50 px-6 py-3 rounded-2xl border border-white">
                <div>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">Total Promosi</p>
                    <p class="font-serif text-2xl font-bold text-dark-brown">{{ number_format($promotions->count()) }}</p>
                </div>
            </div>
            <a href="{{ route('owner.promosi.create') }}" class="bg-dark-brown text-white px-6 py-3.5 rounded-full font-bold shadow-sm hover:shadow-md hover:bg-[#1e1a16] transition-all duration-300">
                + Tambah Promosi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 md:gap-8 gap-6">
        @forelse ($promotions as $promotion)
            <div class="bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-white/40 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="rounded-[2rem] overflow-hidden mb-6 bg-slate-100 h-56">
                    @if($promotion->image_url)
                        <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-sm text-gray-500">Tidak ada gambar</div>
                    @endif
                </div>

                <h3 class="font-serif text-2xl font-bold text-dark-brown leading-tight mb-3">{{ $promotion->title }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ \Illuminate\Support\Str::limit($promotion->description, 120) }}</p>

                <div class="mt-5 text-sm text-gray-500 space-y-2">
                    <p><span class="font-semibold text-dark-brown">Cafe:</span> {{ $promotion->cafe?->name ?? 'Tidak tersedia' }}</p>
                    <p><span class="font-semibold text-dark-brown">Mulai:</span> {{ $promotion->start_date?->format('d M Y H:i') ?? '—' }}</p>
                    <p><span class="font-semibold text-dark-brown">Berakhir:</span> {{ $promotion->end_date?->format('d M Y H:i') ?? '—' }}</p>
                    <p><span class="font-semibold text-dark-brown">Status:</span>
                        @if($promotion->start_date && $promotion->end_date && now()->between($promotion->start_date, $promotion->end_date))
                            <span class="text-green-600">Aktif</span>
                        @else
                            <span class="text-red-600">Tidak Aktif</span>
                        @endif
                    </p>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('owner.promosi.edit', $promotion->id) }}" class="inline-flex items-center justify-center px-5 py-3 rounded-full bg-light-beige text-dark-brown text-sm font-semibold hover:bg-[#f2eee7] transition">Edit</a>
                    <form action="{{ route('owner.promosi.destroy', $promotion->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-3 rounded-full bg-rose-100 text-rose-700 text-sm font-semibold hover:bg-rose-200 transition" onclick="return confirm('Hapus promosi ini?');">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 bg-white rounded-[2rem] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-white/40 text-center">
                <p class="text-gray-500">Belum ada promosi tersedia. Klik tombol tambah untuk membuat promosi baru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
