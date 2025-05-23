<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Aktivitas Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('history.filter') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="w-full mt-1" :value="$startDate ?? ''" />
                            </div>
                            
                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Akhir')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="w-full mt-1" :value="$endDate ?? ''" />
                            </div>
                            
                            <div>
                                <x-input-label for="barang_id" :value="__('Barang')" />
                                <select id="barang_id" name="barang_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Semua Barang</option>
                                    @foreach(App\Models\Barang::orderBy('nama_barang')->get() as $barang)
                                        <option value="{{ $barang->id }}" {{ isset($barangId) && $barangId == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="self-end">
                                <x-primary-button type="submit" class="w-full justify-center">
                                    {{ __('Filter') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Riwayat Barang Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Riwayat Barang</h3>
                        <!-- CSV Export Button -->
                        <a href="{{ route('laporan.export', ['type' => 'history']) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-sm">
                            Export Excel
                        </a>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Total Aktivitas</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ count($histories) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Barang Masuk</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ $histories->where('jenis_aktivitas', 'masuk')->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Barang Keluar</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ $histories->where('jenis_aktivitas', 'keluar')->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-500">Perubahan</div>
                                        <div class="text-xl font-semibold text-gray-900">{{ $histories->whereNotIn('jenis_aktivitas', ['masuk', 'keluar'])->count() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Petugas</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barang</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Aktivitas</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $index => $item)
                                    <tr>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">
                                            @if($item->jenis_aktivitas == 'masuk')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Masuk
                                                </span>
                                            @elseif($item->jenis_aktivitas == 'keluar')
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                    Keluar
                                                </span>
                                            @elseif($item->jenis_aktivitas == 'peminjaman')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                    Peminjaman
                                                </span>
                                            @elseif($item->jenis_aktivitas == 'pengembalian')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Pengembalian
                                                </span>
                                            @elseif($item->jenis_aktivitas == 'perbaikan')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    Perbaikan
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($item->jenis_aktivitas) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->jumlah }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ $item->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center border-b border-gray-200">Tidak ada data riwayat barang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 