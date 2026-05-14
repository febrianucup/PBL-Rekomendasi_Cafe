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
                    <h1 class="text-2xl font-bold text-dark-brown mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-muted">Manage your cafe collection and grow your business.</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-widest text-muted mt-1">Owner Dashboard</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Cafes -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-light-beige">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted mb-1">Total Cafes</p>
                        <p class="text-3xl font-bold text-dark-brown">{{ $cafes->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-light-beige rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-dark-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cafes List -->
        <div class="bg-white rounded-2xl shadow-sm border border-light-beige overflow-hidden">
            <div class="p-6 border-b border-light-beige">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-dark-brown">Your Cafes</h2>
                    <a href="{{ route('add-cafe') }}" class="inline-flex items-center gap-2 bg-dark-brown text-white px-4 py-2 rounded-xl hover:bg-dark-brown/90 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add New Cafe
                    </a>
                </div>
            </div>

            @if($cafes->count() > 0)
                <div class="divide-y divide-light-beige">
                    @foreach($cafes as $cafe)
                        <div class="p-6 hover:bg-cream/50 transition-colors">
                            <div class="flex items-center justify-between">
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
                                </div>
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
        </div>
    </div>
@endsection


        </main>
    </div>

</body>
</html>