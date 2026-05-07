<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .serif-title { font-family: 'Playfair Display', serif; }
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
      <img
        src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop"
        class="absolute inset-0 opacity-60 mix-blend-overlay transition-transform duration-[2000ms] group-hover:scale-105"
        style="object-fit: cover; width: 100%; height: 100vh;"
        alt="Interior Cafe"
      >

      <div class="relative z-10 h-full p-12 flex flex-col justify-center">
        <h1 class="serif-title italic text-5xl md:text-6xl text-white leading-tight mb-6 fade-in">
            The Sensory<br>Editorial
        </h1>
        <p class="text-white/90 text-sm md:text-base max-w-xs leading-relaxed font-light fade-in" style="animation-delay: 0.2s;">
            Curating the world's most intimate brewing spaces, one cup at a time.
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
          <h2 class="serif-title text-3xl text-[#3E2723] mb-2">Forgot Password</h2>
          <p class="text-gray-500 text-sm leading-relaxed">
            No problem. Just let us know your email address and we will email you a password reset link.
          </p>
        </header>

        <!-- Session Status -->
        @if (session('status'))
            <div class="bg-[#BFE3B4] border-l-4 border-[#5D4037] p-4 mb-6 rounded-r-xl shadow-sm transition-all duration-300">
                <p class="text-sm font-medium text-[#3E2723]">{{ session('status') }}</p>
            </div>
        @endif

        <form action="#" method="POST" class="space-y-5">
          @csrf

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email Address</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="your@email.com"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @error('email') ring-2 ring-red-500 @enderror"
              required
              autofocus
            >
            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
          </div>

          <button type="submit" class="w-full py-4 mt-6 bg-[#5D4037] text-white text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-[#4E342E] transition-colors shadow-lg">
            Email Password Reset Link
          </button>
        </form>

        <div class="mt-12 text-center">
          <p class="text-xs text-gray-500">
            Remember your password?
            <a href="{{ route('login') }}" class="text-[#3E2723] font-bold hover:underline ml-1 cursor-pointer">Sign in</a>
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
