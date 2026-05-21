<?php

$sourcePath = __DIR__ . '/resources/views/Owner/profile/add-cafe.blade.php';
$destPath = __DIR__ . '/resources/views/admin/addCafe.blade.php';

$content = file_get_contents($sourcePath);

// Change form action
$content = str_replace(
    "action=\"{{ route('add-cafe.submit') }}\"", 
    "action=\"{{ route('admin.cafes.store') }}\"", 
    $content
);

// Change back link
$content = str_replace(
    "href=\"{{ url('/cafe') }}\"", 
    "href=\"{{ route('admin.cafes') }}\"", 
    $content
);
$content = str_replace(
    "← {{ __('messages.back_to_branches') }}", 
    "← Kembali ke Daftar Cafe", 
    $content
);

// Remove default values referencing auth()->user()
$content = str_replace(
    "value=\"{{ auth()->user()->ownerProfile->cafe_name ?? old('name') }}\"", 
    "value=\"{{ old('name') }}\"", 
    $content
);
$content = str_replace(
    "value=\"{{ auth()->user()->email ?? old('email') }}\"", 
    "value=\"{{ old('email') }}\"", 
    $content
);
$content = str_replace(
    "value=\"{{ auth()->user()->ownerProfile->address ?? old('address') }}\"", 
    "value=\"{{ old('address') }}\"", 
    $content
);

// Add Owner Dropdown before General Information
$dropdownHtml = <<<HTML
        <!-- SECTION: Owner Selection -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">Pilih Owner</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Pemilik Cafe</label>
                    <div class="relative">
                        <select name="owner_id" class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark appearance-none focus:outline-none focus:border-muted cursor-pointer" required>
                            <option value="">Pilih Owner</option>
                            @foreach(\$owners as \$owner)
                                <option value="{{ \$owner->id }}" {{ old('owner_id') == \$owner->id ? 'selected' : '' }}>{{ \$owner->username }} - {{ \$owner->email }}</option>
                            @endforeach
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-xs pointer-events-none">▾</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: General Information -->
HTML;

$content = str_replace(
    '<!-- SECTION: General Information -->', 
    $dropdownHtml, 
    $content
);

file_put_contents($destPath, $content);
echo "File created successfully.\n";
