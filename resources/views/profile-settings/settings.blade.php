@extends('layouts.app')

@section('title', 'Account Settings')
@section('page-title', 'Account Settings')
@section('content')

<div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 max-w-3xl">
    @if(session('success'))
    <div class="mb-6 bg-soft-green/20 text-soft-green border border-soft-green/30 p-4 rounded-2xl font-medium">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-6 bg-soft-red/20 text-soft-red border border-soft-red/30 p-4 rounded-2xl font-medium">
        {{ session('error') }}
    </div>
    @endif


    <form method="POST" action="{{ route('profile.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="flex items-center gap-6 pb-8 border-b border-light-beige/30">
            <div class="h-20 w-20 rounded-full bg-light-beige text-black flex items-center justify-center font-bold text-4xl">
                {{ collect(explode(' ', auth()->user()->username ?? 'Guest'))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
            </div>
            <div>
                <h3 class="font-bold text-dark-brown text-xl">Profile Picture</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-bold text-dark-brown tracking-wide">Full Name</label>
                <input type="text" name="username" value="{{ old('username', auth()->user()->username ?? '') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown" required>
                @error('username') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-dark-brown tracking-wide">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown" required>
                @error('email') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6">
            {{-- <button type="button" @click="showForm = !showForm" class="px-6 py-2 bg-[#4A3B32] text-white text-sm font-bold rounded-xl hover:bg-opacity-80 transition-all">
                Change Password
            </button> --}}

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-light-beige/30 space-y-6 mt-6">
                <h3 class="font-serif text-2xl font-bold text-dark-brown">Security</h3>

                <div class="space-y-2 mb-4">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">Password Lama</label>
                    <input type="password" name="current_password" placeholder="Enter current password" class="w-full md:w-1/2 px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                    @error('current_password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">Password Baru</label>
                    <input type="password" name="password" placeholder="Enter new password" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                    @error('password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-8 border-t border-light-beige/30">
            <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white text-sm font-bold uppercase tracking-wider rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">Save Changes</button>
            <button type="button" class="px-8 py-3.5 bg-white border border-light-beige text-gray-500 text-sm font-bold uppercase tracking-wider rounded-full hover:bg-cream transition-all">Cancel</button>
        </div>
    </form>
</div>
@endsection