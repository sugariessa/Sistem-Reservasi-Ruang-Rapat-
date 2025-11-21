@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false, 'icon' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 text-sm font-medium mb-2">
        @if($icon)
        <i class="{{ $icon }} text-gray-400 mr-2"></i>
        @endif
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if($type === 'textarea')
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-3 border border-cream-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-cream-50"
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-3 border border-cream-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-cream-50"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>
    @else
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-3 border border-cream-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-cream-50"
        {{ $attributes }}
    >
    @endif
    
    @error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<style>
.bg-cream-50 { background-color: #fefdf8; }
.border-cream-300 { border-color: #e8e2d4; }
</style>