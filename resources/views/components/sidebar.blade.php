@props(['menuItems' => []])

@php
    // Jika menuItems tidak diberikan, tentukan berdasarkan role
    if (empty($menuItems)) {
        $userRole = auth()->user()->role->name ?? 'guest';
        if ($userRole === 'admin') {
            $menuItems = [
                [
                    'label' => 'The Collection',
                    'url' => '/admin/cafes',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>'
                ],
                [
                    'label' => 'Accounts',
                    'url' => '/admin/accounts',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>'
                ],
                [
                    'label' => 'Comments',
                    'url' => '/admin/comments',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'
                ],
                [
                    'label' => 'Beranda Settings',
                    'url' => '/admin/beranda-settings',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543-.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1 .826-3 .37zM15 12a3 3 0 11-6 0 a3 3 0 016 0z"/></svg>'
                ],
            ];
        } elseif ($userRole === 'owner') {
            $menuItems = [
                [
                    'label' => 'My Cafes',
                    'url' => '/dashboard',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                ],
                [
                    'label' => 'Add Cafe',
                    'url' => '/add-cafe',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>'
                ],
                [
                    'label' => 'Settings',
                    'url' => '/profile/settings',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                ],
            ];
        } 
    }
@endphp

<aside class="w-64 bg-white shadow-xl shadow-light-beige/50 z-20 flex flex-col justify-between" x-data="{ currentRoute: '{{ request()->path() }}' }">
    <div>
        <!-- Logo -->
        <div class="h-24 flex items-center px-8 border-b-2 border-cream">
            <h1 class="font-serif text-3xl font-bold tracking-tight text-dark-brown italic">SAFE</h1>
        </div>

        <!-- Navigation Dinamis -->
        <nav class="p-6 space-y-2">
            @foreach($menuItems as $item)
                <a href="{{ $item['url'] }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is(trim($item['url'], '/').'*') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                    {!! $item['icon'] !!}
                    <span class="font-medium">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Bagian Bawah (Tetap/Statis) -->
    <div class="p-6 space-y-2 border-t-2 border-cream">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.settings') }}" class=" w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->is('profile/settings') ? 'bg-dark-brown text-white shadow-lg shadow-dark-brown/20' : 'text-gray-500 hover:bg-cream hover:text-dark-brown hover:shadow-sm' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span class="font-medium">Profile</span>
            </a>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('cafes.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="font-medium">Beranda</span>
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="button" @click='$dispatch("open-logout-modal")' class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 hover:bg-cream hover:text-dark-brown transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span class="font-medium">Logout</span>
            </button>
        </form>

        <div class="mt-4 pt-4 border-t-2 border-cream flex items-center gap-3 px-2">
            <div class="h-10 w-10 rounded-full bg-light-beige overflow-hidden">
                <img src="{{ $avatarUrl ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="h-full w-full object-cover">
            </div>
            <div class="text-sm truncate">
                <p class="font-semibold text-dark-brown">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">{{ auth()->user()->role->name ?? 'User' }}</p>
            </div>
        </div>
    </div>
</aside>
