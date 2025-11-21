@props(['id', 'title' => null])

<div id="{{ $id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-lg bg-cream-50">
        <div class="mt-3">
            @if($title)
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-cream-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                <button onclick="closeModal('{{ $id }}')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
            
            <div class="mt-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>

<style>
.bg-cream-50 { background-color: #fefdf8; }
.border-cream-200 { border-color: #f5f2e8; }
</style>