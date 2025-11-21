@extends('layouts.user')

@section('title', 'Reservasi Saya')
@section('page-title', 'Reservasi Saya')

@section('content')


<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Reservasi</h3>
    <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-4 py-2 bg-dark-red text-white rounded-lg hover:bg-red-800 transition duration-200">
        <i class="fas fa-plus mr-2"></i>Buat Reservasi
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
    </form>
    @if(request()->hasAny(['date', 'status', 'room_id']))
        <div class="mt-3">
            <a href="{{ route('user.reservations') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition duration-200">
                <i class="fas fa-times mr-1"></i>Reset Filter
            </a>
        </div>
    @endif
</div>

@if($reservations->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($reservations as $reservation)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-200">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold text-gray-900">{{ $reservation->room->nama }}</h4>
                    <p class="text-sm text-gray-500">{{ $reservation->room->lokasi }}</p>
                </div>
                @if($reservation->status === 'diterima')
                    <x-badge type="success">Disetujui</x-badge>
                @elseif($reservation->status === 'menunggu')
                    <x-badge type="warning">Menunggu</x-badge>
                @elseif($reservation->status === 'dibatalkan')
                    <x-badge type="secondary">Dibatalkan</x-badge>
                @else
                    <x-badge type="danger">Ditolak</x-badge>
                @endif
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2"></i>
                    <span>{{ \Carbon\Carbon::parse($reservation->date)->format('d F Y') }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-clock mr-2"></i>
                    <span>{{ $reservation->start_time }} - {{ $reservation->end_time }}</span>
                </div>
            </div>
            
            <p class="text-sm text-gray-700 mb-4">{{ Str::limit($reservation->nama_kegiatan, 80) }}</p>
            
            <div class="flex justify-between items-center">
                <a href="{{ route('reservations.show', $reservation->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">
                    <i class="fas fa-eye mr-1"></i>Detail
                </a>
                @if(in_array($reservation->status, ['menunggu', 'diterima']) && \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->start_time)->isFuture())
                    <button onclick="cancelReservation({{ $reservation->id }})" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $reservations->appends(request()->query())->links('custom.pagination') }}
    </div>
@else
    <div class="text-center py-12">
        <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Reservasi</h3>
        <p class="text-gray-500 mb-6">Anda belum memiliki reservasi ruangan</p>
        <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-6 py-3 bg-dark-red text-white rounded-lg hover:bg-red-800 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Buat Reservasi Pertama
        </a>
    </div>
@endif

<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Batalkan Reservasi?</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan reservasi ini?</p>
            
            <div class="flex justify-center space-x-3">
                <button onclick="closeModal('cancelModal')" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    Tidak
                </button>
                <form id="cancelForm" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-times mr-2"></i>Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function cancelReservation(id) {
    document.getElementById('cancelForm').action = '/reservations/' + id + '/cancel';
    openModal('cancelModal');
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
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