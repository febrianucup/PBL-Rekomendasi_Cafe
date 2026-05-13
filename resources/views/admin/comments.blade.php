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
        @forelse($comments as $comment)
        <div x-show="tab === 'all' || tab === '{{ $comment->status }}'" class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/40 flex flex-col md:flex-row gap-8 transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1">
            <div class="w-full md:w-56 shrink-0 flex flex-col gap-4">
                <div class="relative overflow-hidden rounded-2xl shadow-sm">
                    <img src="{{ $comment->cafe->thumbnail ? asset('storage/'.$comment->cafe->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80' }}" alt="Cafe" class="w-full h-36 object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <p class="font-serif font-bold text-dark-brown line-clamp-1 px-1">{{ $comment->cafe->name }}</p>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=D6CFC7&color=4B2E2B" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-5 py-2 rounded-full text-[10px] font-bold tracking-widest uppercase 
                            @if($comment->status == 'pending') bg-light-beige/30 text-dark-brown border-light-beige/50 
                            @elseif($comment->status == 'reported') bg-soft-red/10 text-soft-red border-soft-red/20
                            @elseif($comment->status == 'approved') bg-soft-green/10 text-soft-green border-soft-green/20
                            @else bg-gray-100 text-gray-500 border-gray-200 @endif border">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </div>
                    <p class="text-gray-700 leading-relaxed font-serif text-lg tracking-wide @if($comment->status == 'reported') bg-soft-red/5 border-soft-red/10 @else bg-cream/30 @endif p-6 rounded-2xl border border-transparent">
                        "{{ $comment->content }}"
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-6 pt-6 border-t border-light-beige/30">
                    <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        @if($comment->status !== 'approved')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="px-6 py-2 bg-soft-green text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-green-600 transition-all font-medium">Approve</button>
                        @endif
                    </form>
                    
                    <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        @if($comment->status !== 'archived')
                            <input type="hidden" name="status" value="archived">
                            <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-gray-200 transition-all font-medium">Archive</button>
                        @endif
                    </form>

                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="ml-auto inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-8 py-3 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 transition-all">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <p>No comments found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
