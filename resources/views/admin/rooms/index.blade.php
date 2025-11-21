@extends('layouts.admin')

@section('title', 'Data Ruangan')
@section('page-title', 'Data Ruangan')

@section('content')


<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-800"></h3>
    <a href="{{ route('rooms.create') }}" class="inline-flex items-center px-4 py-2 bg-dark-red text-white rounded-lg hover:bg-red-800 transition duration-200">
        <i class="fas fa-plus mr-2"></i>Tambah Ruangan
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ request('status') === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
            <select name="kapasitas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
                <option value="">Semua Kapasitas</option>
                <option value="1-10" {{ request('kapasitas') === '1-10' ? 'selected' : '' }}>1-10 orang</option>
                <option value="11-20" {{ request('kapasitas') === '11-20' ? 'selected' : '' }}>11-20 orang</option>
                <option value="21-50" {{ request('kapasitas') === '21-50' ? 'selected' : '' }}>21-50 orang</option>
                <option value="50+" {{ request('kapasitas') === '50+' ? 'selected' : '' }}>50+ orang</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruangan</label>
            <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama ruangan..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
        </div>
    </form>
    @if(request()->hasAny(['status', 'kapasitas', 'nama']))
        <div class="mt-3">
            <a href="{{ route('admin.rooms') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition duration-200">
                <i class="fas fa-times mr-1"></i>Reset Filter
            </a>
        </div>
    @endif
</div>

@if($rooms->count() > 0)
    <div class="mb-4">
        {{ $rooms->appends(request()->query())->links('custom.pagination') }}
    </div>
    
    <x-table :headers="['Nama Ruangan', 'Kapasitas', 'Lokasi', 'Deskripsi', 'Status', 'Total Reservasi', 'Aksi']">
        @foreach($rooms as $room)
        <tr class="hover:bg-cream-100">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="font-medium text-gray-900">{{ $room->nama }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ $room->kapasitas }} orang</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ $room->lokasi }}</div>
            </td>
            <td class="px-6 py-4">
                <div class="text-gray-900">{{ Str::limit($room->deskripsi, 40) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @if($room->status === 'aktif')
                    <x-badge type="success">Aktif</x-badge>
                @else
                    <x-badge type="danger">Tidak Aktif</x-badge>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <x-badge type="info">{{ $room->reservations_count }}</x-badge>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editRoom({{ $room->id }}, '{{ $room->nama }}', {{ $room->kapasitas }}, '{{ $room->lokasi }}', '{{ $room->deskripsi }}', '{{ $room->status }}')" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs rounded-lg hover:bg-yellow-600 mr-2">
                    <i class="fas fa-edit mr-1"></i>Edit
                </button>
                <button onclick="confirmDelete('{{ route('rooms.destroy', $room->id) }}', 'ruangan {{ $room->nama }}')" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </td>
        </tr>
        @endforeach
    </x-table>
    
    <div class="mt-6">
        {{ $rooms->appends(request()->query())->links('custom.pagination') }}
    </div>
@else
    <div class="text-center py-8">
        <i class="fas fa-door-open text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-500">Belum ada ruangan yang terdaftar</p>
    </div>
@endif



<x-modal id="editModal" title="Edit Ruangan">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        
        <x-form_input 
            label="Nama Ruangan" 
            name="nama" 
            icon="fas fa-door-open"
            required 
            placeholder="Masukkan nama ruangan"
        />
        
        <x-form_input 
            label="Kapasitas" 
            name="kapasitas" 
            type="number"
            icon="fas fa-users"
            required 
            placeholder="Jumlah kapasitas orang"
        />
        
        <x-form_input 
            label="Lokasi" 
            name="lokasi" 
            icon="fas fa-map-marker-alt"
            required 
            placeholder="Lokasi ruangan"
        />
        
        <x-form_input 
            label="Deskripsi" 
            name="deskripsi" 
            type="textarea"
            icon="fas fa-list"
            placeholder="Deskripsi fasilitas ruangan"
        />
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fas fa-toggle-on text-gray-400 mr-2"></i>Status
            </label>
            <select name="status" id="editStatus" class="w-full px-4 py-3 border border-cream-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-cream-50">
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
            </select>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <x-button type="button" variant="secondary" onclick="closeModal('editModal')">
                Batal
            </x-button>
            <x-button type="submit" variant="primary" icon="fas fa-save">
                Update
            </x-button>
        </div>
    </form>
</x-modal>

<script>
function editRoom(id, nama, kapasitas, lokasi, deskripsi, status) {
    document.getElementById('editForm').action = '/rooms/' + id;
    document.querySelector('#editModal input[name="nama"]').value = nama;
    document.querySelector('#editModal input[name="kapasitas"]').value = kapasitas;
    document.querySelector('#editModal input[name="lokasi"]').value = lokasi;
    document.querySelector('#editModal textarea[name="deskripsi"]').value = deskripsi;
    document.getElementById('editStatus').value = status;
    openModal('editModal');
}

// Auto submit filter
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll('.filter-input');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
});
</script>


@endsection