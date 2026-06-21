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
            <div class="h-10 w-px bg-light-beige"></div>
            <div class="text-center">
                <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">{{ __('messages.reported') }}</p>
                <p class="font-serif text-3xl font-bold text-red-600">{{ $counts['reported'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <!-- Notification for Reported Comments -->
    @if(isset($counts['reported']) && $counts['reported'] > 0)
        <div class="bg-red-50 border border-red-200 rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm mb-6">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-2xl text-red-600 shrink-0">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-800">{{ __('messages.reported_comments_alert_title') }}</h3>
                    <p class="text-sm text-red-600 mt-0.5">{{ __('messages.reported_comments_alert_desc', ['count' => $counts['reported']]) }}</p>
                </div>
            </div>
            <a href="{{ route('admin.comments', ['type' => 'reported']) }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-center whitespace-nowrap">
                {{ __('messages.view_reported') }}
            </a>
        </div>
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
            <a href="{{ route('admin.comments', ['type' => 'reported']) }}" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-bold transition-all whitespace-nowrap {{ $type === 'reported' ? 'bg-dark-brown text-white shadow-sm' : 'text-gray-500 hover:text-dark-brown' }}">
                {{ __('messages.reported') }}
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
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->username ?? 'User') }}&background=D6CFC7&color=4B2E2B" alt="User" class="w-12 h-12 rounded-full border-2 border-cream">
                            <div>
                                <p class="font-bold text-dark-brown text-sm">{{ $comment->user->username ?? 'User' }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="flex items-center gap-2">
                            @if($comment->is_reported)
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase border bg-red-50 text-red-600 border-red-100 animate-pulse">
                                    {{ __('messages.reported_by_owner') }}
                                </span>
                            @endif
                            
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

                    @if($comment->is_reported && $comment->report_reason)
                        <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">{{ __('messages.report_reason') }}</p>
                            <p class="text-sm text-red-600 font-serif italic">{{ $comment->report_reason }}</p>
                        </div>
                    @endif

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
                    
                    <div x-data="{ confirmDelete: false, confirmReject: false }" class="m-0 flex gap-2">
                        @if($comment->is_reported)
                            <button @click="confirmReject = true" type="button" class="px-8 py-2.5 bg-white border-2 border-stone-200 text-stone-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-stone-50 hover:border-stone-400 transition-all duration-300">
                                {{ __('messages.reject_report') }}
                            </button>
                            <!-- Reject Modal -->
                            <div x-show="confirmReject" class="fixed inset-0 z-50 flex items-center justify-center bg-transparent" x-cloak style="display: none;">
                                <div @click.away="confirmReject = false" class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl relative">
                                    <h3 class="font-serif text-2xl font-bold text-dark-brown mb-2">{{ __('messages.reject_report_title') }}</h3>
                                    <p class="text-gray-500 mb-6">{{ __('messages.reject_report_confirm') }}</p>
                                    
                                    <div class="flex gap-4">
                                        <button @click="confirmReject = false" class="flex-1 px-6 py-3 rounded-2xl border-2 border-light-beige text-dark-brown font-bold hover:bg-light-beige/20 transition-all">
                                            {{ __('messages.cancel') }}
                                        </button>
                                        <form action="{{ route('admin.comments.rejectReport', $comment->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-6 py-3 rounded-2xl bg-stone-600 hover:bg-stone-700 text-white font-bold shadow-lg shadow-stone-200 transition-all">
                                                {{ __('messages.yes_reject') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button @click="confirmDelete = true" type="button" class="px-8 py-2.5 bg-white border-2 border-soft-red/20 text-soft-red text-xs font-bold uppercase tracking-wider rounded-full hover:bg-soft-red/5 hover:border-soft-red/40 transition-all duration-300">
                            {{ __('messages.delete') }}
                        </button>
                        <x-delete-modal action="{{ route('admin.comments.destroy', $comment->id) }}" title="{{ __('messages.delete') }}" message="{{ __('messages.comments_confirm_delete_text') }}" />
                    </div>
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
