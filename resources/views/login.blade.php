<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="h-screen">

<div class="grid grid-cols-1 md:grid-cols-2 h-full">

    <div class="hidden md:flex relative">
        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb"
             class="w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/40"></div>

        <div class="absolute bottom-20 left-10 text-white max-w-md">
            <h1 class="text-5xl font-bold leading-tight mb-4">
                SAFE (Saran Cafe)
            </h1>
            <p class="text-lg">
                Curating the world's most evocative coffee spaces.
                Your seat is waiting.
            </p>
        </div>
    </div>

    <div class="flex items-center justify-center bg-[#F5F1EB] px-6">
        <div class="w-full max-w-md">

            <h2 class="text-3xl font-semibold mb-2 text-[#2D2D2D]">
                Welcome back
            </h2>
            <p class="text-gray-500 mb-6">
                Please enter your details to continue your journey
            </p>

            <form method="POST" action="{{ route('login') }}">
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

                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#A67C52] outline-none"
                        placeholder="Enter your email">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <label>Password</label>
                        <a href="{{ route('forgot-password') }}" class="text-[#6B4F3B] hover:underline">Forgot?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#A67C52] outline-none"
                        placeholder="********">
                </div>

                <div class="mb-4 flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" id="remember" 
                        class="rounded border-gray-300 text-[#6B4F3B] focus:ring-[#A67C52]">
                    <label for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="w-full bg-[#6B4F3B] text-white py-2 rounded-lg hover:bg-[#5a3f2e] transition">
                    Sign In
                </button>
            </form>
            <p class="text-sm text-center mt-6">
                New here?
                <a href="{{ route('register') }}" class="text-[#6B4F3B] font-medium">Create account</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>