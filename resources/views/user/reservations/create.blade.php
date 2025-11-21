@extends('layouts.user')

@section('title', 'Buat Reservasi')
@section('page-title', 'Buat Reservasi Baru')

@section('content')


<div class="flex justify-between items-center mb-6">
    <a href="{{ route('user.reservations') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<x-card title="Form Reservasi Ruangan">
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        
        <x-form_input 
            label="Pilih Ruangan" 
            name="room_id" 
            type="select"
            icon="fas fa-door-open"
            required
        >
            <option value="">Pilih ruangan...</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                    {{ $room->nama }} - {{ $room->lokasi }} ({{ $room->kapasitas }} orang)
                </option>
            @endforeach
        </x-form_input>
        
        <x-form_input 
            label="Tanggal Reservasi" 
            name="date" 
            type="date"
            icon="fas fa-calendar"
            required 
            :value="date('Y-m-d')"
            min="{{ date('Y-m-d') }}"
        />
        
        <div id="scheduleInfo" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
            <h4 class="font-medium text-gray-800 mb-3">Jadwal Terpakai pada Tanggal Ini:</h4>
            <div id="scheduleList" class="space-y-2"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form_input 
                label="Jam Mulai" 
                name="start_time" 
                type="time"
                icon="fas fa-clock"
                required 
            />
            
            <x-form_input 
                label="Jam Selesai" 
                name="end_time" 
                type="time"
                icon="fas fa-clock"
                required 
            />
        </div>
        
        <x-form_input 
            label="Keperluan" 
            name="keperluan" 
            type="textarea"
            icon="fas fa-clipboard"
            required 
            placeholder="Jelaskan keperluan penggunaan ruangan..."
        />
        
        @if($schedule)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start">
                <i class="fas fa-clock text-blue-600 mt-1 mr-3"></i>
                <div>
                    <h4 class="font-medium text-blue-800 mb-1">Jam Kerja:</h4>
                    <p class="text-sm text-blue-700 mb-2">{{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }}</p>
                    <p class="text-sm text-blue-700">Hari kerja: {{ implode(', ', $schedule->hari_kerja) }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <h4 class="font-medium text-yellow-800 mb-1">Informasi Penting:</h4>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <li>• Reservasi akan diproses oleh admin dalam 1x24 jam</li>
                        <li>• Pastikan waktu sesuai dengan jam kerja yang berlaku</li>
                        <li>• Reservasi hanya dapat dibuat untuk hari kerja</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('user.reservations') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Reservasi
            </button>
        </div>
    </form>
</x-card>

@if($schedule)
<script>
const schedule = {
    jamMulai: '{{ $schedule->jam_mulai }}',
    jamSelesai: '{{ $schedule->jam_selesai }}',
    hariKerja: @json($schedule->hari_kerja)
};

const dateInput = document.querySelector('input[name="date"]');
const roomInput = document.querySelector('select[name="room_id"]');
const startTimeInput = document.querySelector('input[name="start_time"]');
const endTimeInput = document.querySelector('input[name="end_time"]');
const scheduleInfo = document.getElementById('scheduleInfo');
const scheduleList = document.getElementById('scheduleList');

let existingReservations = [];

async function loadSchedule() {
    if (!roomInput.value || !dateInput.value) {
        scheduleInfo.classList.add('hidden');
        return;
    }
    
    try {
        const response = await fetch(`/reservations/schedule/check?room_id=${roomInput.value}&date=${dateInput.value}`);
        const reservations = await response.json();
        existingReservations = reservations;
        
        if (reservations.length > 0) {
            scheduleList.innerHTML = reservations.map(res => 
                `<div class="flex justify-between items-center p-2 bg-white rounded border">
                    <span class="text-sm text-gray-700">${res.start_time} - ${res.end_time}</span>
                    <span class="text-xs px-2 py-1 rounded ${
                        res.status === 'diterima' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                    }">${res.status === 'diterima' ? 'Disetujui' : 'Menunggu'}</span>
                </div>`
            ).join('');
            scheduleInfo.classList.remove('hidden');
        } else {
            scheduleInfo.classList.add('hidden');
        }
    } catch (error) {
        console.error('Error loading schedule:', error);
    }
}

function checkTimeConflict() {
    if (!startTimeInput.value || !endTimeInput.value) return true;
    
    const startTime = startTimeInput.value;
    const endTime = endTimeInput.value;
    
    for (let reservation of existingReservations) {
        if (startTime < reservation.end_time && endTime > reservation.start_time) {
            Swal.fire({
                icon: 'error',
                title: 'Jadwal Bentrok',
                text: `Waktu bentrok dengan reservasi yang sudah ada (${reservation.start_time} - ${reservation.end_time}). Silakan pilih waktu lain.`,
                confirmButtonColor: '#dc2626'
            });
            return false;
        }
    }
    return true;
}

function validateWorkingHours() {
    const selectedDate = new Date(dateInput.value);
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const selectedDay = dayNames[selectedDate.getDay()];
    
    if (!schedule.hariKerja.includes(selectedDay)) {
        Swal.fire({
            icon: 'warning',
            title: 'Hari Tidak Valid',
            text: 'Hari ' + selectedDay + ' bukan hari kerja. Silakan pilih hari kerja.',
            confirmButtonColor: '#dc2626'
        });
        return false;
    }
    
    // Validasi jam untuk hari ini
    const today = new Date().toISOString().split('T')[0];
    if (dateInput.value === today) {
        const currentTime = new Date().toTimeString().slice(0, 5);
        if (startTimeInput.value && startTimeInput.value <= currentTime) {
            Swal.fire({
                icon: 'error',
                title: 'Jam Tidak Valid',
                text: 'Tidak dapat membuat reservasi untuk jam yang sudah terlewat.',
                confirmButtonColor: '#dc2626'
            });
            return false;
        }
    }
    
    if (startTimeInput.value && (startTimeInput.value < schedule.jamMulai || startTimeInput.value > schedule.jamSelesai)) {
        Swal.fire({
            icon: 'warning',
            title: 'Jam Kerja Tidak Sesuai',
            text: 'Jam mulai harus dalam rentang jam kerja (' + schedule.jamMulai + ' - ' + schedule.jamSelesai + ')',
            confirmButtonColor: '#dc2626'
        });
        return false;
    }
    
    if (endTimeInput.value && (endTimeInput.value < schedule.jamMulai || endTimeInput.value > schedule.jamSelesai)) {
        Swal.fire({
            icon: 'warning',
            title: 'Jam Kerja Tidak Sesuai',
            text: 'Jam selesai harus dalam rentang jam kerja (' + schedule.jamMulai + ' - ' + schedule.jamSelesai + ')',
            confirmButtonColor: '#dc2626'
        });
        return false;
    }
    
    return checkTimeConflict();
}

roomInput.addEventListener('change', loadSchedule);
dateInput.addEventListener('change', () => {
    loadSchedule();
    validateWorkingHours();
});
startTimeInput.addEventListener('change', validateWorkingHours);
endTimeInput.addEventListener('change', validateWorkingHours);

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateWorkingHours()) {
        return;
    }
    
    const roomName = roomInput.options[roomInput.selectedIndex].text;
    const date = new Date(dateInput.value).toLocaleDateString('id-ID');
    const time = startTimeInput.value + ' - ' + endTimeInput.value;
    
    Swal.fire({
        title: 'Konfirmasi Reservasi',
        html: `
            <div class="text-left">
                <p><strong>Ruangan:</strong> ${roomName}</p>
                <p><strong>Tanggal:</strong> ${date}</p>
                <p><strong>Waktu:</strong> ${time}</p>
                <p class="mt-3 text-sm text-gray-600">Apakah Anda yakin ingin mengirim reservasi ini?</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
});
</script>
@endif
@endsection