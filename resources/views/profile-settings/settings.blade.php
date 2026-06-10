@extends('layouts.app')

@section('title', __('messages.account_settings_title'))
@section('page-title', __('messages.account_settings_title'))
@section('content')

<div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 max-w-3xl">
    @if(session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif
    
    @if(session('error'))
        <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
    @endif


    <form method="POST" action="{{ route('profile.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="flex items-center gap-6 pb-8 border-b border-light-beige/30">
            <div class="h-20 w-20 rounded-full bg-light-beige text-black flex items-center justify-center font-bold text-4xl">
                {{ collect(explode(' ', auth()->user()->username ?? 'Guest'))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
            </div>
            <div>
                <h3 class="font-bold text-dark-brown text-xl">{{ auth()->user()->username }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.full_name') }}</label>
                <input type="text" name="username" value="{{ old('username', auth()->user()->username ?? '') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown" required>
                @error('username') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.email_address') }}</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown" readonly required>
                @error('email') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6">
            {{-- <button type="button" @click="showForm = !showForm" class="px-6 py-2 bg-[#4A3B32] text-white text-sm font-bold rounded-xl hover:bg-opacity-80 transition-all">
                Change Password
            </button> --}}

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-light-beige/30 space-y-6 mt-6">
                <h3 class="font-serif text-2xl font-bold text-dark-brown">{{ __('messages.security') }}</h3>

                <div class="space-y-2 mb-4">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.old_password') }}</label>
                    <input type="password" name="current_password" placeholder="{{ __('messages.placeholder_current_password') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                    @error('current_password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.new_password_label') }}</label>
                    <input type="password" name="password" placeholder="{{ __('messages.placeholder_new_password') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                    @error('password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.confirm_new_password') }}</label>
                    <input type="password" name="password_confirmation" placeholder="{{ __('messages.placeholder_confirm_new_password') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-8 border-t border-light-beige/30">
            <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white text-sm font-bold uppercase tracking-wider rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">{{ __('messages.save_changes') }}</button>
            <button type="button" class="px-8 py-3.5 bg-white border border-light-beige text-gray-500 text-sm font-bold uppercase tracking-wider rounded-full hover:bg-cream transition-all">{{ __('messages.cancel_btn') }}</button>
        </div>
    </form>
</div>
@endsection