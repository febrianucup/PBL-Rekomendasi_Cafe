@props(['id', 'title' => 'Hapus Data', 'message' => 'Apakah Anda yakin ingin menghapus ini?'])

<div x-data="{ open: false }" 
     @open-delete-modal-{{ $id }}.window="open = true" 
     @close-delete-modal-{{ $id }}.window="open = false"
     x-cloak>
    
    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 z-[9999] flex items-center justify-center">
            <div x-show="open" x-transition.opacity @click="open = false" 
                 class="absolute inset-0 bg-dark-brown/40 backdrop-blur-sm"></div>

            <div x-show="open" x-transition.scale.90
                 class="relative w-full max-w-sm bg-white p-8 rounded-[32px] shadow-2xl border border-stone-100 mx-4 text-center">
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-gray-500 mb-8">{{ $message }}</p>

                <div class="flex gap-3">
                    <button @click="open = false" class="flex-1 px-6 py-3 rounded-2xl border border-stone-200 font-semibold hover:bg-stone-50 transition-colors">
                        Batal
                    </button>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>