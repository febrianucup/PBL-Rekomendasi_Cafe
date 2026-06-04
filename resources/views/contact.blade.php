@extends('layouts.public')

@section('title', 'Cafe List')
    @stack('scripts')

    @section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#3B2519] mb-4">{{ __('messages.contact_us') }}</h1>
                <p class="text-sm text-gray-600 mb-10 leading-relaxed">
                    {{ __('messages.contact_desc') }}
                </p>

                <form action="#" method="POST" class="space-y-8">
                    @csrf 
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="text" id="first_name" name="first_name" class="w-full bg-transparent border-b border-gray-300 py-2 focus:outline-none focus:border-[#3B2519] placeholder-transparent peer" placeholder="{{ __('messages.first_name') }} *" required>
                            <label for="first_name" class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#3B2519]">{{ __('messages.first_name') }} *</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="last_name" name="last_name" class="w-full bg-transparent border-b border-gray-300 py-2 focus:outline-none focus:border-[#3B2519] placeholder-transparent peer" placeholder="{{ __('messages.last_name') }} *" required>
                            <label for="last_name" class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#3B2519]">{{ __('messages.last_name') }} *</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="email" id="email" name="email" class="w-full bg-transparent border-b border-gray-300 py-2 focus:outline-none focus:border-[#3B2519] placeholder-transparent peer" placeholder="{{ __('messages.email') }} *" required>
                            <label for="email" class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#3B2519]">{{ __('messages.email') }} *</label>
                        </div>
                        <div class="relative">
                            <input type="tel" id="phone" name="phone" class="w-full bg-transparent border-b border-gray-300 py-2 focus:outline-none focus:border-[#3B2519] placeholder-transparent peer" placeholder="{{ __('messages.phone_number') }}">
                            <label for="phone" class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#3B2519]">{{ __('messages.phone_number') }}</label>
                        </div>
                    </div>
                    <div class="relative">
                        <textarea id="message" name="message" rows="3" class="w-full bg-transparent border-b border-gray-300 py-2 focus:outline-none focus:border-[#3B2519] placeholder-transparent peer resize-none" placeholder="{{ __('messages.message') }} *" required></textarea>
                        <label for="message" class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-[#3B2519]">{{ __('messages.message') }} *</label>
                    </div>

                    <div>
                        <button type="submit" class="px-8 py-2.5 rounded-full border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition font-medium text-sm">
                            {{ __('messages.send') }}
                        </button>
                    </div>
                </form>

                <div class="mt-16">
                    <h2 class="text-2xl font-serif font-bold text-[#3B2519] mb-4">{{ __('messages.polinema_tagline') }}</h2>
                    <div class="text-sm text-gray-800 leading-relaxed space-y-1">
                        <p><strong>{{ __('messages.place') }}:</strong> Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141</p>
                        <p><strong>{{ __('messages.telp') }}:</strong> (0341) 404424</p>
                        <p><strong>{{ __('messages.email') }}:</strong> admin@polinema.ac.id</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <h1 class="text-4xl lg:text-5xl font-serif font-bold text-[#3B2519] leading-tight mb-8">
                    @if(app()->getLocale() == 'en')
                        Contact Us - <br>
                        Discuss your <span class="italic">business needs</span> with us
                    @else
                        Hubungi Kami - <br>
                        Diskusikan <span class="italic">kebutuhan bisnis</span> Anda dengan kami
                    @endif
                </h1>
                
                <div class="relative z-10">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ __('messages.interior_alt') }}" class="w-full h-[500px] object-cover rounded-tl-[80px] rounded-br-[80px] rounded-tr-lg rounded-bl-lg shadow-xl">
                    
                    <div class="absolute -bottom-10 -left-10 -z-10 text-[#C1A87D] opacity-60">
                        <svg width="200" height="200" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="0.5">
                            <path d="M10,90 Q30,50 90,10 M20,90 Q40,60 80,30 M30,90 Q50,70 70,50" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection