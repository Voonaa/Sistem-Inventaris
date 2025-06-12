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
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Total Barang</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ count($barangPerpustakaan) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6m-9-11H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-3m-7 0L9 9m2-2V3m2 4H9"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Total Jumlah</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ $barangPerpustakaan->sum('stok') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Sub Kategori</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ $barangPerpustakaan->pluck('sub_kategori')->unique()->count() }}</div>
                                    </div>
                                </div>
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