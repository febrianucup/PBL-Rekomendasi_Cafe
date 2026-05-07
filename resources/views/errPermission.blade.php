<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permission Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <section>
        <div class="min-h-[80vh] flex items-center justify-center px-4">
            <div class="max-w-md w-full text-center space-y-8">
                
                <div class="relative">
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <span class="text-[12rem] font-serif font-bold text-dark-brown select-none">403</span>
                    </div>
                    <div class="relative flex justify-center">
                        <div class="bg-light-beige/30 p-8 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-dark-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h2 class="font-serif text-4xl font-bold text-dark-brown tracking-tight">
                        Akses Terbatas
                    </h2>
                    <p class="text-gray-500 text-lg leading-relaxed">
                        Mohon maaf, kamu tidak memiliki akses untuk menuju konten ini.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                    <a href="{{ url()->previous() }}" 
                    class="w-full sm:w-auto px-8 py-3 bg-black border-2 border-light-beige text-white font-bold rounded-full hover:opacity-70 transition duration-200">
                        Go Back
                    </a>
                    <a href="/" 
                    class="w-full sm:w-auto px-8 py-3 bg-yellow-500 text-white font-bold rounded-full hover:opacity-90 shadow-lg shadow-dark-brown/20 transition duration-200">
                        Return Home
                    </a>
                </div>

                <p class="text-sm text-gray-400 pt-8">
                    Jika kamu yakin ini adalah eror, silahkan hubungi admin.
                </p>
                
            </div>
        </div>
    </section>
</body>
</html>