<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Barang</h3>
                    <a href="{{ route('barang.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Barang
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Kode</x-table.heading>
                            <x-table.heading>Nama</x-table.heading>
                            <x-table.heading>Kategori</x-table.heading>
                            <x-table.heading>Sub Kategori</x-table.heading>
                            <x-table.heading>Stok</x-table.heading>
                            <x-table.heading>Kondisi</x-table.heading>
                            <x-table.heading>Aksi</x-table.heading>
                        </x-slot>
                        
                        <tbody>
                            @forelse($barangs as $barang)
                                <tr>
                                    <x-table.cell>{{ $barang->kode_barang }}</x-table.cell>
                                    <x-table.cell>{{ $barang->nama_barang }}</x-table.cell>
                                    <x-table.cell>{{ $barang->kategori->nama ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell>{{ $barang->subKategori->nama ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell>
                                        {{ $barang->stok }} / {{ $barang->jumlah }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($barang->kondisi == 'Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                        @elseif($barang->kondisi == 'Kurang Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                        @elseif($barang->kondisi == 'Rusak')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $barang->kondisi }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('barang.edit', $barang->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </x-table.cell>
                                </tr>
                            @empty
                                <tr>
                                    <x-table.cell colspan="7" class="text-center py-4">
                                        Tidak ada data barang.
                                    </x-table.cell>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table>
                </div>
                
                <div class="mt-4">
                    {{ $barangs->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 