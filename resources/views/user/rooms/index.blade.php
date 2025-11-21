@extends('layouts.user')

@section('title', 'Lihat Ruangan')
@section('page-title', 'Ruangan Tersedia')
@section('page-subtitle', 'Pilih ruangan yang sesuai dengan kebutuhan Anda')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($rooms as $room)
    <div class="{{ $room->status === 'aktif' ? 'bg-white border-gray-200 hover:shadow-md' : 'bg-gray-100 border-gray-300 opacity-75' }} border rounded-lg p-6 transition duration-200">
        <div class="text-center">
            <div class="p-4 {{ $room->status === 'aktif' ? 'bg-blue-100' : 'bg-gray-200' }} rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-door-open {{ $room->status === 'aktif' ? 'text-blue-600' : 'text-gray-500' }} text-2xl"></i>
            </div>
            
            <h3 class="text-lg font-semibold {{ $room->status === 'aktif' ? 'text-gray-800' : 'text-gray-500' }} mb-2">{{ $room->nama }}</h3>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-center text-sm {{ $room->status === 'aktif' ? 'text-gray-600' : 'text-gray-500' }}">
                    <i class="fas fa-users mr-2"></i>
                    <span>{{ $room->kapasitas }} orang</span>
                </div>
                <div class="flex items-center justify-center text-sm {{ $room->status === 'aktif' ? 'text-gray-600' : 'text-gray-500' }}">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $room->lokasi }}</span>
                </div>
                @if($room->status === 'aktif')
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Tersedia</span>
                @else
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Tidak Tersedia</span>
                @endif
            </div>
            
            @if($room->deskripsi)
            <p class="text-sm {{ $room->status === 'aktif' ? 'text-gray-600' : 'text-gray-500' }} mb-4">{{ Str::limit($room->deskripsi, 60) }}</p>
            @endif
            
            @if($room->status === 'aktif')
            <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                <i class="fas fa-calendar-plus mr-2"></i>Reservasi
            </a>
            @else
            <button onclick="showUnavailableAlert()" class="inline-flex items-center px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition duration-200">
                <i class="fas fa-ban mr-2"></i>Tidak Tersedia
            </button>
            @endif
        </div>
    </div>
    @endforeach
</div>

@if($rooms->isEmpty())
<div class="text-center py-12">
    <i class="fas fa-door-open text-gray-400 text-6xl mb-4"></i>
    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Ruangan</h3>
    <p class="text-gray-500">Belum ada ruangan yang tersedia saat ini</p>
</div>
@else
<div class="mt-8">
    {{ $rooms->links('custom.pagination') }}
</div>
@endif

<script>
function showUnavailableAlert() {
    Swal.fire({
        icon: 'warning',
        title: 'Ruangan Tidak Tersedia',
        text: 'Maaf, ruangan ini sedang tidak dapat digunakan. Silakan pilih ruangan lain yang tersedia.',
        confirmButtonColor: '#7f1d1d',
        confirmButtonText: 'Mengerti'
    });
}
</script>
@endsection