<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
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

            <form>
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#A67C52] outline-none"
                        placeholder="Enter your email">
                </div>

                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <label>Password</label>
                        <a href="#" class="text-[#6B4F3B]">Forgot?</a>
                    </div>
                    <input type="password"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#A67C52] outline-none"
                        placeholder="********">
                </div>

                <div class="mb-4 flex items-center gap-2 text-sm">
                    <input type="checkbox">
                    <span>Keep me signed in</span>
                </div>

                <button class="w-full bg-[#6B4F3B] text-white py-2 rounded-lg hover:bg-[#5a3f2e] transition">
                    Sign In
                </button>
            </form>

            <p class="text-sm text-center mt-6">
                New here?
                <a href="register" class="text-[#6B4F3B] font-medium">Create account</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>