<!-- resources/views/components/logout-modal.blade.php -->
<div x-data="{ open: false }" 
     @open-logout-modal.window="open = true" 
     x-cloak>
    
    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 z-[99] flex items-center justify-center">
            <!-- Backdrop -->
            <div x-show="open" 
                 x-transition.opacity
                 @click="open = false" 
                 class="absolute inset-0 bg-dark-brown/40 backdrop-blur-sm"></div>

            <!-- Modal Box -->
            <div x-show="open" 
                 x-transition.scale.90
                 class="relative w-full max-w-sm bg-white p-8 rounded-[32px] shadow-2xl border border-cream mx-4 text-center">
                
                <h3 class="text-xl font-bold text-dark-brown mb-2">Konfirmasi Keluar</h3>
                <p class="text-gray-500 mb-8">Apakah Anda yakin ingin logout dari PBL Cafe?</p>

                <div class="flex gap-3">
                    <button @click="open = false" class="flex-1 px-6 py-3 rounded-2xl border border-cream text-gray-500 font-semibold hover:bg-cream transition-colors">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1 m-0">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 rounded-2xl bg-dark-brown text-white font-semibold hover:shadow-lg transition-all">
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>