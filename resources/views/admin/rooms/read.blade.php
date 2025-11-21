@extends('layouts.admin')

@section('title', 'Detail Ruangan')
@section('page-title', 'Detail Ruangan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.rooms') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
    <div class="space-x-2">
        <a href="{{ route('rooms.edit', $room->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <x-button variant="danger" onclick="openModal('deleteModal')">
            <i class="fas fa-trash mr-2"></i>Hapus
        </x-button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card title="Informasi Ruangan">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-600">Nama Ruangan</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $room->nama }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kapasitas</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $room->kapasitas }} orang</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Lokasi</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $room->lokasi }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <div class="mt-1">
                        <x-badge type="{{ $room->status === 'aktif' ? 'success' : 'danger' }}">
                            {{ ucfirst($room->status) }}
                        </x-badge>
                    </div>
                </div>
            </div>
            
            @if($room->deskripsi)
            <div class="mt-6">
                <label class="text-sm text-gray-600">Deskripsi</label>
                <p class="text-gray-700 bg-gray-50 p-4 rounded-lg mt-2">{{ $room->deskripsi }}</p>
            </div>
            @endif
        </x-card>
    </div>
    
    <div>
        <x-card title="Statistik">
            <div class="space-y-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $room->reservations_count }}</p>
                    <p class="text-sm text-gray-600">Total Reservasi</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $room->approved_reservations_count }}</p>
                    <p class="text-sm text-gray-600">Reservasi Disetujui</p>
                </div>
            </div>
        </x-card>
    </div>
</div>

<x-modal id="deleteModal" title="Konfirmasi Hapus">
    <div class="text-center">
        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Ruangan?</h3>
        <p class="text-gray-600 mb-6">Data ruangan dan semua reservasi terkait akan dihapus permanen.</p>
        
        <div class="flex justify-center space-x-3">
            <x-button type="button" variant="secondary" onclick="closeModal('deleteModal')">
                Batal
            </x-button>
            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <i class="fas fa-trash mr-2"></i>Ya, Hapus
                </x-button>
            </form>
        </div>
    </div>
</x-modal>
@endsection