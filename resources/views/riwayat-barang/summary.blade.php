<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ringkasan Aktivitas Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Aktivitas Barang</h2>
                    <p class="text-sm text-gray-600 mt-1">Ringkasan aktivitas barang berdasarkan kategori dan jenis aktivitas</p>
                </div>

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Aktivitas</div>
                            <div class="text-xl font-semibold">{{ $summary->total ?? 0 }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Tambah</div>
                            <div class="text-xl font-semibold">{{ $summary->tambah ?? 0 }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Kurang</div>
                            <div class="text-xl font-semibold">{{ $summary->kurang ?? 0 }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Hapus</div>
                            <div class="text-xl font-semibold">{{ $summary->hapus ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <!-- By Category -->
                <div class="mb-8">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Aktivitas Berdasarkan Kategori</h3>
                    
                    @if(isset($summary->by_category) && count((array)$summary->by_category) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach((array)$summary->by_category as $category => $count)
                                <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $category)) }}</h4>
                                    <p class="text-2xl font-semibold mt-2">{{ $count }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-gray-500 text-sm">Tidak ada data kategori tersedia.</div>
                    @endif
                </div>

                <!-- By Date -->
                @if(isset($summary->by_date) && count((array)$summary->by_date) > 0)
                    <div class="mb-8">
                        <h3 class="text-md font-medium text-gray-700 mb-4">Aktivitas Berdasarkan Tanggal (7 Hari Terakhir)</h3>
                        
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Tanggal</x-table.heading>
                                    <x-table.heading>Tambah</x-table.heading>
                                    <x-table.heading>Kurang</x-table.heading>
                                    <x-table.heading>Hapus</x-table.heading>
                                    <x-table.heading>Total</x-table.heading>
                                </x-slot>
                                
                                <tbody>
                                    @foreach((array)$summary->by_date as $date => $data)
                                        <tr>
                                            <x-table.cell>{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</x-table.cell>
                                            <x-table.cell>{{ $data->tambah ?? 0 }}</x-table.cell>
                                            <x-table.cell>{{ $data->kurang ?? 0 }}</x-table.cell>
                                            <x-table.cell>{{ $data->hapus ?? 0 }}</x-table.cell>
                                            <x-table.cell>{{ ($data->tambah ?? 0) + ($data->kurang ?? 0) + ($data->hapus ?? 0) }}</x-table.cell>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                    </div>
                @endif

                <!-- Top Changed Items -->
                @if(isset($summary->top_items) && count((array)$summary->top_items) > 0)
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-4">Barang dengan Aktivitas Terbanyak</h3>
                        
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Kode Barang</x-table.heading>
                                    <x-table.heading>Nama Barang</x-table.heading>
                                    <x-table.heading>Kategori</x-table.heading>
                                    <x-table.heading>Jumlah Aktivitas</x-table.heading>
                                </x-slot>
                                
                                <tbody>
                                    @foreach((array)$summary->top_items as $item)
                                        <tr>
                                            <x-table.cell>{{ $item->kode_barang ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell>{{ $item->nama_barang ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell>{{ ucwords(str_replace('_', ' ', $item->kategori ?? 'N/A')) }}</x-table.cell>
                                            <x-table.cell>{{ $item->count ?? 0 }}</x-table.cell>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                    </div>
                @endif
                
                <div class="mt-6">
                    <a href="{{ route('riwayat-barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Lihat Semua Riwayat
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 