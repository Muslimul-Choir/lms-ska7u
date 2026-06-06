@php
    $colors = [
        'dijadwalkan' => 'bg-blue-100 text-blue-700',
        'berlangsung' => 'bg-green-100 text-green-700',
        'selesai'     => 'bg-gray-100 text-gray-700',
        'dibatalkan'  => 'bg-red-100 text-red-700',
    ];

    $class = $colors[$status] ?? 'bg-gray-100 text-gray-700';
@endphp

<span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
    {{ ucfirst($status) }}
</span>