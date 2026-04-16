<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#FDFBF7] text-[#333]">

    <nav class="flex justify-between items-center px-8 py-6">
        <div class="text-xl font-bold italic">SAFE</div>
        <div class="flex gap-6 text-sm font-semibold">
            {{-- <a href="#">Journals</a> --}}
            <a href="#" class="border-b-2 border-black">Cafés</a>
            {{-- <a href="#">Roasters</a>
            <a href="#">Curated Sets</a> --}}
        </div>
    </nav>

    <header class="relative w-full h-[500px] overflow-hidden rounded-lg px-8">
        <img src="../img/nakoa.png" alt="Cafe" class="w-full h-full object-cover">
        <div class="absolute bottom-10 left-16 text-white">
            <span class="bg-[#D4A373] text-xs px-2 py-1 rounded">CAFE PROFILE</span>
            <span>★ <span>4.9</span></span>
            <h1 class="text-6xl mt-2 font-bold">Nakoa Cafe Suhat</h1>
            <p class="mt-2 text-lg">Nakoa Cafe Suhat, Jl. Puncak Borobudur No.G502, Mojolangu, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142.</p>
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-16 px-4">
        
        <section class="text-center mb-16">
            <h2 class="text-4xl mb-6">The Atmosphere</h2>
            <p class="text-lg leading-relaxed text-gray-600">Nakoa Cafe Suhat in Malang offers a perfect blend of great coffee and a comfortable atmosphere, making it an ideal spot for coffee enthusiasts and those seeking a relaxing place to unwind or work. The cafe is more than just a place for drinks; it embodies a modern urban lifestyle concept. Visitors praise the appealing interior, delicious food, and reasonable prices. While some wish for more substantial meal options, others appreciate the availability of clean facilities like restrooms and prayer rooms.</p>
            
            <div class="flex justify-center gap-8 mt-10">
                <div class="flex flex-col items-center"><div class="w-12 h-12 bg-gray-200 rounded-lg mb-2 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 9.75 19.5 12m0 0 2.25 2.25M19.5 12l2.25-2.25M19.5 12l-2.25 2.25m-10.5-6 4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                </svg>
                </div><span>QUIET</span></div>
                <div class="flex flex-col items-center"><div class="w-12 h-12 bg-gray-200 rounded-lg mb-2 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                </div><span>SOCIAL</span></div>
                <div class="flex flex-col items-center"><div class="w-12 h-12 bg-gray-200 rounded-lg mb-2 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                </div><span>MINIMALIST</span></div>
            </div>
        </section>

        <section class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <p class="text-center text-sm uppercase tracking-widest text-gray-400">Lokasi</p>
            <h3 class="text-center text-2xl mt-2 mb-6">Nakoa, Suhat-Malang</h3>
            <div class="w-full h-48 bg-gray-800 rounded-lg mb-6" id="map"></div>
            <div class="flex justify-between items-center border-t pt-6">
                <div><span class="text-gray-500">Opening Hours:</span> 09:00 – 00:00</div>
            </div>
        </section>

        <section class="mt-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl">Colomn Comment</h2>
                <button class="text-sm underline">Add Comment</button>
            </div>

            <div class="mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-300"></div>
                    <div class="flex-1">
                        <p class="font-bold">Muhammad Dwi Febrian <span class="text-xs font-normal text-gray-500">• 3D AGO</span></p>
                        <p class="text-gray-700 mt-1">Tempat ini sangar minimalis dan nyaman untuk work from cafe ataupun nongkrong santai dengan teman-teman, menu nya juga banyak dan enak</p>
                        <div class="mt-3 bg-gray-50 p-4 rounded-lg border-l-4 border-[#D4A373]">
                            <p class="font-bold text-sm">KING BARCA<span class="text-xs font-normal text-gray-500">• 1D AGO</span></p>
                            <p class="text-sm text-gray-600">Iya lagi, baru kemarin gw kesana emang enak banget tempatnya apalagi buat gw yang lagi fokus skripsian dan sterss BARCA kalah di UCL</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @vite('resources/js/map.js')
</body>
</html>