@extends('layouts.admin')

@section('content')
<div class="space-y-10" x-data="{ tab: 'pending' }">
    <!-- Header -->
    <div class="flex flex-col xl:flex-row xl:justify-between items-start xl:items-end gap-6">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">The Conversation</h2>
            <p class="text-gray-500 mt-2 text-lg">Manage reviews, comments, and community feedback.</p>
        </div>
        <div class="flex items-center gap-6 bg-white/50 px-6 py-3 rounded-2xl border border-white">
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">Pending Review</p>
                <p class="font-serif text-2xl font-bold text-soft-red">24</p>
            </div>
            <div class="h-10 w-px bg-light-beige"></div>
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">Approved Today</p>
                <p class="font-serif text-2xl font-bold text-soft-green">156</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-light-beige/40">
        <nav class="flex gap-8 overflow-x-auto custom-scrollbar">
            <button @click="tab = 'all'" :class="{ 'border-dark-brown text-dark-brown font-bold': tab === 'all', 'border-transparent text-gray-500 hover:text-dark-brown hover:border-light-beige': tab !== 'all' }" class="pb-4 border-b-2 text-sm uppercase tracking-widest transition-all whitespace-nowrap">All Feed</button>
            <button @click="tab = 'pending'" :class="{ 'border-dark-brown text-dark-brown font-bold': tab === 'pending', 'border-transparent text-gray-500 hover:text-dark-brown hover:border-light-beige': tab !== 'pending' }" class="pb-4 border-b-2 text-sm uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">Pending <span class="bg-soft-red text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow-sm">24</span></button>
            <button @click="tab = 'reported'" :class="{ 'border-dark-brown text-dark-brown font-bold': tab === 'reported', 'border-transparent text-gray-500 hover:text-dark-brown hover:border-light-beige': tab !== 'reported' }" class="pb-4 border-b-2 text-sm uppercase tracking-widest transition-all whitespace-nowrap">Reported</button>
            <button @click="tab = 'archived'" :class="{ 'border-dark-brown text-dark-brown font-bold': tab === 'archived', 'border-transparent text-gray-500 hover:text-dark-brown hover:border-light-beige': tab !== 'archived' }" class="pb-4 border-b-2 text-sm uppercase tracking-widest transition-all whitespace-nowrap">Archived</button>
        </nav>
    </div>

    <!-- Content -->
    <div class="space-y-6">
        <!-- Comment Card 1 -->
        <div x-show="tab === 'all' || tab === 'pending'" class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 flex flex-col md:flex-row gap-8 transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1">
            <div class="w-full md:w-56 shrink-0 flex flex-col gap-4">
                <div class="relative overflow-hidden rounded-2xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Cafe" class="w-full h-36 object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <p class="font-serif font-bold text-dark-brown line-clamp-1 px-1">The Artisan Roast</p>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=D6CFC7&color=4B2E2B" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">Jane Doe</p>
                                <p class="text-xs text-gray-500 font-medium">2 hours ago</p>
                            </div>
                        </div>
                        <span class="px-5 py-2 rounded-full text-[10px] font-bold tracking-widest uppercase bg-light-beige/30 text-dark-brown border border-light-beige/50">Pending</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed font-serif text-lg tracking-wide bg-cream/30 p-6 rounded-2xl">"The ambiance here is absolutely unmatched. However, I felt the service was a bit slow during the weekend rush. Would love to see an improvement there!"</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-6 pt-6 border-t border-light-beige/30">
                    <button class="px-8 py-3 bg-soft-green text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md hover:shadow-lg hover:bg-[#8e9c76] transition-all">Approve</button>
                    <button class="px-8 py-3 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-200 transition-all font-medium">Hide</button>
                    <button class="px-8 py-3 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 transition-all ml-auto">Delete</button>
                </div>
            </div>
        </div>

        <!-- Comment Card 2 -->
        <div x-show="tab === 'all' || tab === 'reported'" class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 flex flex-col md:flex-row gap-8 transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1">
            <div class="w-full md:w-56 shrink-0 flex flex-col gap-4">
                <div class="relative overflow-hidden rounded-2xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Cafe" class="w-full h-36 object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <p class="font-serif font-bold text-dark-brown line-clamp-1 px-1">Velvet Brew</p>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Alex+Smith&background=F5F1EC&color=E57373" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">Alex Smith</p>
                                <p class="text-xs text-gray-500 font-medium">Yesterday</p>
                            </div>
                        </div>
                        <span class="px-5 py-2 rounded-full text-[10px] font-bold tracking-widest uppercase bg-soft-red/10 text-soft-red border border-soft-red/20">Reported</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed font-serif text-lg tracking-wide bg-soft-red/5 p-6 rounded-2xl border border-soft-red/10">"I found a bug in my coffee. Worst experience ever. Do NOT recommend this place to anyone!!!"</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-6 pt-6 border-t border-light-beige/30">
                    <button class="px-8 py-3 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-200 transition-all font-medium">Dismiss Report</button>
                    <button class="px-8 py-3 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 transition-all ml-auto">Delete Comment</button>
                </div>
            </div>
        </div>
        
        <!-- Comment Card 3 -->
        <div x-show="tab === 'all'" class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 flex flex-col md:flex-row gap-8 transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1">
            <div class="w-full md:w-56 shrink-0 flex flex-col gap-4">
                <div class="relative overflow-hidden rounded-2xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1559925393-8be0ec4767c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Cafe" class="w-full h-36 object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <p class="font-serif font-bold text-dark-brown line-clamp-1 px-1">Lumina Coffee Co.</p>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Michael+Torrance&background=A3B18A&color=ffffff" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">Michael Torrance</p>
                                <p class="text-xs text-gray-500 font-medium">2 days ago</p>
                            </div>
                        </div>
                        <span class="px-5 py-2 rounded-full text-[10px] font-bold tracking-widest uppercase bg-soft-green/10 text-soft-green border border-soft-green/20">Approved</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed font-serif text-lg tracking-wide bg-cream/30 p-6 rounded-2xl">"A beautifully designed space with coffee that matches the aesthetic. The pour-over was exceptional and the staff were incredibly knowledgeable about their beans."</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-6 pt-6 border-t border-light-beige/30">
                    <button class="px-8 py-3 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-200 transition-all font-medium">Hide</button>
                    <button class="px-8 py-3 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 transition-all ml-auto">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
