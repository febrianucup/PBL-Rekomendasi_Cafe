<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.forgot_password_title') }} - The Sensory Editorial</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .bg-cream { background-color: #FBFBF9; }
        
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
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
<body class="bg-cream antialiased overflow-x-hidden">

    <div class="flex flex-col md:flex-row min-h-screen">
        
        <!-- Sisi Kiri: Visual Editorial -->
        <div class="relative w-full md:w-1/2 h-64 md:h-screen bg-[#515744] overflow-hidden flex items-center justify-center md:justify-start">
            <img
                src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop"
                class="absolute inset-0 opacity-50 mix-blend-overlay object-cover w-full h-full"
                alt="Interior Cafe"
            >
            
            <div class="relative z-10 p-8 md:p-20 fade-in">
               <h1 class="serif-title text-6xl md:text-7xl text-white leading-none mb-6 fade-in tracking-[0.08em]">
                    SAFE<br>
                    <span class="block text-base md:text-lg font-normal tracking-[0.35em] uppercase not-italic mt-1 ml-2">
                        SARAN KAFE
                    </span>
                </h1>
                
                <div class="mt-12 items-center gap-3 hidden md:flex">
                    <div class="h-[1px] w-8 bg-white/40"></div>
                    <span class="text-[10px] tracking-[0.2em] text-white/60 uppercase font-medium">
                        {{ __('messages.portfolio_of_taste') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Lupa Password -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 md:p-16 bg-cream relative">
            
            <div class="w-full max-w-sm fade-in" style="animation-delay: 0.2s;">
                <!-- Header -->
                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-serif text-[#402B27] font-semibold mb-4">{{ __('messages.forgot_password') }}</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ __('messages.forgot_password_desc') }}
                    </p>
                </div>

                <!-- Alert Laravel Status -->
                @if (session('status'))
                    <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">
                            {{ __('messages.email_address') }}
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            placeholder="hello@example.com"
                            class="w-full px-6 py-4 bg-[#EBE7E0]/50 border border-transparent focus:border-[#5C453C] rounded-2xl text-[#402B27] outline-none transition-all duration-300 placeholder-gray-400"
                        >
                        @error('email')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#5C453C] hover:bg-[#4A342D] text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-full shadow-xl shadow-brown-900/10 transition-all duration-300 transform hover:-translate-y-0.5">
                        {{ __('messages.send_reset_link') }}
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-12 text-center">
                    <a href="/login" class="text-xs text-gray-400 hover:text-[#402B27] transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_sign_in') }}
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="absolute bottom-8 text-center w-full">
                <p class="text-[9px] text-gray-400 font-medium tracking-[0.2em] uppercase">
                    &copy; 2026 THE SENSORY EDITORIAL
                </p>
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