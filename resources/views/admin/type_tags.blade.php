@extends('layouts.admin')

@section('content')
<div class="space-y-10 w-full">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">Kelola Jenis & Tag</h2>
            <p class="text-gray-500 mt-2 text-lg">Tambah, edit, dan hapus jenis serta tag dalam satu halaman khusus admin.</p>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
    @endif

    <div class="grid gap-8 xl:grid-cols-2">
        <section class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40">
            <h3 class="text-2xl font-bold text-dark-brown mb-6">Tambah Jenis</h3>
            <form action="{{ route('admin.type_tags.storeType') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">Nama Jenis</label>
                    <input type="text" name="type_name" value="{{ old('type_name') }}" placeholder="Contoh: Cafe, Resto" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none text-dark-brown" required>
                    @error('type_name') <p class="text-soft-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white rounded-full font-bold hover:bg-[#1e1a16] transition-all">Simpan Jenis</button>
            </form>

            <div class="mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-semibold text-dark-brown">Daftar Jenis</h4>
                    <span class="text-sm text-gray-500">{{ $types->count() }} item</span>
                </div>

                <div class="space-y-3">
                    @forelse($types as $type)
                        <div class="bg-cream/70 rounded-3xl p-4 border border-light-beige/70">
                            <form action="{{ route('admin.type_tags.updateType', $type->id) }}" method="POST" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                @csrf
                                @method('PUT')
                                <div class="flex-1">
                                    <label class="sr-only">Jenis</label>
                                    <input type="text" name="type_name" value="{{ old('type_name', $type->type_name) }}" class="w-full px-4 py-3 bg-white border border-light-beige rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:outline-none" required>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <button type="submit" class="px-5 py-3 bg-[#1e1a16] text-white rounded-full text-sm font-semibold hover:bg-black transition">Update</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.type_tags.destroyType', $type->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-soft-red text-sm font-semibold hover:text-red-600 transition">Hapus Jenis</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada jenis yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40">
            <h3 class="text-2xl font-bold text-dark-brown mb-6">Tambah Tag</h3>
            <form action="{{ route('admin.type_tags.storeTag') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">Nama Tag</label>
                    <input type="text" name="tag_name" value="{{ old('tag_name') }}" placeholder="Contoh: Cozy, Halal" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none text-dark-brown" required>
                    @error('tag_name') <p class="text-soft-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white rounded-full font-bold hover:bg-[#1e1a16] transition-all">Simpan Tag</button>
            </form>

            <div class="mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-semibold text-dark-brown">Daftar Tag</h4>
                    <span class="text-sm text-gray-500">{{ $tags->count() }} item</span>
                </div>

                <div class="space-y-3">
                    @forelse($tags as $tag)
                        <div class="bg-cream/70 rounded-3xl p-4 border border-light-beige/70">
                            <form action="{{ route('admin.type_tags.updateTag', $tag->id) }}" method="POST" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                @csrf
                                @method('PUT')
                                <div class="flex-1">
                                    <label class="sr-only">Tag</label>
                                    <input type="text" name="tag_name" value="{{ old('tag_name', $tag->tag_name) }}" class="w-full px-4 py-3 bg-white border border-light-beige rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:outline-none" required>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <button type="submit" class="px-5 py-3 bg-[#1e1a16] text-white rounded-full text-sm font-semibold hover:bg-black transition">Update</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.type_tags.destroyTag', $tag->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-soft-red text-sm font-semibold hover:text-red-600 transition">Hapus Tag</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada tag yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
