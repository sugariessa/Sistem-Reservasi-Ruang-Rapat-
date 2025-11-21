@extends('layouts.admin')

@section('title', 'Tambah Ruangan')
@section('page-title', 'Tambah Ruangan')

@section('content')
@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif

<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.rooms') }}" class="flex items-center text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<x-card title="Tambah Ruangan Baru">
    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        
        <x-form_input 
            label="Nama Ruangan" 
            name="nama" 
            icon="fas fa-door-open"
            required 
            placeholder="Masukkan nama ruangan"
        />
        
        <x-form_input 
            label="Kapasitas" 
            name="kapasitas" 
            type="number"
            icon="fas fa-users"
            required 
            placeholder="Jumlah kapasitas orang"
        />
        
        <x-form_input 
            label="Lokasi" 
            name="lokasi" 
            icon="fas fa-map-marker-alt"
            required 
            placeholder="Lokasi ruangan"
        />
        
        <x-form_input 
            label="Deskripsi" 
            name="deskripsi" 
            type="textarea"
            icon="fas fa-list"
            placeholder="Deskripsi fasilitas ruangan"
        />
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.rooms') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                Batal
            </a>
            <x-button type="submit" variant="primary" icon="fas fa-save">
                Simpan
            </x-button>
        </div>
    </form>
</x-card>
@endsection