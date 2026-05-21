@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">{{ __('messages.account_ecosystem') }}</h2>
            <p class="text-gray-500 mt-2 text-lg">{{ __('messages.account_ecosystem_desc') }}</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="flex items-center gap-8 mr-4 bg-white/50 px-6 py-3 rounded-2xl border border-white">
                <div>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mb-1">{{ __('messages.total_users') }}</p>
                    <p class="font-serif text-2xl font-bold text-dark-brown">{{ number_format($users->count()) }}</p>
                </div>
            </div>
            <button class="bg-white border border-light-beige/50 text-dark-brown px-6 py-3.5 rounded-full font-bold shadow-sm hover:shadow-md hover:bg-cream transition-all duration-300">
                {{ __('messages.export_ledger') }}
            </button>
        </div>
    </div>

    <!-- User Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 md:gap-8 gap-6">
        @forelse ($users as $user)
            <div class="bg-white rounded-[2rem] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-white/40 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex justify-between items-start mb-8">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=F5F1EC&color=4B2E2B" alt="Avatar" class="w-16 h-16 rounded-full border-2 border-cream shrink-0 group-hover:scale-105 transition-transform duration-300">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase {{ $user->role->name === 'owner' ? 'bg-dark-brown text-white' : 'bg-light-beige text-dark-brown border border-light-beige/50' }}">
                        {{ ucfirst($user->role->name ?? 'Guest') }}
                    </span>
                </div>
                <h3 class="font-serif text-2xl font-bold text-dark-brown leading-tight flex items-center gap-2">
                    {{ $user->username }}
                    @if($user->status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                    @elseif($user->status === 'rejected')
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Rejected</span>
                    @endif
                </h3>
                <p class="text-gray-500 text-sm mt-2">{{ $user->email }}</p>
                <div class="mt-8 pt-6 border-t border-light-beige/30 flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-medium">{{ __('messages.joined') }} {{ $user->created_at?->format('M Y') ?? '—' }}</span>
                    <a href="{{ route('accounts.show', $user->id) }}" class="text-dark-brown font-bold uppercase tracking-wider text-xs hover:text-soft-green transition-colors">
                        {{ __('messages.view_profile') }} &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 bg-white rounded-[2rem] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-white/40 text-center">
                <p class="text-gray-500">{{ __('messages.no_users_found') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
