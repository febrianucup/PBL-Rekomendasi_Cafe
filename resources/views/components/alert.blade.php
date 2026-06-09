@props([
    'type' => 'success',
])

@php
    $style = match($type) {
        'error' => 'bg-soft-red/20 border border-soft-red/30 text-soft-red',
        'warning' => 'bg-[#F8F4E9] border border-[#E7D7B9] text-[#7D5A26]',
        default => 'bg-soft-green/20 border border-soft-green/30 text-soft-green',
    };

    $icon = match($type) {
        'error' => 'M6 18L18 6M6 6l12 12',
        'warning' => 'M12 9v2m0 4h.01M12 4.5a7.5 7.5 0 11-7.5 7.5 7.508 7.508 0 017.5-7.5z',
        default => 'M5 13l4 4L19 7',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl p-4 text-sm font-semibold flex items-start gap-3 shadow-sm {$style}"]) }}>
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>
    <div class="flex-1 break-words">
        {{ $slot }}
    </div>
</div>
