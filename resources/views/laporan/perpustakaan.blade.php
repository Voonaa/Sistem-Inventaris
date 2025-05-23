<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold">Data Perpustakaan</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('laporan.export', ['type' => 'perpustakaan']) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-sm">
                                Export Excel
                            </a>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Total Barang</div>
                                <div class="text-xl font-semibold">{{ count($barangPerpustakaan) }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Total Jumlah</div>
                                <div class="text-xl font-semibold">{{ $barangPerpustakaan->sum('stok') }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Sub Kategori</div>
                                <div class="text-xl font-semibold">{{ $barangPerpustakaan->pluck('sub_kategori')->unique()->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Barang Perpustakaan Section -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Barang Perpustakaan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sub Kategori</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barangPerpustakaan as $index => $item)
                                        <tr>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->kode_barang }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->nama_barang }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->sub_kategori_label ?? '-' }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->stok }} {{ $item->jumlah }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">
                                                @if($item->kondisi == 'baik')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                                @elseif($item->kondisi == 'kurang_baik')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center border-b border-gray-200">
                                                Tidak ada data barang perpustakaan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 