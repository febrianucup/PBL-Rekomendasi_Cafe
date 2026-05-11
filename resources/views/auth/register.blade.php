<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SignUp</title>
  <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .serif-title {
      font-family: 'Playfair Display', serif;
    }
  </style>
</head>

<body class="m-0 p-0 overflow-x-hidden bg-white">

  <div class="flex flex-col md:flex-row w-full h-screen bg-white">

    <div class="relative w-full md:w-1/2 h-screen bg-[#515744] overflow-hidden group">
      <img
        src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop"
        class="absolute inset-0 opacity-60 mix-blend-overlay transition-transform duration-[2000ms] group-hover:scale-105"
        style="object-fit: cover; width: 100%; height: 100vh;"
        alt="Interior Cafe">

      <div class="relative z-10 h-full p-12 flex flex-col justify-center">
        <h1 class="serif-title italic text-5xl md:text-6xl text-white leading-tight mb-6">
          The Sensory<br>Editorial
        </h1>
        <p class="text-white/90 text-sm md:text-base max-w-xs leading-relaxed font-light">
          Curating the world's most intimate brewing spaces, one cup at a time.
        </p>

        <div class="mt-auto pt-10">
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
      <div class="max-w-sm mx-auto w-full">

        <header class="mb-10">
          <h2 class="serif-title text-3xl text-[#3E2723] mb-2">Create Account</h2>
          <p class="text-gray-500 text-sm leading-relaxed">
            Join the editorial and discover your next favorite brew.
          </p>
        </header>

        <div class="relative grid grid-cols-2 mb-8 rounded-3xl bg-[#F3EEE5] p-1">
          <!-- Background Indicator -->
          <div id="tab-indicator" class="absolute top-1 bottom-1 left-1 w-[calc(50%-0.25rem)] bg-white rounded-3xl shadow-sm transition-transform duration-300 ease-out"></div>
          
          <button type="button" onclick="switchTab('guest')" id="guest-tab" class="relative z-10 text-sm font-semibold py-3 transition-colors duration-300 text-[#2d1e13]">
            GUEST
          </button>
          <button type="button" onclick="switchTab('owner')" id="owner-tab" class="relative z-10 text-sm font-semibold py-3 transition-colors duration-300 text-gray-500 hover:text-[#2d1e13]">
            OWNER
          </button>
        </div>

        <form id="guest-form" method="POST" action="{{ route('register/guest') }}" class="tab-content space-y-5 transition-all duration-300 opacity-100 translate-y-0">
          
          @csrf <input type="hidden" name="account_type" value="guest">

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Username</label>
            <input
              type="text"
              name="username"
              value="{{ old('name') }}"
              placeholder="espresso_lover"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @error('name') ring-2 ring-red-500 @enderror"
              required
              autofocus>
          
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email Address</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="emailkamu@email.com"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @error('email') ring-2 ring-red-500 @enderror"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Password</label>
            <input
              type="password"
              name="password"
              placeholder="••••••••"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all @error('password') ring-2 ring-red-500 @enderror"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              placeholder="••••••••"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <button type="submit" class="w-full py-4 mt-4 bg-[#5D4037] text-white text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-[#4E342E] transition-colors shadow-lg">
            Create Account
          </button>
        </form>

        <form id="owner-form" method="POST" action="{{ route('register/owner') }}" class="tab-content hidden space-y-5 transition-all duration-300 opacity-0 translate-y-4">
          @csrf <input type="hidden" name="account_type" value="owner">

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Username</label>
            <input
              type="text"
              name="username"
              placeholder="espresso_lover"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Cafe Name</label>
            <input
              type="text"
              name="cafe_name"
              placeholder="My Awesome Cafe"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Location</label>
            <input
              type="text"
              name="address"
              placeholder="Street, City, Country"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email Address</label>
            <input
              type="email"
              name="email"
              placeholder="your@email.com"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Password</label>
            <input
              type="password"
              name="password"
              placeholder="••••••••"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              placeholder="••••••••"
              class="w-full px-5 py-3.5 rounded-2xl bg-[#EBE9E1] border-none focus:ring-2 focus:ring-[#5D4037] outline-none text-sm transition-all"
              required>
          </div>

          <button type="submit" class="w-full py-4 mt-4 bg-[#5D4037] text-white text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-[#4E342E] transition-colors shadow-lg">
            Create Account
          </button>
        </form>

        <div class="mt-12 text-center">
          <p class="text-xs text-gray-500">
            Already have an account?
            <a href="{{ route('login/form') }}" class="text-[#3E2723] font-bold hover:underline ml-1 cursor-pointer">Sign in</a>
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
    function switchTab(tab) {
      const guestTab = document.getElementById('guest-tab');
      const ownerTab = document.getElementById('owner-tab');
      const guestForm = document.getElementById('guest-form');
      const ownerForm = document.getElementById('owner-form');
      const tabIndicator = document.getElementById('tab-indicator');

      if (tab === 'guest') {
        // Update Indicator and Texts
        tabIndicator.style.transform = 'translateX(0)';
        guestTab.classList.remove('text-gray-500');
        guestTab.classList.add('text-[#2d1e13]');
        ownerTab.classList.remove('text-[#2d1e13]');
        ownerTab.classList.add('text-gray-500');
        
        // Hide Owner Form
        ownerForm.classList.remove('opacity-100', 'translate-y-0');
        ownerForm.classList.add('opacity-0', 'translate-y-4');
        
        setTimeout(() => {
          ownerForm.classList.add('hidden');
          guestForm.classList.remove('hidden');
          
          // Slight delay for rendering before starting animation
          setTimeout(() => {
            guestForm.classList.remove('opacity-0', 'translate-y-4');
            guestForm.classList.add('opacity-100', 'translate-y-0');
          }, 20);
        }, 300);
        
      } else {
        // Update Indicator and Texts
        tabIndicator.style.transform = 'translateX(100%)';
        ownerTab.classList.remove('text-gray-500');
        ownerTab.classList.add('text-[#2d1e13]');
        guestTab.classList.remove('text-[#2d1e13]');
        guestTab.classList.add('text-gray-500');

        // Hide Guest Form
        guestForm.classList.remove('opacity-100', 'translate-y-0');
        guestForm.classList.add('opacity-0', 'translate-y-4');
        
        setTimeout(() => {
          guestForm.classList.add('hidden');
          ownerForm.classList.remove('hidden');
          
          // Slight delay for rendering before starting animation
          setTimeout(() => {
            ownerForm.classList.remove('opacity-0', 'translate-y-4');
            ownerForm.classList.add('opacity-100', 'translate-y-0');
          }, 20);
        }, 300);
      }
    }
  </script>

</body>

</html>