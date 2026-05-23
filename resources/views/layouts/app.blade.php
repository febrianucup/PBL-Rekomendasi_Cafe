<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Safe</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-cream font-sans text-gray-800 antialiased selection:bg-soft-green selection:text-white">
    @php
        $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()?->username ?? 'User').'&background=D6CFC7&color=4B2E2B';
        if (auth()->check()) {
            $files = \Illuminate\Support\Facades\Storage::disk('public')->files('avatars');
            foreach ($files as $file) {
                if (str_starts_with(basename($file), 'avatar_' . auth()->id() . '.')) {
                    $avatarUrl = asset('storage/' . $file);
                    break;
                }
            }
        }
    @endphp

    <div class="flex h-screen overflow-hidden">
        <x-sidebar :menuItems="$menuItems ?? []"/>

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Top Bar / Header -->
            <header class="h-24 px-12 flex items-center justify-between border-b border-light-beige">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-semibold text-dark-brown">@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-light-beige overflow-hidden">
                        <img src="{{ $avatarUrl }}" class="h-full w-full object-cover">
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>

            <x-logout-modal />
        </main>
    </div>
</body>
</html>