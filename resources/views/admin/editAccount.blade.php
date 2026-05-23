@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Header -->
    <div>
        <h2 class="font-serif text-4xl font-bold text-dark-brown">
            Edit Account
        </h2>
        <p class="text-gray-500 mt-2 text-lg">
            Manage user profile details and permissions.
        </p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[2rem] shadow-lg border border-light-beige/30 p-10">

        <!-- Avatar -->
        <div class="flex items-center gap-6 mb-10">
            <img 
                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=F5F1EC&color=4B2E2B"
                alt="Avatar"
                class="w-24 h-24 rounded-full border-4 border-cream"
            >

            <div>
                <h3 class="font-serif text-3xl font-bold text-dark-brown">
                    {{ $user->name }}
                </h3>
                <p class="text-gray-500 mt-1">
                    Joined {{ $user->created_at->format('F Y') }}
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ $user->role && $user->role->name === 'owner' ? route('admin.owners.update', $user->id) : route('accounts.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Full Name
                </label>

                <input 
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 bg-gray-100 text-gray-500 cursor-not-allowed"
                    readonly
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Email Address
                </label>

                <input 
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 bg-gray-100 text-gray-500 cursor-not-allowed"
                    readonly
                >
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Role
                </label>
                <select 
                    name="role"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green"
                    {{ $user->role && $user->role->name === 'owner' ? 'disabled' : '' }}
                >
                    <option value="owner" {{ $user->role && $user->role->name == 'owner' ? 'selected' : '' }}>
                        Owner
                    </option>
                    <option value="guest" {{ $user->role && $user->role->name == 'guest' ? 'selected' : '' }}>
                        Guest
                    </option>
                </select>
            </div>

            @if($user->role && $user->role->name === 'owner')
            <!-- Nomor Telepon -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Nomor Telepon
                </label>
                <input 
                    type="text"
                    name="no_telp"
                    value="{{ old('no_telp', $user->ownerProfile->no_telp ?? '') }}"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green"
                    required
                >
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Alamat
                </label>
                <textarea 
                    name="alamat"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green"
                    required
                >{{ old('alamat', $user->ownerProfile->address ?? '') }}</textarea>
            </div>
            @endif
            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-dark-brown mb-2">
                    Status
                </label>

                <select 
                    name="status"
                    class="w-full border border-light-beige rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-soft-green"
                >
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">

                <!-- Save -->
                <button 
                    type="submit"
                    class="bg-dark-brown text-white px-8 py-4 rounded-full font-bold hover:opacity-90 transition"
                >
                    Save Changes
                </button>

                <!-- Back -->
                <a href="{{ route('accounts.show', $user->id) }}"
                   class="bg-light-beige text-dark-brown px-8 py-4 rounded-full font-bold text-center hover:bg-cream transition">
                    Back to Profile
                </a>
            </div>
        </form>

        <!-- Delete Section -->
        <div class="mt-12 pt-8 border-t border-light-beige/40">
            <h4 class="text-red-600 font-bold text-lg mb-4">
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