<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .serif-title {
            font-family: 'Playfair Display', serif;
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="m-0 p-0 overflow-x-hidden bg-white">

<div class="flex flex-col md:flex-row w-full h-screen bg-white">

    <div class="relative w-full md:w-1/2 h-screen bg-[#515744] overflow-hidden hidden md:flex group">
        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb"
             class="absolute inset-0 opacity-60 mix-blend-overlay transition-transform duration-[2000ms] group-hover:scale-105"
             style="object-fit: cover; width: 100%; height: 100vh;"
             alt="Cafe Image">

        <div class="relative z-10 h-full p-12 flex flex-col justify-center">
            <h1 class="serif-title italic text-5xl md:text-6xl text-white leading-tight mb-6 fade-in">
                SAFE<br>(Saran Cafe)
            </h1>
            <p class="text-white/90 text-sm md:text-base max-w-xs leading-relaxed font-light fade-in" style="animation-delay: 0.2s;">
                Curating the world's most evocative coffee spaces.
                Your seat is waiting.
            </p>
            
            <div class="mt-auto pt-10 fade-in" style="animation-delay: 0.4s;">
              <div class="flex items-center gap-3">
                <div class="h-[1px] w-8 bg-white/40"></div>
                <span class="text-[10px] tracking-[0.2em] text-white/60 uppercase font-medium">
                  Est. 2024 — Portfolio of Taste
                </span>
              </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/2 h-screen overflow-y-auto bg-[#F9F8F3] p-8 md:p-16 flex flex-col justify-center">
        <div class="max-w-sm mx-auto w-full fade-in" style="animation-delay: 0.3s;">

            <header class="mb-10">
                <h2 class="serif-title text-3xl text-[#3E2723] mb-2">
                    Welcome back
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Please enter your details to continue your journey.
                </p>
            </header>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                @if(session('success'))
                <div class="bg-[#BFE3B4] border-l-4 border-[#5D4037] p-4 mb-6 rounded-r-xl shadow-sm transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-[#5D4037]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-[#3E2723]">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @error('email') ring-2 ring-red-500 @enderror"
                        placeholder="your@email.com">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Password</label>
                        <a href="{{ route('forgot-password') }}" class="text-[10px] text-[#5D4037] hover:underline font-bold uppercase tracking-wider">Forgot?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2 mt-2">
                    <input type="checkbox" name="remember" id="remember" 
                        class="rounded border-gray-300 text-[#5D4037] focus:ring-[#5D4037] w-4 h-4 transition-colors">
                    <label for="remember" class="text-sm text-gray-500">Keep me signed in</label>
                </div>

                <button type="submit" class="w-full py-4 mt-6 bg-[#5D4037] text-white text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-[#4E342E] transition-colors shadow-lg">
                    Sign In
                </button>
            </form>
            
            <div class="mt-12 text-center">
                <p class="text-xs text-gray-500">
                    New here?
                    <a href="{{ route('register') }}" class="text-[#3E2723] font-bold hover:underline ml-1 cursor-pointer">Create account</a>
                </p>
            </div>
            
            <footer class="mt-12 md:mt-20">
                <p class="text-[9px] text-center text-gray-400 uppercase tracking-[0.15em]">
                    © 2026 THE SENSORY EDITORIAL. ALL RIGHTS RESERVED.
                </p>
            </footer>

        </div>
    </div>

</div>

</body>
</html>