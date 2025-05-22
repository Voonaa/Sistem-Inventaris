<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Barang Spesifik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Pilih Barang</h2>
                    <p class="text-sm text-gray-600 mt-1">Pilih barang untuk melihat riwayat aktivitasnya</p>
                </div>

                <form action="{{ route('riwayat-barang.item') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="barang_id" class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                            <select name="barang_id" id="barang_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Pilih Barang...</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}">
                                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium">
                                Lihat Riwayat
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="mt-6">
                    <a href="{{ route('riwayat-barang.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-900">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Riwayat
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 