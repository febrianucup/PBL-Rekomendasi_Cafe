@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('page-title', 'My Cafes')

@section('content')
    <!-- Dashboard Content -->
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-light-beige">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-dark-brown mb-2">Welcome back, {{ auth()->user()->username }}!</h1>
                    <p class="text-muted">Manage your cafe collection and grow your business.</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-widest text-muted mt-1">{{ __('messages.owner_dashboard') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-light-beige">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted mb-1">{{ __('messages.total_cafes') }}</p>
                        <p class="text-3xl font-bold text-dark-brown">{{ $cafes->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-light-beige rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-dark-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-light-beige">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted mb-1">Total Published Cafes</p>
                        <p class="text-3xl font-bold text-dark-brown">{{ $cafes->where('published', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-300 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-light-beige">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted mb-1">Total Unpublished Cafes</p>
                        <p class="text-3xl font-bold text-dark-brown">{{ $cafes->where('published', false)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-300 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>

                    </div>
                </div>
            </div>
        </div>

        <!-- Cafes List -->
        <div class="bg-white rounded-2xl shadow-sm border border-light-beige overflow-hidden">
            <div class="p-6 border-b border-light-beige">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-dark-brown">{{ __('messages.your_cafes') }}</h2>
                    <a href="{{ route('add-cafe') }}" class="inline-flex items-center gap-2 bg-dark-brown text-white px-4 py-2 rounded-xl hover:bg-dark-brown/90 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('messages.add_new_cafe') }}
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm font-medium border-b border-light-beige/30 bg-cream/30 uppercase tracking-wider">
                            <th class="px-8 py-4 font-medium">Cafe</th>
                            <th class="px-8 py-4 font-medium">Rating</th>
                            <th class="px-8 py-4 font-medium">Status</th>
                            <th class="px-8 py-4 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-light-beige/20 text-sm">
                        @if($cafes->count() > 0)
                            <div class="divide-y divide-light-beige">
                                @foreach($cafes as $cafe)
                                            <tr>
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-4">
                                                        @if($cafe->thumbnail)
                                                            <img src="{{ asset('storage/' . $cafe->thumbnail->photo_url) }}" alt="{{ $cafe->name }}" class="w-16 h-16 rounded-xl object-cover">
                                                        @else
                                                            <div class="w-16 h-16 bg-light-beige rounded-xl flex items-center justify-center">
                                                                <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div class="gap-2 mt-1 text-sm">
                                                            <h3 class="font-semibold text-dark-brown">{{ $cafe->name }}</h3>
                                                            <p class="text-sm text-muted">{{ $cafe->type->type_name ?? 'Unknown Type' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex items-center gap-1.5 bg-cream px-3 py-1.5 rounded-lg inline-flex">
                                                            <span class="text-dark-brown font-semibold">4.8</span>
                                                            <span class="text-soft-green text-xs">★</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-4">
                                                        @if ($cafe->published == true)
                                                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-soft-green/10 text-soft-green border border-soft-green/20">Published</span>
                                                        @else
                                                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-soft-red/10 text-soft-red border border-soft-red/20">Unpublished</span>
                                                        @endif
                                                        
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5 text-right flex justify-end gap-2">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('cafe.show', $cafe->id) }}" class="text-muted hover:text-dark-brown transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('cafe.edit', $cafe->id) }}" class="text-muted hover:text-dark-brown transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('cafe.delete', $cafe->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this cafe?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-soft-red hover:text-red-700 transition-colors font-medium">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <div class="w-24 h-24 bg-light-beige rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-dark-brown mb-2">No cafes yet</h3>
                                <p class="text-muted mb-6">Start building your cafe collection by adding your first cafe.</p>
                                <a href="{{ route('add-cafe') }}" class="inline-flex items-center gap-2 bg-dark-brown text-white px-6 py-3 rounded-xl hover:bg-dark-brown/90 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Your First Cafe
                                </a>
                            </div>
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
@endsection