<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold">Data Peminjaman</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('laporan.export', ['type' => 'peminjaman']) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-sm">
                                Export Excel
                            </a>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Total Peminjaman</div>
                                <div class="text-xl font-semibold">{{ count($peminjamans) }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Masih Dipinjam</div>
                                <div class="text-xl font-semibold">{{ $peminjamans->where('status', 'dipinjam')->count() }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Sudah Dikembalikan</div>
                                <div class="text-xl font-semibold">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barang</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Kembali</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $index => $item)
                                    <tr>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->kode_peminjaman ?? $item->id }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->barang->nama_barang ?? ($item->buku->judul ?? 'N/A') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->tanggal_pinjam ? date('d-m-Y', strtotime($item->tanggal_pinjam)) : 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->tanggal_kembali ? date('d-m-Y', strtotime($item->tanggal_kembali)) : 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">
                                            @if($item->status == 'dipinjam')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                    Dipinjam
                                                </span>
                                            @elseif($item->status == 'dikembalikan')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Dikembalikan
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center border-b border-gray-200">Tidak ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 