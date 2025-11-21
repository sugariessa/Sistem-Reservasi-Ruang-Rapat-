@extends('layouts.user')

@section('title', 'Dashboard User')
@section('page-title', 'Selamat Datang')
@section('page-subtitle', 'Kelola reservasi ruangan Anda dengan mudah dan efisien')

@section('content')


<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Reservasi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalReservations }}</p>
            </div>
            <div class="bg-blue-50 p-3 rounded-lg">
                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $pendingReservations }}</p>
            </div>
            <div class="bg-yellow-50 p-3 rounded-lg">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Disetujui</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $approvedReservations }}</p>
            </div>
            <div class="bg-green-50 p-3 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Dibatalkan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $cancelledReservations }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <i class="fas fa-ban text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Reservasi Terbaru</h3>
            <a href="{{ route('user.reservations') }}" class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center">
                Lihat Semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
        
        @if($recentReservations->count() > 0)
            <div class="space-y-4">
                @foreach($recentReservations as $reservation)
                <div class="border-l-4 {{ $reservation->status === 'diterima' ? 'border-green-500 bg-green-50' : ($reservation->status === 'menunggu' ? 'border-yellow-500 bg-yellow-50' : ($reservation->status === 'dibatalkan' ? 'border-gray-500 bg-gray-50' : 'border-red-500 bg-red-50')) }} p-4 rounded-r-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $reservation->room->nama }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                                <i class="fas fa-clock ml-3 mr-1"></i>{{ $reservation->start_time }}-{{ $reservation->end_time }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $reservation->status === 'diterima' ? 'bg-green-100 text-green-800' : ($reservation->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : ($reservation->status === 'dibatalkan' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $reservation->status === 'diterima' ? 'Disetujui' : ($reservation->status === 'menunggu' ? 'Menunggu' : ($reservation->status === 'dibatalkan' ? 'Dibatalkan' : 'Ditolak')) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada reservasi</p>
                <a href="{{ route('reservations.create') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                    Buat Reservasi Pertama
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-1 gap-3">
            <a href="{{ route('user.rooms') }}" class="group p-4 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition duration-200">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-lg mr-4">
                        <i class="fas fa-door-open text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Lihat Ruangan</h4>
                        <p class="text-sm text-gray-600">Jelajahi ruangan tersedia</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-red-600 transition duration-200"></i>
                </div>
            </a>
            
            <a href="{{ route('reservations.create') }}" class="group p-4 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition duration-200">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-lg mr-4">
                        <i class="fas fa-plus text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Buat Reservasi</h4>
                        <p class="text-sm text-gray-600">Reservasi ruangan baru</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-red-600 transition duration-200"></i>
                </div>
            </a>
            
            <a href="{{ route('user.reservations') }}" class="group p-4 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition duration-200">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-lg mr-4">
                        <i class="fas fa-history text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Riwayat Reservasi</h4>
                        <p class="text-sm text-gray-600">Lihat semua reservasi</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-red-600 transition duration-200"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection