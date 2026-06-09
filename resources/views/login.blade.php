<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
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
        /* Page Transitions */
        body {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        body.page-loaded {
            opacity: 1;
        }
        body.page-fade-out {
            opacity: 0;
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
            <h1 class="serif-title text-6xl md:text-7xl text-white leading-none mb-6 fade-in tracking-[0.08em]">
                SAFE<br>
                <span class="block text-base md:text-lg font-normal tracking-[0.35em] uppercase not-italic mt-1 ml-2">
                    SARAN KAFE
                </span>
            </h1>
            <p class="text-white/90 text-sm md:text-base max-w-xs leading-relaxed font-light fade-in" style="animation-delay: 0.2s;">
                {{ __('messages.login_desc') }}
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

    <div class="relative w-full md:w-1/2 h-screen overflow-y-auto bg-[#F9F8F3] p-8 md:p-16 flex flex-col justify-center">


        <div class="max-w-sm mx-auto w-full fade-in" style="animation-delay: 0.3s;">

            <header class="mb-10">
                <h2 class="serif-title text-3xl text-[#3E2723] mb-2">
                    {{ __('messages.welcome_back') }}
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    {{ __('messages.login_instruction') }}
                </p>
            </header>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                @if(session('success'))
                    <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
                @endif

                @if($errors->has('loginError'))
                <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ $errors->first('loginError') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @if($errors->has('email') || $errors->has('loginError')) ring-2 ring-red-500 @endif"
                        placeholder="your@email.com">
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('messages.password') }}</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] text-[#5D4037] hover:underline font-bold uppercase tracking-wider">{{ __('messages.forgot') }}</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @if($errors->has('loginError')) ring-2 ring-red-500 @endif"
                        placeholder="••••••••">
                </div>

                  <div class="flex items-center gap-2 mt-2">

                    <input type="checkbox" name="remember" id="remember"

                        class="rounded border-gray-300 text-[#5D4037] focus:ring-[#5D4037] w-4 h-4 transition-colors">

                    <label for="remember" class="text-sm text-gray-500">{{ __('messages.keep_signed_in') }}</label>

                </div>

                <button type="submit" class="w-full py-4 mt-6 bg-[#5D4037] text-white text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-[#4E342E] active:scale-[0.98] transition-all shadow-lg">
                    {{ __('messages.sign_in') }}
                </button>
            </form>     
            <div class="mt-12 text-center">
                <p class="text-xs text-gray-500">
                    {{ __('messages.new_here') }}
                    <a href="{{ route('register') }}" class="text-[#3E2723] font-bold hover:underline ml-1 cursor-pointer">{{ __('messages.create_account') }}</a>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.body.classList.add('page-loaded');

        document.querySelectorAll('a').forEach(link => {
            if (
                link.target === '_blank' ||
                link.getAttribute('href') === null ||
                link.getAttribute('href').startsWith('#') ||
                link.getAttribute('href').startsWith('javascript:') ||
                link.hasAttribute('download')
            ) {
                return;
            }

            const href = link.getAttribute('href');
            const isInternal = href.startsWith('/') || href.startsWith(window.location.origin);

            if (isInternal) {
                link.addEventListener('click', e => {
                    if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) {
                        return;
                    }
                    e.preventDefault();
                    document.body.classList.remove('page-loaded');
                    document.body.classList.add('page-fade-out');

                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                });
            }
        });
    });

    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            document.body.classList.remove('page-fade-out');
            document.body.classList.add('page-loaded');
        }
    });
</script>
</body>
</html>