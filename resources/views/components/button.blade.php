@props(['type' => 'button', 'variant' => 'primary', 'size' => 'md', 'icon' => null])

@php
$variants = [
    'primary' => 'bg-dark-red hover:bg-red-800 text-white',
    'secondary' => 'bg-cream-200 hover:bg-cream-300 text-gray-700',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    'success' => 'bg-green-600 hover:bg-green-700 text-white'
];
$sizes = [
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-4 py-3 text-base',
    'lg' => 'px-6 py-4 text-lg'
];
@endphp

<button 
    type="{{ $type }}" 
    class="inline-flex items-center justify-center font-medium rounded-lg transition duration-200 transform hover:scale-105 {{ $variants[$variant] }} {{ $sizes[$size] }}"
    {{ $attributes }}
>
    @if($icon)
    <i class="{{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
</button>

<style>
.bg-dark-red { background-color: #7f1d1d; }
.bg-cream-200 { background-color: #f5f2e8; }
.bg-cream-300 { background-color: #e8e2d4; }
</style>