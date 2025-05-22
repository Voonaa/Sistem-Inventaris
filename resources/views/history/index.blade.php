<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Aktivitas Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <x-card class="mb-4">
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
            </x-card>
            
            <!-- Riwayat Barang Table -->
            <x-card>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Barang</h3>
                
                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Waktu</x-table.heading>
                            <x-table.heading>Petugas</x-table.heading>
                            <x-table.heading>Barang</x-table.heading>
                            <x-table.heading>Jenis Aktivitas</x-table.heading>
                            <x-table.heading>Jumlah</x-table.heading>
                            <x-table.heading>Catatan</x-table.heading>
                        </x-slot>

                        @forelse ($histories as $item)
                            <tr>
                                <x-table.cell>{{ $item->created_at->format('d-m-Y H:i') }}</x-table.cell>
                                <x-table.cell>{{ $item->user->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->barang->nama_barang ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>
                                    @if($item->jenis_aktivitas == 'masuk')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Masuk
                                        </span>
                                    @elseif($item->jenis_aktivitas == 'keluar')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Keluar
                                        </span>
                                    @elseif($item->jenis_aktivitas == 'peminjaman')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Peminjaman
                                        </span>
                                    @elseif($item->jenis_aktivitas == 'pengembalian')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Pengembalian
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($item->jenis_aktivitas) }}
                                        </span>
                                    @endif
                                </x-table.cell>
                                <x-table.cell>{{ $item->jumlah }}</x-table.cell>
                                <x-table.cell>{{ $item->keterangan ?? '-' }}</x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data riwayat barang</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $histories->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 