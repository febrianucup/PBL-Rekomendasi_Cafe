<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sensory Editorial - Discovery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAF9F6; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        header {background-color: #F5F1EC}
    </style>
</head>
<body class="text-gray-900">

    <header class="max-w-6xl mx-auto px-6 py-8 flex justify-between items-center border-b border-gray-200">
        <div class="font-bold text-xl">SAFE</div>
        <nav class="space-x-8 text-sm uppercase tracking-widest text-gray-500">
            <a href="#" class="text-black border-b border-black">Beranda</a>
        </nav>
        <div class="space-x-4">
            <form>   
                <label for="voice-search" class="sr-only">Search</label>
                <input type="text" id="voice-search" class="border-b border border-black-4 py-2 px-5" required>
                <button type="submit" class="bg-black text-white px-5 py-3 uppercase text-xs font-bold">Search</button>
            </form>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4">Beranda</h1>
            <p class="text-gray-600 max-w-lg mx-auto">Cari cafe favoritmu dengan mudah.</p>
        </div>

        <div class="flex justify-center space-x-8 text-xs font-semibold uppercase tracking-widest mb-12 border-b border-gray-100 pb-4">
            <span class="border-b border-black pb-4">All Spaces</span>
            <span class="text-gray-400">Quiet</span>
            <span class="text-gray-400">Social</span>
            <span class="text-gray-400">Minimalist</span>
            <span class="text-gray-400">Industrial</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @for ($i = 0; $i < 6; $i++)
            <div class="group">
                <a href="detail/1">
                <div class="aspect-[4/3] bg-gray-300 mb-4 overflow-hidden">
                    <div class="w-full h-full bg-gray-200 animate-pulse"></div>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg">Nama Cafe {{$i+1}}</h3>
                        <p class="text-sm text-gray-500">Lokasi, Kota</p>
                    </div>
                    <div class="text-sm font-semibold">★ 4.8</div>
                </div>
                </a>
            </div>
            @endfor
        </div>

        <div class="mt-24 border-t border-gray-200 pt-16 text-center">
            <h2 class="text-3xl font-bold mb-4">JOIN</h2>
            <p class="text-gray-600 mb-6">Join untuk mendaftarkan cafemu!</p>
            <div class="max-w-md mx-auto flex flex-col items-center gap-4">
                <a class="bg-black text-white px-8 py-3 uppercase text-xs font-bold flex items-center justify-center" href="../login">Join</a>
            </div>
        </div>
    </main>

    <footer class="max-w-6xl mx-auto px-6 py-12 text-center text-xs text-gray-400 uppercase tracking-widest space-x-6 border-t border-gray-100">
        <a href="#">About</a>
        <a href="#">Editorial</a>
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Contact</a>
    </footer>

</body>
</html>