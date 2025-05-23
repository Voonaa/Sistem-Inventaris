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

                    <!-- Buku Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Buku</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penulis</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($buku as $index => $book)
                                        <tr>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $book->judul }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $book->penulis }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $book->tahun_terbit }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $book->jumlah }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $book->status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($book->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center border-b border-gray-200">Tidak ada data buku</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barangPerpustakaan as $index => $item)
                                        <tr>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->kode_barang }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->nama_barang }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->sub_kategori ?? '-' }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">{{ $item->stok }} / {{ $item->jumlah }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200">
                                                @if($item->kondisi == 'Baik')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                                @elseif($item->kondisi == 'Kurang Baik')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                                @elseif($item->kondisi == 'Rusak')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $item->kondisi }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center border-b border-gray-200">Tidak ada data barang perpustakaan</td>
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