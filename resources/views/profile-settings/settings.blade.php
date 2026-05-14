@extends('layouts.app')

@section('title', 'Account Settings')
@section('page-title', 'Account Settings')
@section('content')

    <!-- Settings Form -->
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
            
            @php
                $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()?->name ?? 'Admin User').'&background=D6CFC7&color=4B2E2B';
                if (auth()->check()) {
                    $files = \Illuminate\Support\Facades\Storage::disk('public')->files('avatars');
                    foreach ($files as $file) {
                        if (str_starts_with(basename($file), 'avatar_' . auth()->id() . '.')) {
                            $avatarUrl = asset('storage/' . $file);
                            break;
                        }
                    }
                }
            @endphp
            <div class="flex items-center gap-6 pb-8 border-b border-light-beige/30">
                <div class="h-20 w-20 rounded-full bg-light-beige overflow-hidden ring-4 ring-cream flex-shrink-0">
                    <img src="{{ $avatarUrl }}" alt="Admin" class="h-full w-full object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-dark-brown text-xl">Profile Picture</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-3">Update your avatar. Recommended size: 256x256px.</p>
                    <div class="relative inline-block">
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <label for="avatar" class="inline-block px-5 py-2 bg-cream text-dark-brown text-xs font-bold uppercase tracking-wider rounded-full hover:bg-light-beige transition-all cursor-pointer">Change Avatar</label>
                    </div>
                    @error('avatar') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name ?? 'Admin User' }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400" required>
                    @error('name') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email ?? 'admin@pblcafe.com') }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400" required>
                    @error('email') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-6 pt-6 border-t border-light-beige/30">
                <h3 class="font-serif text-2xl font-bold text-dark-brown">Security</h3>
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">Current Password</label>
                    <input type="password" name="current_password" placeholder="Enter current password" class="w-full md:w-1/2 px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400">
                    @error('current_password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-dark-brown tracking-wide">New Password</label>
                        <input type="password" name="password" placeholder="Enter new password" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400">
                        @error('password') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-dark-brown tracking-wide">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-8 border-t border-light-beige/30">
                <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white text-sm font-bold uppercase tracking-wider rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">Save Changes</button>
                <button type="button" class="px-8 py-3.5 bg-white border border-light-beige text-gray-500 text-sm font-bold uppercase tracking-wider rounded-full hover:bg-cream transition-all">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
