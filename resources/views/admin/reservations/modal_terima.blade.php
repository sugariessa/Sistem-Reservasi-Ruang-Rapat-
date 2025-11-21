<x-modal id="terimaModal" title="Konfirmasi Persetujuan">
    <div class="text-center">
        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Terima Reservasi?</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menyetujui reservasi ini?</p>
        
        <div class="flex justify-center space-x-3">
            <x-button type="button" variant="secondary" onclick="closeModal('terimaModal')">
                Batal
            </x-button>
            <a href="{{ route('admin.reservations.terima', $reservation->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                <i class="fas fa-check mr-2"></i>Ya, Terima
            </a>
        </div>
    </div>
</x-modal>

<x-modal id="tolakModal" title="Konfirmasi Penolakan">
    <div class="text-center">
        <i class="fas fa-times-circle text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tolak Reservasi?</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menolak reservasi ini?</p>
        
        <div class="flex justify-center space-x-3">
            <x-button type="button" variant="secondary" onclick="closeModal('tolakModal')">
                Batal
            </x-button>
            <a href="{{ route('admin.reservations.tolak', $reservation->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                <i class="fas fa-times mr-2"></i>Ya, Tolak
            </a>
        </div>
    </div>
</x-modal>