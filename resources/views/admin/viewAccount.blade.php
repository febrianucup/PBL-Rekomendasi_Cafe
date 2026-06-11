@extends('layouts.admin')

@section('content')
<div x-data="{ confirmDelete: false }" class="max-w-5xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">
                Profil Akun
            </h2>
            <p class="text-gray-500 mt-2 text-lg">
                Ikhtisar detail dari akun anggota ini.
            </p>
        </div>

        <a href="{{ route('accounts.index') }}"
           class="bg-light-beige text-dark-brown px-6 py-3 rounded-full font-bold hover:bg-cream transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-[2rem] shadow-lg border border-light-beige/30 p-10">

        <!-- User Info -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div class="flex items-center gap-6">
                <div class="relative">
                    <img 
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=F5F1EC&color=4B2E2B&size=128"
                        alt="Avatar"
                        class="w-28 h-28 rounded-full border-4 border-cream object-cover"
                    >
                    @if($user->email_verified_at)
                        <span class="absolute bottom-1 right-1 bg-soft-green p-1.5 rounded-full border-4 border-white" title="Verified">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>

                <div>
                    <h3 class="font-serif text-4xl font-bold text-dark-brown">
                        {{ $user->username }}
                    </h3>

                    <p class="text-gray-500 text-lg mt-1">
                        {{ $user->email }}
                    </p>

                    <span class="inline-block mt-3 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest
                        {{ $user->role == 'owner' ? 'bg-dark-brown text-white' : 'bg-light-beige text-dark-brown' }}">
                        {{ $user->role->name }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                @if($user->status === 'pending')
                    <form action="{{ route('accounts.status', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="bg-soft-green text-white px-6 py-4 rounded-full font-bold hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                            Terima
                        </button>
                    </form>
                    <form action="{{ route('accounts.status', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="bg-[#DC143C] text-white px-6 py-4 rounded-full font-bold hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                            Tolak
                        </button>
                    </form>
                @endif
            </div>
        </div>

      <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    ID Pengguna
                </p>
                <p class="text-2xl font-bold text-dark-brown">
                    #{{ $user->id }}
                </p>
            </div>

            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    Tanggal Bergabung
                </p>
                <p class="text-2xl font-bold text-dark-brown">
                    {{ $user->created_at->format('F d, Y') }}
                </p>
            </div>
        </div>

        <!-- Danger Zone -->
        @if(auth()->id() !== $user->id)
        <div class="mt-14 pt-8 border-t border-light-beige/40">
            <p class="text-gray-500 mb-6">Setelah dihapus, akun ini dan seluruh data terkaitnya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

            <button 
                @click="confirmDelete = true"
                type="button"
                class="bg-[#DC143C] text-white px-8 py-4 rounded-full font-bold hover:bg-[#8B0000] hover:text-white transition-all duration-200"
            >
                Hapus Akun Anggota
            </button>

            <!-- Delete Confirmation Modal -->
            <x-delete-modal action="{{ route('accounts.destroy', $user->id) }}" title="{{ __('messages.delete_account_title') }}" message="{{ __('messages.delete_account_message', ['name' => $user->username]) }}" />
        </div>
        @else
        <div class="mt-14 pt-8 border-t border-light-beige/40">
            <p class="text-gray-400 italic text-sm text-center">Anda tidak dapat menghapus akun Anda sendiri dari panel manajemen.</p>
        </div>
        @endif

    </div>
</div>
@endsection