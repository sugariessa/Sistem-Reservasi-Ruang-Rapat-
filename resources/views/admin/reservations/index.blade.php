@extends('layouts.admin')

@section('title', 'Kelola Reservasi')
@section('page-title', 'Kelola Reservasi')

@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ruangan</label>
            <select name="room_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
                <option value="">Semua Ruangan</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>{{ $room->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pengguna</label>
            <input type="text" name="user" value="{{ request('user') }}" placeholder="Cari nama/email..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
        </div>
    </form>
    @if(request()->hasAny(['date', 'status', 'room_id', 'user']))
        <div class="mt-3">
            <a href="{{ route('admin.reservations') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition duration-200">
                <i class="fas fa-times mr-1"></i>Reset Filter
            </a>
        </div>
    @endif
</div>

@if($reservations->count() > 0)
    <div class="mb-4">
        {{ $reservations->appends(request()->query())->links('custom.pagination') }}
    </div>
    
    <x-table :headers="['Pengguna', 'Ruangan', 'Tanggal', 'Waktu', 'Keperluan', 'Status', 'Aksi']">
        @foreach($reservations as $reservation)
        <tr class="hover:bg-cream-100">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="font-medium text-gray-900">{{ $reservation->user->name }}</div>
                <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ $reservation->room->nama }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
            </td>
            <td class="px-6 py-4">
                <div class="text-gray-900">{{ Str::limit($reservation->keperluan, 30) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @if($reservation->status === 'diterima')
                    <x-badge type="success">Disetujui</x-badge>
                @elseif($reservation->status === 'menunggu')
                    <x-badge type="warning">Menunggu</x-badge>
                @elseif($reservation->status === 'dibatalkan')
                    <x-badge type="secondary">Dibatalkan</x-badge>
                @else
                    <x-badge type="danger">Ditolak</x-badge>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                @if($reservation->status === 'menunggu')
                    <button onclick="confirmAction('{{ route('admin.reservations.terima', $reservation->id) }}', 'Terima Reservasi', 'Apakah Anda yakin ingin menerima reservasi ini?')" 
                       class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 mr-2">
                        <i class="fas fa-check mr-1"></i>Terima
                    </button>
                    <button onclick="confirmAction('{{ route('admin.reservations.tolak', $reservation->id) }}', 'Tolak Reservasi', 'Apakah Anda yakin ingin menolak reservasi ini?')" 
                       class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                @else
                    <span class="text-gray-400 text-xs">Sudah diproses</span>
                @endif
            </td>
        </tr>
        @endforeach
    </x-table>
    
    <div class="mt-6">
        {{ $reservations->appends(request()->query())->links('custom.pagination') }}
    </div>
@else
    <div class="text-center py-8">
        <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-500">Belum ada reservasi</p>
    </div>
@endif

<script>
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