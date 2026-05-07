@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-serif text-4xl font-bold text-dark-brown">
                Account Profile
            </h2>
            <p class="text-gray-500 mt-2 text-lg">
                Detailed overview of this member account.
            </p>
        </div>

        <a href="/admin/accounts"
           class="bg-light-beige text-dark-brown px-6 py-3 rounded-full font-bold hover:bg-cream transition">
            ← Back
        </a>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-[2rem] shadow-lg border border-light-beige/30 p-10">

        <!-- User Info -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div class="flex items-center gap-6">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=F5F1EC&color=4B2E2B"
                    alt="Avatar"
                    class="w-28 h-28 rounded-full border-4 border-cream"
                >

                <div>
                    <h3 class="font-serif text-4xl font-bold text-dark-brown">
                        {{ $user->name }}
                    </h3>

                    <p class="text-gray-500 text-lg mt-2">
                        {{ $user->email }}
                    </p>

                    <span class="inline-block mt-4 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest
                        {{ $user->role == 'owner' ? 'bg-dark-brown text-white' : 'bg-light-beige text-dark-brown border border-light-beige/50' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <!-- Edit Button -->
            <div>
                <a href="{{ route('accounts.edit', $user->id) }}"
                   class="bg-dark-brown text-white px-8 py-4 rounded-full font-bold hover:opacity-90 transition">
                    Edit Account
                </a>
            </div>
        </div>

        <!-- Details -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    User ID
                </p>
                <p class="text-2xl font-bold text-dark-brown">
                    #{{ $user->id }}
                </p>
            </div>

            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    Joined Date
                </p>
                <p class="text-2xl font-bold text-dark-brown">
                    {{ $user->created_at->format('F d, Y') }}
                </p>
            </div>

            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    Account Type
                </p>
                <p class="text-2xl font-bold text-dark-brown">
                    {{ ucfirst($user->role) }}
                </p>
            </div>

            <div class="bg-cream rounded-2xl p-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold mb-2">
                    Email Status
                </p>
                <p class="text-2xl font-bold text-soft-green">
                    Active
                </p>
            </div>

        </div>

        <!-- Delete -->
        <div class="mt-14 pt-8 border-t border-light-beige/40">
            <h4 class="text-red-600 font-bold text-xl mb-4">
                Danger Zone
            </h4>

            <form action="{{ route('accounts.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button 
                    type="submit"
                    onclick="return confirm('Are you sure you want to permanently delete this account?')"
                    class="bg-red-600 text-white px-8 py-4 rounded-full font-bold hover:bg-red-700 transition"
                >
                    Delete Account
                </button>
            </form>
        </div>

    </div>
</div>
@endsection