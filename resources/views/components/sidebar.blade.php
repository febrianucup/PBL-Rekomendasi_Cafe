@props(['menuItems' => []])

@php
    // Jika menuItems tidak diberikan, tentukan berdasarkan role
    if (empty($menuItems)) {
        $userRole = auth()->user()->role->name ?? 'guest';
        if ($userRole === 'admin') {
            $menuItems = [
                [
                    'label' => __('messages.sidebar_collection'),
                    'url' => '/admin/cafes',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>
'
                ],
                [
                    'label' => __('messages.sidebar_accounts'),
                    'url' => '/admin/accounts',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>'

                ],
                [
                    'label' => __('messages.sidebar_comments'),
                    'url' => '/admin/comments',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'
                ],
                [
                    'label' => 'Jenis & Tags',
                    'url' => '/admin/type-tags',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H12l5.25 5.25v5.25a2.25 2.25 0 0 1-2.25 2.25H9.75A2.25 2.25 0 0 1 7.5 14.25V3.75zM7.5 3.75H4.5a2.25 2.25 0 0 0-2.25 2.25v4.5L7.5 3.75zM12 7.5h4.5M14.25 9.75v4.5"/></svg>'
                ],
                [
                    'label' => __('messages.sidebar_beranda_settings'),
                    'url' => '/admin/beranda-settings',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543-.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                ]
            ];
        } elseif ($userRole === 'owner') {
            $menuItems = [
                [
                    'label' => __('messages.sidebar_my_cafes'),
                    'url' => '/dashboard',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                ],
                [
                    'label' => 'Promosi',
                    'url' => '/promosi',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M12 12V3m0 9l-3-3m3 3l3-3"/></svg>'
                ],
                [
                    'label' => __('messages.sidebar_add_cafe'),
                    'url' => '/add-cafe',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>'
                ]
            ];
        } 
    }
@endphp

<!-- Sidebar Backdrop for Mobile -->
<div x-show="sidebarOpen" 
     x-cloak 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-20 bg-black/50 transition-opacity lg:hidden"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>

<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-xl shadow-light-beige/50 flex flex-col justify-between transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-auto"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       x-data="{ currentRoute: '{{ request()->path() }}' }">
    <div>
        <!-- Logo -->
        <div class="h-24 flex items-center px-8 border-b-2 border-cream">
            <h1 class="font-serif text-3xl font-bold tracking-tight text-dark-brown italic">SAFE</h1>
        </div>

        <!-- Navigation Dinamis -->
        <nav class="p-6 space-y-2">
            @foreach($menuItems as $item)
                @php
                    $badge = null;
                    if ($item['url'] === '/admin/comments') {
                        $reportedCount = \App\Models\Comment::where('is_reported', true)->count();
                        if ($reportedCount > 0) {
                            $badge = $reportedCount;
                        }
                    }
                @endphp
                <a href="{{ $item['url'] }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is(trim($item['url'], '/').'*') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        {!! $item['icon'] !!}
                        <span class="font-medium">{{ $item['label'] }}</span>
                    </div>
                    @if($badge)
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full animate-bounce shrink-0">
                            {{ $badge }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <div class="p-6 space-y-2 border-t-2 border-cream">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.settings.show') }}" class=" w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is('profile/settings') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="font-medium">{{ __('messages.profile') }}</span>
            </a>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('cafes.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="font-medium">{{ __('messages.beranda') }}</span>
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="button" @click='$dispatch("open-logout-modal")' class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span class="font-medium">{{ __('messages.logout') }}</span>
            </button>
        </form>

        <div class="mt-4 pt-4 border-t-2 border-cream flex items-center gap-3 px-2">
            <div class="h-10 w-10 rounded-full bg-light-beige overflow-hidden">
                <img src="{{ $avatarUrl ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->username) }}" class="h-full w-full object-cover">
            </div>
            <div class="text-sm truncate">
                <p class="font-semibold text-dark-brown">{{ auth()->user()->username }}</p>
                <p class="text-xs text-gray-400">{{ auth()->user()->role->name ?? 'User' }}</p>
            </div>
        </div>
    </div>
</aside>
