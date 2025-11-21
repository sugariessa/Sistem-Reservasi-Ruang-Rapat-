@props(['title' => null, 'subtitle' => null])

<div class="bg-cream-50 rounded-lg shadow-lg border border-cream-200 overflow-hidden">
    @if($title || $subtitle)
    <div class="bg-dark-red px-6 py-4 border-b border-cream-200">
        @if($title)
        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
        @endif
        @if($subtitle)
        <p class="text-red-100 text-sm mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>

<style>
.bg-cream-50 { background-color: #fefdf8; }
.bg-cream-200 { background-color: #f5f2e8; }
.border-cream-200 { border-color: #f5f2e8; }
.bg-dark-red { background-color: #7f1d1d; }
</style>