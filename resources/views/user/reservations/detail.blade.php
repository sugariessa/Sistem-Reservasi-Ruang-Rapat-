@extends('layouts.user')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('user.reservations') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<x-card title="Detail Reservasi #{{ $reservation->id }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="font-semibold text-gray-800 mb-4">Informasi Ruangan</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-600">Nama Ruangan</label>
                    <p class="font-medium">{{ $reservation->room->nama }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Lokasi</label>
                    <p class="font-medium">{{ $reservation->room->lokasi }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kapasitas</label>
                    <p class="font-medium">{{ $reservation->room->kapasitas }} orang</p>
                </div>
            </div>
        </div>
        
        <div>
            <h4 class="font-semibold text-gray-800 mb-4">Detail Reservasi</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-600">Tanggal</label>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->date)->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Waktu</label>
                    <p class="font-medium">{{ $reservation->start_time }} - {{ $reservation->end_time }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <div class="mt-1">
                        @if($reservation->status === 'diterima')
                            <x-badge type="success">Disetujui</x-badge>
                        @elseif($reservation->status === 'menunggu')
                            <x-badge type="warning">Menunggu Persetujuan</x-badge>
                        @elseif($reservation->status === 'dibatalkan')
                            <x-badge type="secondary">Dibatalkan</x-badge>
                        @else
                            <x-badge type="danger">Ditolak</x-badge>
                        @endif
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tanggal Dibuat</label>
                    <p class="font-medium">{{ $reservation->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <h4 class="font-semibold text-gray-800 mb-2">Keperluan</h4>
        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $reservation->keperluan }}</p>
    </div>
    
    @if($reservation->room->deskripsi)
    <div class="mt-6">
        <h4 class="font-semibold text-gray-800 mb-2">Fasilitas Ruangan</h4>
        <p class="text-gray-700 bg-blue-50 p-4 rounded-lg">{{ $reservation->room->deskripsi }}</p>
    </div>
    @endif
    
    @if($reservation->status === 'menunggu')
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-clock text-yellow-600 mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-yellow-800 mb-1">Menunggu Persetujuan</h4>
                <p class="text-sm text-yellow-700">Reservasi Anda sedang diproses oleh admin. Anda akan mendapat notifikasi setelah reservasi disetujui atau ditolak.</p>
            </div>
        </div>
    </div>
    @elseif($reservation->status === 'diterima')
    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-green-800 mb-1">Reservasi Disetujui</h4>
                <p class="text-sm text-green-700">Selamat! Reservasi Anda telah disetujui. Silakan datang sesuai waktu yang telah ditentukan.</p>
            </div>
        </div>
    </div>
    @elseif($reservation->status === 'dibatalkan')
    <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-ban text-gray-600 mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-gray-800 mb-1">Reservasi Dibatalkan</h4>
                <p class="text-sm text-gray-700">Reservasi ini telah dibatalkan oleh Anda.</p>
            </div>
        </div>
    </div>
    @else
    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-times-circle text-red-600 mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-red-800 mb-1">Reservasi Ditolak</h4>
                <p class="text-sm text-red-700">Maaf, reservasi Anda ditolak. Silakan buat reservasi baru dengan waktu yang berbeda.</p>
            </div>
        </div>
    </div>
    @endif
</x-card>
@endsection