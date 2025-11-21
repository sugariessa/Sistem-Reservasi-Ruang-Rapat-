@extends('layouts.admin')

@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')

@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
            <input type="date" name="joined_date" value="{{ request('joined_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama/Email</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent filter-input">
        </div>
    </form>
    @if(request()->hasAny(['role', 'joined_date', 'search']))
        <div class="mt-3">
            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition duration-200">
                <i class="fas fa-times mr-1"></i>Reset Filter
            </a>
        </div>
    @endif
</div>

@if($users->count() > 0)
    <div class="mb-4">
        {{ $users->appends(request()->query())->links('custom.pagination') }}
    </div>
    
    <x-table :headers="['Nama', 'Email', 'Role', 'Bergabung', 'Total Reservasi']">
        @foreach($users as $user)
        <tr class="hover:bg-cream-100">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="font-medium text-gray-900">{{ $user->name }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-gray-900">{{ $user->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @if($user->role === 'admin')
                    <x-badge type="danger">Admin</x-badge>
                @else
                    <x-badge type="info">User</x-badge>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $user->created_at->format('d/m/Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <x-badge type="secondary">{{ $user->reservations_count }}</x-badge>
            </td>
        </tr>
        @endforeach
    </x-table>
    
    <div class="mt-6">
        {{ $users->appends(request()->query())->links('custom.pagination') }}
    </div>
@else
    <div class="text-center py-8">
        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-500">Belum ada pengguna terdaftar</p>
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