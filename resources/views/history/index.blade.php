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
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Total Aktivitas</div>
                                <div class="text-xl font-semibold">{{ count($histories) }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Barang Masuk</div>
                                <div class="text-xl font-semibold">{{ $histories->where('jenis_aktivitas', 'masuk')->count() }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Barang Keluar</div>
                                <div class="text-xl font-semibold">{{ $histories->where('jenis_aktivitas', 'keluar')->count() }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">Perubahan</div>
                                <div class="text-xl font-semibold">{{ $histories->whereNotIn('jenis_aktivitas', ['masuk', 'keluar'])->count() }}</div>
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
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    Pengembalian
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