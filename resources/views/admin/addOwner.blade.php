@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div>
        <h2 class="font-serif text-4xl font-bold text-dark-brown">Tambah Pemilik Kafe</h2>
        <p class="text-gray-500 mt-2 text-lg">Buat akun pemilik kafe baru untuk mengelola kafe.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-lg border border-light-beige/30 p-10">
        @if($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.owners.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">Nama Pemilik</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">Nomor Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">Alamat</label>
                <textarea name="alamat" class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit" class="bg-dark-brown text-white px-8 py-4 rounded-full font-bold hover:opacity-90 transition">Simpan Pemilik Kafe</button>
                <a href="{{ route('admin.owners.index') }}" class="bg-light-beige text-dark-brown px-8 py-4 rounded-full font-bold text-center hover:bg-cream transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
