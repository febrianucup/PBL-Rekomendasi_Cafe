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
                    <!-- Row 1 -->
                    <tr class="hover:bg-cream/20 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=80" alt="Cafe" class="w-16 h-16 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow">
                                <div>
                                    <p class="font-serif font-bold text-lg text-dark-brown">The Artisan Roast</p>
                                    <p class="text-gray-500 text-xs mt-0.5 font-medium">Added 2 days ago</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-gray-600 font-medium">Downtown, 4th Ave</td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-1.5 bg-cream px-3 py-1.5 rounded-lg inline-flex">
                                <span class="text-dark-brown font-semibold">4.9</span>
                                <span class="text-soft-green text-xs">★</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-soft-green/10 text-soft-green border border-soft-green/20">Published</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-gray-400 hover:text-dark-brown transition-colors font-medium">Edit</button>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-cream/20 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=80" alt="Cafe" class="w-16 h-16 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow">
                                <div>
                                    <p class="font-serif font-bold text-lg text-dark-brown">Velvet Brew</p>
                                    <p class="text-gray-500 text-xs mt-0.5 font-medium">Added 5 days ago</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-gray-600 font-medium">Westside, Miller St</td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-1.5 bg-cream px-3 py-1.5 rounded-lg inline-flex">
                                <span class="text-dark-brown font-semibold">4.7</span>
                                <span class="text-soft-green text-xs">★</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-light-beige/30 text-dark-brown border border-light-beige">Review</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-gray-400 hover:text-dark-brown transition-colors font-medium">Edit</button>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-cream/20 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <img src="https://images.unsplash.com/photo-1559925393-8be0ec4767c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=80" alt="Cafe" class="w-16 h-16 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow">
                                <div>
                                    <p class="font-serif font-bold text-lg text-dark-brown">Lumina Coffee Co.</p>
                                    <p class="text-gray-500 text-xs mt-0.5 font-medium">Added 1 week ago</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-gray-600 font-medium">Uptown, 8th Ave</td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-1.5 bg-cream px-3 py-1.5 rounded-lg inline-flex">
                                <span class="text-dark-brown font-semibold">4.8</span>
                                <span class="text-soft-green text-xs">★</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-soft-green/10 text-soft-green border border-soft-green/20">Published</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-gray-400 hover:text-dark-brown transition-colors font-medium">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Featured Quote Card -->
    <div class="bg-white rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col md:flex-row items-center gap-10 relative overflow-hidden border border-white/40">
        <div class="absolute right-0 top-0 w-64 h-full bg-cream/50 skew-x-12 translate-x-32 hidden md:block"></div>
        <img src="https://images.unsplash.com/photo-1600093463592-8e36ae95ef56?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Featured" class="w-32 h-32 rounded-full object-cover shadow-xl border-4 border-white z-10 shrink-0">
        <div class="z-10 flex-1 text-center md:text-left">
            <svg class="w-10 h-10 text-light-beige mb-4 mx-auto md:mx-0" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
            <p class="font-serif text-2xl md:text-3xl text-dark-brown leading-relaxed italic">"A truly exceptional cafe is not just about the coffee; it's about the feeling of being somewhere intentionally designed to make you stay."</p>
            <p class="font-sans text-gray-500 font-bold mt-6 uppercase tracking-widest text-xs">— Curator's Note</p>
        </div>
    </div>
</div>
@endsection
