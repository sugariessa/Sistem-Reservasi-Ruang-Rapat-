@extends('layouts.admin')

@section('title', 'Edit Ruangan')
@section('page-title', 'Edit Ruangan')

@section('content')
@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif

<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.rooms') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<x-card title="Edit Ruangan: {{ $room->nama }}">
    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-form_input 
            label="Nama Ruangan" 
            name="nama" 
            icon="fas fa-door-open"
            required 
            :value="$room->nama"
            placeholder="Masukkan nama ruangan"
        />
        
        <x-form_input 
            label="Kapasitas" 
            name="kapasitas" 
            type="number"
            icon="fas fa-users"
            required 
            :value="$room->kapasitas"
            placeholder="Jumlah kapasitas orang"
        />
        
        <x-form_input 
            label="Lokasi" 
            name="lokasi" 
            icon="fas fa-map-marker-alt"
            required 
            :value="$room->lokasi"
            placeholder="Lokasi ruangan"
        />
        
        <x-form_input 
            label="Deskripsi" 
            name="deskripsi" 
            type="textarea"
            icon="fas fa-list"
            :value="$room->deskripsi"
            placeholder="Deskripsi fasilitas ruangan"
        />
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fas fa-toggle-on text-gray-400 mr-2"></i>Status
            </label>
            <select name="status" class="w-full px-4 py-3 border border-cream-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-cream-50">
                <option value="aktif" {{ $room->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ $room->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

<style>
.bg-cream-50 { background-color: #fefdf8; }
.border-cream-300 { border-color: #e8e2d4; }
</style>
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.rooms') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                Batal
            </a>
            <x-button type="submit" variant="primary" icon="fas fa-save">
                Update
            </x-button>
        </div>
    </form>
</x-card>
@endsection