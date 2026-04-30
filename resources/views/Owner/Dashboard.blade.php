<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'sans-serif'] },
                    colors: {
                        cream: '#F7F5F0',
                        dark: '#1B1B18',
                        muted: '#6B635A',
                        border: '#E3E3E0',
                        stat: '#F7F3EE',
                        brown: '#6B4F3B',
                        darkbrown: '#2C2720',
                        active: '#3F4C40',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream font-sans text-dark min-h-screen">

    <!-- TOP NAVBAR -->
    <nav class="flex items-center justify-between px-7 py-3.5 border-b border-border bg-cream">
        <div class="flex items-center gap-7">
            <span class="font-semibold text-sm">Sensory Editorial</span>
            <div class="flex gap-1">
                <a href="#" class="text-sm font-semibold text-dark border-b-2 border-dark pb-0.5 px-2">My Cafes</a>
            </div>
        </div>
        <div class="flex items-center gap-5">
            <a href="#" class="text-sm text-muted">notifications</a>
            <a href="#" class="text-sm text-muted">settings</a>
            <div class="w-8 h-8 rounded-full bg-[#D6C9BD] flex items-center justify-center text-xs font-semibold text-[#4A4037]">JS</div>
        </div>
    </nav>

    <!-- LAYOUT -->
    <div class="flex min-h-[calc(100vh-49px)]">

        <!-- SIDEBAR -->
        <aside class="w-[200px] min-w-[200px] border-r border-border bg-cream flex flex-col justify-between px-4 py-6">
            <div>
                <div class="mb-5">
                    <p class="text-sm font-semibold text-dark leading-snug">SAFE<br>Saran Kafe</p>
                    <p class="text-[10px] uppercase tracking-widest text-muted mt-1">Owner Dashboard</p>
                </div>
                <nav class="flex flex-col gap-1 mt-2">
                    <a href="#" class="flex items-center gap-1.5 text-[11px] font-medium text-white bg-dark px-2.5 py-2 rounded-lg">
                        <span class="text-[10px] text-[#888]">storefront</span> MY CAFES
                    </a>
                </nav>
            </div>
            <div>
                <a href="{{ route('add-cafe') }}" class="w-full bg-darkbrown text-white text-[11px] font-bold uppercase tracking-wider rounded-full py-2.5 px-4">
                    ADD NEW BRANCH
                </a>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 px-8 py-7">

            <!-- HEADER -->
            <div class="flex items-start justify-between mb-7">
                <div>
                    <h2 class="text-2xl font-semibold text-dark">My Branches</h2>
                    <p class="text-xs text-muted mt-1.5 max-w-sm">Managing the physical heartbeat of <em>Velvet &amp; Vine</em> across the city's finest postcodes.</p>
                </div>
                <a href="{{ route('add-cafe') }}" class="inline-block bg-darkbrown text-white text-xs font-semibold rounded-full px-5 py-2.5">
                    add New Cafe
                </a>
            </div>

            <!-- SECTION LABEL -->
            <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-1">My Cafes</p>
            <h3 class="text-lg font-semibold text-dark mb-4">Branch overview</h3>

            <!-- CARD 1 -->
            <div class="flex bg-white border border-border rounded-[18px] overflow-hidden mb-3.5">
                <div class="relative w-40 min-w-[160px]">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=400&q=80"
                         alt="Fitzrovia" class="w-full h-full object-cover" />
                    <span class="absolute top-2.5 left-2.5 bg-active text-white text-[9px] font-bold uppercase tracking-[0.16em] px-2 py-1 rounded-full">Active</span>
                </div>
                <div class="flex flex-col justify-between flex-1 p-4">
                    <div>
                        <p class="text-base font-semibold text-dark">Velvet &amp; Vine — Fitzrovia</p>
                        <p class="text-xs text-muted mt-0.5">location_on 12 Charlotte St, London W1T 2LU</p>
                        <div class="flex gap-3 mt-3">
                            <div class="bg-stat rounded-xl px-3.5 py-2.5 min-w-[100px]">
                                <p class="text-[9px] uppercase tracking-[0.18em] text-muted">Weekly Footfall</p>
                                <p class="text-lg font-semibold text-dark mt-1">1,240</p>
                            </div>
                            <div class="bg-stat rounded-xl px-3.5 py-2.5 min-w-[100px]">
                                <p class="text-[9px] uppercase tracking-[0.18em] text-muted">Avg Rating</p>
                                <p class="text-lg font-semibold text-dark mt-1">4.9</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between bg-stat rounded-full px-4 py-2 mt-3">
                        <a href="{{ route('cafe.edit') }}" class="text-xs font-semibold text-dark">edit</a>
                        <button class="text-xs font-semibold text-red-600">delete</button>
                    </div>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="flex bg-white border border-border rounded-[18px] overflow-hidden mb-3.5">
                <div class="relative w-40 min-w-[160px]">
                    <img src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?auto=format&fit=crop&w=400&q=80"
                         alt="Soho" class="w-full h-full object-cover" />
                    <span class="absolute top-2.5 left-2.5 bg-active text-white text-[9px] font-bold uppercase tracking-[0.16em] px-2 py-1 rounded-full">Active</span>
                </div>
                <div class="flex flex-col justify-between flex-1 p-4">
                    <div>
                        <p class="text-base font-semibold text-dark">Velvet &amp; Vine — Soho</p>
                        <p class="text-xs text-muted mt-0.5">location_on 47 Greek St, London W1D 4EE</p>
                        <div class="flex gap-3 mt-3">
                            <div class="bg-stat rounded-xl px-3.5 py-2.5 min-w-[100px]">
                                <p class="text-[9px] uppercase tracking-[0.18em] text-muted">Weekly Footfall</p>
                                <p class="text-lg font-semibold text-dark mt-1">2,105</p>
                            </div>
                            <div class="bg-stat rounded-xl px-3.5 py-2.5 min-w-[100px]">
                                <p class="text-[9px] uppercase tracking-[0.18em] text-muted">Avg Rating</p>
                                <p class="text-lg font-semibold text-dark mt-1">4.7</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between bg-stat rounded-full px-4 py-2 mt-3">
                        <a href="{{ route('cafe.edit') }}" class="text-xs font-semibold text-dark">edit</a>
                        <button class="text-xs font-semibold text-red-600">delete</button>
                    </div>
                </div>
            </div>

            <!-- EXPANSION -->
            <div class="border-2 border-dashed border-[#D9D5CC] bg-white rounded-[18px] py-11 text-center mt-2">
                <p class="text-[11px] uppercase tracking-[0.2em] text-[#A39B92] mb-3.5">add_business</p>
                <h3 class="text-lg font-semibold text-dark mb-2">Expansion Opportunity</h3>
                <p class="text-xs text-muted mb-5">Your next sensory destination is just a blueprint away.</p>
                <button class="bg-[#FEF9F5] border border-[#D9D5CC] rounded-full px-5 py-2.5 text-xs font-semibold text-brown uppercase tracking-wider">
                    IDENTIFY LOCATION
                </button>
            </div>

        </main>
    </div>

</body>
</html>