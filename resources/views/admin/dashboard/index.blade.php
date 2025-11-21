@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')


<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-800"></h3>
    <x-button variant="primary" icon="fas fa-clock" onclick="openModal('scheduleModal')">
        Atur Jam Kerja
    </x-button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-card>
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-door-open text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Ruangan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalRooms }}</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-calendar-check text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Reservasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalReservations }}</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                <i class="fas fa-users text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 mr-4">
                <i class="fas fa-clock text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingReservations }}</p>
            </div>
        </div>
    </x-card>
</div>

<!-- Jam Kerja Card -->
<div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange-100 mr-3">
                <i class="fas fa-clock text-orange-600"></i>
            </div>
            <div>
                <h4 class="font-medium text-gray-800">Jam Kerja</h4>
                @if($schedule)
                    <p class="text-sm text-gray-600">{{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }}</p>
                    <p class="text-xs text-gray-500">{{ implode(', ', array_slice($schedule->hari_kerja, 0, 3)) }}{{ count($schedule->hari_kerja) > 3 ? '...' : '' }}</p>
                @else
                    <p class="text-sm text-gray-500">Belum diatur</p>
                @endif
            </div>
        </div>
        <x-button variant="secondary" size="sm" icon="fas fa-edit" onclick="editSchedule()">
            Edit
        </x-button>
    </div>
</div>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-800">5 Reservasi Terbaru</h3>
    <a href="{{ route('admin.reservations') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
        Lihat Semua Reservasi →
    </a>
</div>

@if($recentReservations->count() > 0)
    <x-table :headers="['Pengguna', 'Ruangan', 'Tanggal', 'Waktu', 'Status', 'Dibuat']">
        @foreach($recentReservations as $reservation)
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
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $reservation->created_at->format('d/m H:i') }}
            </td>
        </tr>
        @endforeach
    </x-table>
@else
    <div class="text-center py-8">
        <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-500">Belum ada reservasi</p>
    </div>
@endif

<x-modal id="scheduleModal" title="Atur Jam Kerja">
    <form action="{{ route('admin.schedule.store') }}" method="POST">
        @csrf
        <x-form_input 
            label="Jam Mulai" 
            name="jam_mulai" 
            type="time"
            icon="fas fa-clock"
            required 
            :value="$schedule ? $schedule->jam_mulai : '08:00'"
        />
        
        <x-form_input 
            label="Jam Selesai" 
            name="jam_selesai" 
            type="time"
            icon="fas fa-clock"
            required 
            :value="$schedule ? $schedule->jam_selesai : '17:00'"
        />
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fas fa-calendar text-gray-400 mr-2"></i>Hari Kerja
            </label>
            <div class="grid grid-cols-2 gap-2">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                <label class="flex items-center">
                    <input type="checkbox" name="hari_kerja[]" value="{{ $day }}" 
                           class="mr-2" {{ ($schedule && in_array($day, $schedule->hari_kerja)) || (!$schedule && in_array($day, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) ? 'checked' : '' }}>
                    <span class="text-sm">{{ $day }}</span>
                </label>
                @endforeach
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <x-button type="button" variant="secondary" onclick="closeModal('scheduleModal')">
                Batal
            </x-button>
            <x-button type="submit" variant="primary" icon="fas fa-save">
                Simpan
            </x-button>
        </div>
    </form>
</x-modal>

<script>
function editSchedule() {
    openModal('scheduleModal');
}
</script>
@endsection