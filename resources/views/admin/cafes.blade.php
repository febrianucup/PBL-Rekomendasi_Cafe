@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">The Collection</h2>
            <p class="text-gray-500 mt-2 text-lg">Curate and manage exclusive cafe destinations.</p>
        </div>
        <button class="bg-dark-brown text-white px-6 py-3 rounded-full font-medium shadow-lg shadow-dark-brown/30 hover:bg-dark-brown/90 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
            Add New Destination
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-cream rounded-full opacity-50"></div>
            <p class="text-gray-500 font-medium mb-2 relative z-10">Active Listings</p>
            <h3 class="font-serif text-5xl font-bold text-dark-brown relative z-10">142</h3>
        </div>
        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-cream rounded-full opacity-50"></div>
            <p class="text-gray-500 font-medium mb-2 relative z-10">Average Rating</p>
            <h3 class="font-serif text-5xl font-bold text-dark-brown relative z-10">4.8 <span class="text-2xl text-soft-green">★</span></h3>
        </div>
        <div class="bg-dark-brown rounded-3xl p-8 shadow-[0_8px_30px_rgb(75,46,43,0.15)] relative overflow-hidden text-white">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/5 rounded-full"></div>
            <p class="text-light-beige font-medium mb-2 relative z-10">Curation Status</p>
            <h3 class="font-serif text-4xl font-bold relative z-10 mt-1">Excellent</h3>
            <p class="text-sm text-light-beige/70 mt-2 relative z-10">+12 this week</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="px-8 py-6 border-b border-light-beige/30 flex justify-between items-center bg-white/50 backdrop-blur-sm">
            <h3 class="font-serif text-2xl font-bold text-dark-brown">Destinations</h3>
            <button class="text-gray-400 hover:text-dark-brown transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-sm font-medium border-b border-light-beige/30 bg-cream/30 uppercase tracking-wider">
                        <th class="px-8 py-4 font-medium">Cafe</th>
                        <th class="px-8 py-4 font-medium">Location</th>
                        <th class="px-8 py-4 font-medium">Rating</th>
                        <th class="px-8 py-4 font-medium">Status</th>
                        <th class="px-8 py-4 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-beige/20 text-sm">
                    @forelse($cafes as $cafe)
                    <tr class="hover:bg-cream/20 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <img src="{{ $cafe->thumbnail ? asset('storage/'.$cafe->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=80' }}" alt="Cafe" class="w-16 h-16 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow">
                                <div>
                                    <p class="font-serif font-bold text-lg text-dark-brown">{{ $cafe->name }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5 font-medium">Added {{ $cafe->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-gray-600 font-medium">{{ $cafe->address }}</td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-1.5 bg-cream px-3 py-1.5 rounded-lg inline-flex">
                                <span class="text-dark-brown font-semibold">4.8</span>
                                <span class="text-soft-green text-xs">★</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-soft-green/10 text-soft-green border border-soft-green/20">Published</span>
                        </td>
                        <td class="px-8 py-5 text-right flex justify-end gap-2">
                            <form action="{{ route('admin.cafes.destroy', $cafe->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this cafe?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-soft-red hover:text-red-700 transition-colors font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-500 font-medium">No cafes found in the database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
