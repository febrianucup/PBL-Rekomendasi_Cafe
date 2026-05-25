<div x-data="{ selectedImage: null }" @open-image.window="selectedImage = $event.detail" x-cloak>
    <template x-if="selectedImage">
        <div class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/80 p-4" 
             @click="selectedImage = null">
            <img :src="selectedImage" class="max-w-full max-h-full rounded-2xl shadow-2xl" @click.stop>
        </div>
    </template>
</div>