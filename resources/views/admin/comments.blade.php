@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col xl:flex-row xl:justify-between items-start xl:items-end gap-6">
        <div>
            <h1 class="font-serif text-4xl font-bold text-dark-brown">{{ __('messages.comments_moderation_title') }}</h1>
            <p class="text-gray-500 mt-2 text-lg">{{ __('messages.comments_moderation_desc') }}</p>
        </div>
        <div class="flex items-center gap-6 bg-white/50 px-6 py-4 rounded-3xl border border-white shadow-sm">
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">{{ __('messages.comments_total') }}</p>
                <p class="font-serif text-3xl font-bold text-dark-brown">{{ $counts['total'] }}</p>
            </div>
            <div class="h-10 w-px bg-light-beige"></div>
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">{{ __('messages.comments_reviews') }}</p>
                <p class="font-serif text-3xl font-bold text-soft-green">{{ $counts['review'] }}</p>
            </div>
            <div class="h-10 w-px bg-light-beige"></div>
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">{{ __('messages.comments_discussions') }}</p>
                <p class="font-serif text-3xl font-bold text-blue-600">{{ $counts['discussion'] }}</p>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <!-- Filters -->
    <div class="flex justify-end bg-white/40 p-6 rounded-3xl border border-white/60">
        <!-- Tabs -->
        <div class="flex gap-1.5 bg-cream/40 p-1.5 rounded-2xl border border-light-beige/40">
            <a href="{{ route('admin.comments', ['type' => 'all']) }}" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-bold transition-all whitespace-nowrap {{ $type === 'all' ? 'bg-dark-brown text-white shadow-sm' : 'text-gray-500 hover:text-dark-brown' }}">
                {{ __('messages.comments_all') }}
            </a>
            <a href="{{ route('admin.comments', ['type' => 'review']) }}" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-bold transition-all whitespace-nowrap {{ $type === 'review' ? 'bg-dark-brown text-white shadow-sm' : 'text-gray-500 hover:text-dark-brown' }}">
                {{ __('messages.comments_reviews') }}
            </a>
            <a href="{{ route('admin.comments', ['type' => 'discussion']) }}" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-bold transition-all whitespace-nowrap {{ $type === 'discussion' ? 'bg-dark-brown text-white shadow-sm' : 'text-gray-500 hover:text-dark-brown' }}">
                {{ __('messages.comments_discussions') }}
            </a>
        </div>
    </div>
    

    <!-- Content -->
    <div class="space-y-6">
        @forelse($comments as $comment)
        <div class="bg-white rounded-[32px] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-white/45 flex flex-col md:flex-row gap-8 transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1">
            
            <!-- Cafe Column -->
            <div class="w-full md:w-56 shrink-0 flex flex-col gap-4">
                @if($comment->cafe)
                    <div class="relative overflow-hidden rounded-2xl shadow-sm">
                        <img src="{{ $comment->cafe->thumbnail ? asset('storage/'.$comment->cafe->thumbnail->photo_url) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80' }}" alt="Cafe" class="w-full h-36 object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <a href="{{ route('cafes.show', $comment->cafe->id) }}" class="font-serif font-bold text-dark-brown hover:text-dark-brown/80 transition-colors line-clamp-2 px-1 text-lg leading-snug">
                        {{ $comment->cafe->name }}
                    </a>
                @else
                    <div class="w-full h-36 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                    <p class="font-serif font-bold text-gray-400 px-1 text-lg">Unknown Cafe</p>
                @endif
            </div>

            <!-- Comment Details Column -->
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <!-- User Meta -->
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'User') }}&background=D6CFC7&color=4B2E2B" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">{{ $comment->user->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="flex items-center gap-2">
                            <!-- Type Badge -->
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase border {{ $comment->type === 'review' ? 'bg-soft-green/10 text-soft-green border-soft-green/20' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                {{ $comment->type === 'review' ? __('messages.comments_reviews') : __('messages.comments_discussions') }}
                            </span>
                            
                            <!-- Rating Score Badge (if review) -->
                            @if($comment->type === 'review' && $comment->rating_score)
                                <span class="flex items-center gap-1 bg-amber-50 border border-amber-100 text-amber-700 px-3 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                                    <span class="text-amber-500">★</span> {{ number_format($comment->rating_score, 0) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Comment Body -->
                    <div class="text-gray-700 leading-relaxed font-serif text-lg tracking-wide bg-cream/30 p-6 rounded-2xl border border-light-beige/25 relative">
                        <span class="text-3xl text-light-beige absolute left-3 top-2 font-serif select-none">“</span>
                        <p class="pl-4 pr-2 py-1 font-serif text-gray-800">
                            {{ $comment->body }}
                        </p>
                    </div>

                    <!-- Attached Images (if any) -->
                    @if($comment->images)
                        @php
                            $images = json_decode($comment->images, true);
                        @endphp
                        @if(!empty($images))
                            <div class="flex flex-wrap gap-3 mt-4">
                                @foreach($images as $img)
                                    <div class="relative overflow-hidden rounded-xl border border-light-beige/40 shadow-sm cursor-zoom-in group">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Attached Photo" class="h-20 w-20 object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Footer & Action -->
                <div class="flex flex-wrap items-center justify-between gap-3 mt-6 pt-6 border-t border-light-beige/30">
                    <span class="text-xs text-gray-400 font-mono">ID: #{{ $comment->id }}</span>
                    
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm({{ json_encode(__('messages.comments_confirm_delete_text')) }})" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-8 py-2.5 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 hover:border-soft-red/40 transition-all duration-300">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[32px] p-16 text-center text-gray-500 border border-light-beige/30 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <p class="font-serif text-lg text-gray-700">{{ __('messages.comments_empty') }}</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $comments->links() }}
    </div>
</div>
@endsection
