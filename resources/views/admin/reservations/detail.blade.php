@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.reservations') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<x-card title="Detail Reservasi #{{ $reservation->id }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="font-semibold text-gray-800 mb-4">Informasi Pengguna</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <p class="font-medium">{{ $reservation->user->name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <p class="font-medium">{{ $reservation->user->email }}</p>
                </div>
            </div>
        </div>
        
        <div>
            <h4 class="font-semibold text-gray-800 mb-4">Informasi Reservasi</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-600">Ruangan</label>
                    <p class="font-medium">{{ $reservation->room->nama }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tanggal</label>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</p>
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
                            <x-badge type="warning">Menunggu</x-badge>
                        @else
                            <x-badge type="danger">Ditolak</x-badge>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <h4 class="font-semibold text-gray-800 mb-2">Keperluan</h4>
        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $reservation->purpose }}</p>
    </div>
    
    @if($reservation->status === 'menunggu')
    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
        <x-button variant="danger" onclick="openModal('tolakModal')">
            <i class="fas fa-times mr-2"></i>Tolak
        </x-button>
        <x-button variant="success" onclick="openModal('terimaModal')">
            <i class="fas fa-check mr-2"></i>Terima
        </x-button>
    </div>
    @endif
</x-card>

@if($reservation->status === 'menunggu')
@include('admin.reservations.modal_terima', ['reservation' => $reservation])
@endif
@endsection