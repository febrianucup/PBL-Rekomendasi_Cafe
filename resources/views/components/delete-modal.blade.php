@props(['id' => 'deleteModal', 'title' => null, 'message' => null, 'action' => null])

@if(!$action)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center">
        <div class="absolute inset-0 bg-dark-brown/40 backdrop-blur-sm"></div>

        <div class="relative w-full max-w-sm bg-white p-8 rounded-[32px] shadow-2xl border border-stone-100 mx-4 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title ?? __('messages.delete_data_title') }}</h3>
            <p class="text-gray-500 mb-8">{{ $message ?? __('messages.delete_data_message') }}</p>

            <div class="flex gap-3">
                <button wire:click="closeDeleteModal" type="button" class="flex-1 px-6 py-3 rounded-2xl border border-stone-200 font-semibold hover:bg-stone-50 transition-colors">
                    {{ __('messages.cancel') ?? 'Batal' }}
                </button>
                {{ $slot }}
            </div>
        </div>
    </div>
@else
    <template x-teleport="body">
        <div x-show="confirmDelete" class="fixed inset-0 z-[9999] flex items-center justify-center" x-cloak>
            <div x-show="confirmDelete" x-transition.opacity @click="confirmDelete = false" class="absolute inset-0 bg-dark-brown/40 backdrop-blur-sm"></div>

            <div x-show="confirmDelete" x-transition.scale.90 class="relative w-full max-w-sm bg-white p-8 rounded-[32px] shadow-2xl border border-stone-100 mx-4 text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title ?? __('messages.delete_data_title') }}</h3>
                <p class="text-gray-500 mb-8">{{ $message ?? __('messages.delete_data_message') }}</p>

                <div class="flex gap-3">
                    <button @click="confirmDelete = false" type="button" class="flex-1 px-6 py-3 rounded-2xl border border-stone-200 text-gray-500 font-semibold hover:bg-stone-50 transition-colors">
                        {{ __('messages.cancel') ?? 'Batal' }}
                    </button>
                    <form action="{{ $action }}" method="POST" class="flex-1 m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-3 rounded-2xl bg-red-500 text-white font-semibold hover:bg-red-600 transition-all">
                            {{ __('messages.yes_delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
@endif
