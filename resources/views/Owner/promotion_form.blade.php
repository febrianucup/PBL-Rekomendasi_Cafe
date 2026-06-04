@extends('layouts.app')

@section('title', $promotion->exists ? 'Edit Promosi' : 'Tambah Promosi')
@section('page-title', $promotion->exists ? 'Edit Promosi' : 'Tambah Promosi')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white rounded-[2rem] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-white/40">
        @if(session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        @if($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $promotion->exists ? route('owner.promosi.update', $promotion->id) : route('owner.promosi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($promotion->exists)
                @method('PUT')
            @endif

            <div>
                <label for="cafe_id" class="block text-sm font-semibold text-dark-brown mb-2">Cafe</label>
                <select id="cafe_id" name="cafe_id" class="w-full rounded-3xl border border-light-beige/80 bg-[#F7F5F0] px-5 py-3 text-sm text-dark-brown focus:border-dark-brown focus:outline-none" {{ $cafes->isEmpty() ? 'disabled' : '' }}>
                    <option value="">{{ $cafes->isEmpty() ? 'Tidak ada cafe tersedia' : 'Pilih cafe' }}</option>
                    @foreach($cafes as $cafe)
                        <option value="{{ $cafe->id }}" {{ old('cafe_id', $promotion->cafe_id) == $cafe->id ? 'selected' : '' }}>{{ $cafe->name }}</option>
                    @endforeach
                </select>
                @if($cafes->isEmpty())
                    <p class="mt-2 text-sm text-rose-600">Belum ada cafe tersedia. Silakan tambahkan cafe terlebih dahulu.</p>
                @endif
            </div>

            <div>
                <label for="title" class="block text-sm font-semibold text-dark-brown mb-2">Judul Promosi</label>
                <input id="title" name="title" value="{{ old('title', $promotion->title) }}" type="text" required class="w-full rounded-3xl border border-light-beige/80 bg-[#F7F5F0] px-5 py-3 text-sm text-dark-brown focus:border-dark-brown focus:outline-none" />
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-dark-brown mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="5" required class="w-full rounded-3xl border border-light-beige/80 bg-[#F7F5F0] px-5 py-3 text-sm text-dark-brown focus:border-dark-brown focus:outline-none">{{ old('description', $promotion->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-dark-brown mb-2">Tanggal Mulai</label>
                    <input id="start_date" name="start_date" type="datetime-local" value="{{ old('start_date', optional($promotion->start_date)->format('Y-m-d\TH:i')) }}" required class="w-full rounded-3xl border border-light-beige/80 bg-[#F7F5F0] px-5 py-3 text-sm text-dark-brown focus:border-dark-brown focus:outline-none" />
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-dark-brown mb-2">Tanggal Berakhir</label>
                    <input id="end_date" name="end_date" type="datetime-local" value="{{ old('end_date', optional($promotion->end_date)->format('Y-m-d\TH:i')) }}" required class="w-full rounded-3xl border border-light-beige/80 bg-[#F7F5F0] px-5 py-3 text-sm text-dark-brown focus:border-dark-brown focus:outline-none" />
                </div>
            </div>

            <div>
                <label for="img_url" class="block text-sm font-semibold text-dark-brown mb-2">Gambar Promosi</label>
                <input id="img_url" name="img_url" type="file" accept="image/*" class="block w-full text-sm text-dark-brown" {{ $promotion->exists ? '' : 'required' }} />
                @if($promotion->image_url)
                    <div class="mt-4 rounded-3xl overflow-hidden border border-light-beige/80">
                        <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}" class="w-full h-56 object-cover" />
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-dark-brown px-8 py-3 text-sm font-bold text-white hover:bg-[#1e1a16] transition" {{ $cafes->isEmpty() ? 'disabled' : '' }}>{{ $promotion->exists ? 'Perbarui Promosi' : 'Simpan Promosi' }}</button>
                <a href="{{ route('owner.promosi') }}" class="inline-flex items-center justify-center rounded-full border border-light-beige bg-white px-8 py-3 text-sm font-semibold text-dark-brown hover:bg-light-beige transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
