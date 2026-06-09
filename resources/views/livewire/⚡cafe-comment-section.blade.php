<div class="space-y-10 w-full h-full">
    @if (session()->has('success'))
        <div wire:poll.3s="$set('hideFlash', true)" class="{{ $hideFlash ? 'hidden' : '' }} fixed top-5 right-5 z-[9999] px-5 py-3 rounded-xl bg-green-300 text-brown shadow-xl text-sm font-semibold transition-all duration-500">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div wire:poll.3s="$set('hideFlash', true)" class="{{ $hideFlash ? 'hidden' : '' }} fixed top-5 right-5 z-[9999] px-5 py-3 rounded-xl bg-red-400 text-white shadow-xl text-sm font-semibold transition-all duration-500">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex gap-4 mb-6 border-b border-stone-200">
        <button type="button" wire:click="$set('commentType', 'review')" class="pb-2 font-bold {{ $commentType === 'review' ? 'border-b-2 border-black' : 'text-stone-400' }}">Review</button>
        <button type="button" wire:click="$set('commentType', 'discussion')" class="pb-2 font-bold {{ $commentType === 'discussion' ? 'border-b-2 border-black' : 'text-stone-400' }}">Komentar</button>
    </div>

    @php
        $isDiscussion = ($commentType === 'discussion');
        $isReview = ($commentType === 'review');

        $isOwner = (Auth::id() === $cafe->user_id);
        $isAdmin = (auth()->user()->role->name === 'admin');
    @endphp

    @auth
        @if($isDiscussion || ($isReview && !$isOwner && !$isAdmin && !$hasReviewed))
            <form wire:submit.prevent="submitComment">
                @if($commentType === 'review')
                    <span class="text-sm font-semibold text-gray-700">Rating:</span>
                    <div class="flex flex-row-reverse justify-end gap-1.5 mb-2">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" value="{{ $i }}" wire:model="rating_score" class="hidden peer">
                            <label for="star{{ $i }}" class="text-2xl text-stone-200 peer-checked:text-amber-400 cursor-pointer">★</label>
                        @endfor
                    </div>
                @endif

                <textarea wire:model="body" class="w-full min-h-[120px] p-4 border border-stone-200 rounded-xl" placeholder="Tulis {{ $commentType === 'review' ? 'Ulasan' : 'Diskusi' }} Anda..."></textarea>
                @error('body') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <div class="flex justify-between items-center mt-3">
                    <label class="cursor-pointer text-xs font-medium text-stone-500 hover:text-black bg-stone-200 px-3 py-1 rounded-lg">
                        Unggah Foto
                        <input type="file" wire:model="photos" multiple accept="image/*" class="hidden">
                    </label>
                    <button type="submit" class="px-6 py-2 bg-black text-white rounded-xl text-xs font-bold">Kirim</button>
                </div>
                
                @if($photos)
                    <div class="flex gap-2 mt-3 flex-wrap">
                        @foreach($photos as $index => $photo)
                        <div wire:key="photo-preview-{{ $index }}" class="w-40 h-40 rounded-xl overflow-hidden border border-stone-200">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover cursor-pointer" wire:click="$dispatch('open-image', { url: '{{ $photo->temporaryUrl() }}' })">
                        </div>
                    @endforeach
                    </div>
                @endif
            </form>
        @elseif($commentType === 'review' && $hasReviewed && !$isOwner && !$isAdmin)
            <p class="text-sm text-stone-500 bg-stone-100 p-4 rounded-xl text-center">
                Terima kasih telah memberikan ulasan untuk kafe ini.
            </p>
        @endif
    @endauth<div class="space-y-6">
    @forelse(($commentType === 'review' ? $reviews : $discussions) as $comment)
        <div wire:key="comment-{{ $comment->id }}" class="p-4 bg-stone-50 rounded-xl space-y-3 border border-stone-100">
            <div class="flex justify-between items-center mb-1">
                <div class="flex items-center">
                    <h3 class="font-bold text-l">{{ $comment->user->username }}</h3>
                    @php
                        $user = $comment->user;
                        $roleName = $user->role->name;
                        $isOwner = ($roleName === 'owner');
                        $isAdmin = ($roleName === 'admin');
                    @endphp
                    @if($isOwner || $isAdmin)
                        <span class="bg-dark-brown rounded-lg text-white m-2 p-1 text-xs font-bold">{{ $isAdmin ? 'admin' : 'owner' }}</span>
                    @endif
                    <div class="mx-2 h-1 w-1 rounded-full bg-stone-400"></div>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                <div class="flex gap-3">
                    @if(Auth::id() === $comment->user_id)
                        <button type="button" class="text-red-500 text-xs font-semibold" wire:click="confirmDelete({{ $comment->id }})">
                            Hapus
                        </button>
                    @endif
                </div>
            </div>
            @if($commentType === 'review' && $comment->rating_score)
                <div class="flex text-amber-400 mb-1 mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-xl">{{ $i <= $comment->rating_score ? '★' : '☆' }}</span>
                    @endfor
                </div>
            @endif
            
            <hr class="border-stone-200">
            <p class="text-sm text-gray-700 text-[15px]">{{ $comment->body }}</p>

            @if($comment->images)
                <div class="flex gap-2 flex-wrap">
                    @foreach(json_decode($comment->images, true) as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="w-25 h-25 object-cover rounded-lg cursor-pointer" wire:click="$dispatch('open-image', '{{ asset('storage/' . $img) }}')">
                    @endforeach
                </div>
            @endif
            
            @if(($commentType === 'review' && Auth::id() === $cafe->user_id) || $commentType === 'discussion')
                <button type="button" class="text-blue-500 text-xs font-semibold hover:underline" wire:click="toggleReply({{ $comment->id }})">
                    {{ $replyingToId == $comment->id ? 'Batal' : 'Balas' }}
                </button>

                @if($replyingToId == $comment->id)
                    <div class="mt-3 pl-4 border-l-2 border-stone-300">
                        <form wire:submit.prevent="submitReply({{ $comment->id }})">
                            <textarea wire:model.blur="reply_body" class="w-full p-2 text-sm border border-stone-200 rounded-lg" placeholder="Tulis balasan..."></textarea>
                            @error('reply_body') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            <button type="submit" class="mt-2 px-4 py-1 bg-black text-white rounded-lg text-xs font-bold">
                                Kirim Balasan
                            </button>
                        </form>
                    </div>
                @endif
            @endif

            @if($comment->replies->count() > 0)
                <div class="mt-4 space-y-3 pl-4 border-l-2 border-stone-200">
                    @foreach($comment->replies as $reply)
                        <div wire:key="reply-{{ $reply->id }}" class="text-sm">
                            <div class="flex justify-between items-center mb-1">
                                    <div class="flex items-center">
                                    <span class="font-bold text-lg">{{ $reply->user->username }}</span>
                                    @php
                                        $user = $reply->user;
                                        $roleName = $user->role->name;
                                        $isOwner = ($roleName === 'owner');
                                        $isAdmin = ($roleName === 'admin');
                                    @endphp
                                    @if($isOwner || $isAdmin)
                                        <span class="bg-dark-brown rounded-lg text-white m-2 p-1 text-xs font-bold">{{ $isAdmin ? 'admin' : 'owner' }}</span>
                                    @endif
                                    <div class="mx-2 h-1 w-1 rounded-full bg-stone-400"></div>
                                    <span class="text-[10px] text-stone-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex gap-3">
                                    @if(Auth::id() === $reply->user_id)
                                        <button type="button" class="text-red-500 text-xs font-semibold" wire:click="confirmDelete({{ $reply->id }})">
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mt-1 text-[15px]">{{ $reply->body }}</p>
                            <hr class="border-stone-200 mt-2">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <p class="text-center text-stone-400 py-4">Belum ada data.</p>
    @endforelse

    @if($isDeleteModalOpen)
        <x-delete-modal id="cafe-comment" title="Hapus Komentar" message="Apakah Anda yakin ingin menghapus komentar ini?">
            <div class="flex gap-4">
                <button wire:click="closeDeleteModal" class="flex-1 px-6 py-3 rounded-2xl bg-stone-200 text-stone-700 font-semibold hover:shadow-lg transition-all">
                    Batal
                </button>
                <button wire:click="deleteComment" class="flex-1 px-6 py-3 rounded-2xl bg-dark-brown text-white font-semibold hover:shadow-lg transition-all">
                    Ya, Hapus
                </button>
            </div>
        </x-delete-modal>
    @endif
    <x-image-modal />
</div>