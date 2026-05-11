<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="icon" type="image/x-icon" href="/img/asset/favicon-32x32.png">
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - The Sensory Editorial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Import Google Fonts: Playfair Display (Serif) & Inter (Sans-Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        
        /* Palet Warna Khusus */
        .bg-cream { background-color: #FBFBF9; }
        .text-brown-dark { color: #402B27; }
        .bg-brown-btn { background-color: #5C453C; }
        .bg-brown-btn-hover { background-color: #4A342D; }
        .bg-input-gray { background-color: #EBE7E0; }
        .border-brown { border-color: #5C453C; }
    </style>
</head>
<body class="font-sans antialiased text-gray-600 min-h-screen flex">

    <!-- Sisi Kiri: Gambar & Teks Editorial (Disembunyikan di layar kecil) -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1529892485649-6407a4a611c6?q=80&w=2070&auto=format&fit=crop');">
        <!-- Overlay gelap agar teks putih lebih terbaca -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <!-- Konten Kiri Atas -->
        <div class="absolute top-16 left-16 z-10">
            <h1 class="text-white font-serif italic font-bold text-6xl leading-tight mb-4">
                The Sensory<br>Editorial
            </h1>
            <p class="text-white text-lg max-w-sm leading-relaxed">
                Curating the world's most intimate brewing spaces, one cup at a time.
            </p>
        </div>

        <!-- Konten Kiri Bawah -->
        <div class="absolute bottom-12 left-16 z-10 flex items-center">
            <div class="w-8 h-[1px] bg-white mr-4"></div>
            <p class="text-white text-xs font-semibold tracking-[0.2em] uppercase">
                EST. 2024 — PORTFOLIO OF TASTE
            </p>
        </div>
    </div>

    <!-- Sisi Kanan: Form Lupa Password -->
    <div class="w-full lg:w-1/2 bg-cream flex flex-col justify-center items-center p-8 relative">
        
        <div class="w-full max-w-md">
            <!-- Header Form -->
            <div class="mb-8">
                <h2 class="text-4xl font-serif text-brown-dark font-semibold mb-3">Forgot Password</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    No problem. Just let us know your email address and we will email you a password reset link.
                </p>
            </div>

            <!-- Alert Sukses (Jika email berhasil dikirim) -->
            @if (session('status'))
                <div class="mb-6 font-medium text-sm text-green-700 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Input Email -->
                <div class="mb-6">
                    <label for="email" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com"
                           class="w-full px-5 py-3 bg-input-gray border border-brown rounded-2xl text-brown-dark focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-[#5C453C] transition-all placeholder-gray-400 @error('email') border-red-500 @enderror">
                    
                    <!-- Pesan Error Validasi -->
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-full shadow-lg text-[11px] font-bold text-white bg-brown-btn hover:bg-brown-btn-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5C453C] transition-colors duration-300 uppercase tracking-[0.15em]">
                        Email Password Reset Link
                    </button>
                </div>
            </form>

            <!-- Link Kembali ke Login -->
            <div class="mt-10 text-center">
                <p class="text-sm text-gray-500">
                    Remember your password? 
                    <a href="/login" class="text-brown-dark font-semibold hover:underline">
                        Sign in
                    </a>
                </p>
            </div>
        </div>

        <!-- Copyright Footer Kanan -->
        <div class="absolute bottom-12 text-center w-full">
            <p class="text-[10px] text-gray-400 font-semibold tracking-widest uppercase">
                &copy; 2026 THE SENSORY EDITORIAL. ALL RIGHTS RESERVED.
            </p>
        </div>

    </div>

</body>
</html>