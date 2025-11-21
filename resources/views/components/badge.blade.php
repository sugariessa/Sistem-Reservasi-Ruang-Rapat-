@props(['type' => 'default', 'size' => 'sm'])

@php
$types = [
    'default' => 'bg-gray-100 text-gray-800',
    'success' => 'bg-green-100 text-green-800',
    'danger' => 'bg-red-100 text-red-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'info' => 'bg-blue-100 text-blue-800',
    'primary' => 'bg-red-100 text-red-800',
    'secondary' => 'bg-gray-100 text-gray-600'
];
$sizes = [
    'xs' => 'px-2 py-1 text-xs',
    'sm' => 'px-2.5 py-1.5 text-sm',
    'md' => 'px-3 py-2 text-base'
];
@endphp

<span class="inline-flex items-center font-medium rounded-full {{ $types[$type] }} {{ $sizes[$size] }}">
    {{ $slot }}
</span>