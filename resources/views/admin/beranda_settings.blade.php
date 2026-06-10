@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">{{ __('messages.beranda_settings_title') }}</h2>
            <p class="text-gray-500 mt-2 text-lg">{{ __('messages.beranda_settings_desc') }}</p>
        </div>
    </div>

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

        <form method="POST" action="{{ route('admin.beranda_settings.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.homepage_title') }}</label>
                    <input type="text" name="title" value="{{ old('title', $setting->title) }}" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400" required>
                    @error('title') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.homepage_desc') }}</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown placeholder-gray-400">{{ old('description', $setting->description) }}</textarea>
                    @error('description') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-6 pt-6 border-t border-light-beige/30">
                <h3 class="font-serif text-2xl font-bold text-dark-brown">{{ __('messages.slider_images') }}</h3>
                
                @if($setting->slider_images && count($setting->slider_images) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    @foreach($setting->slider_images as $image)
                    <div class="relative group rounded-xl overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-32 object-cover" alt="Slider Image">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <label class="flex items-center gap-2 text-white text-sm font-bold cursor-pointer">
                                <input type="checkbox" name="remove_images[]" value="{{ $image }}" class="w-4 h-4">
                                {{ __('messages.remove') }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 italic mb-4">{{ __('messages.remove_image_instruction') }}</p>
                @endif

                <div class="space-y-2">
                    <label class="text-sm font-bold text-dark-brown tracking-wide">{{ __('messages.add_new_images') }}</label>
                    <div class="relative inline-block w-full">
                        <input type="file" name="slider_images[]" id="slider_images" multiple accept="image/*" class="w-full px-4 py-3 bg-cream/30 border border-light-beige/50 rounded-2xl focus:ring-2 focus:ring-dark-brown/20 focus:bg-white focus:outline-none transition-all text-dark-brown cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-500">{{ __('messages.add_multiple_images_instruction') }}</p>
                    @error('slider_images.*') <span class="text-soft-red text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-8 border-t border-light-beige/30">
                <button type="submit" class="px-8 py-3.5 bg-dark-brown text-white text-sm font-bold uppercase tracking-wider rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">{{ __('messages.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
