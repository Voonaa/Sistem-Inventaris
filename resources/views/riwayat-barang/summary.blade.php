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

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Aktivitas</div>
                                <div class="text-xl font-semibold text-gray-900">{{ $summary->total_activities ?? 0 }}</div>
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
                                <div class="text-sm font-medium text-gray-500">Tambah</div>
                                <div class="text-xl font-semibold text-gray-900">{{ $summary->total_tambah ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Kurang</div>
                                <div class="text-xl font-semibold text-gray-900">{{ $summary->total_kurang ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Hapus</div>
                                <div class="text-xl font-semibold text-gray-900">{{ $summary->total_hapus ?? 0 }}</div>
                            </div>
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
                                            <x-table.cell>
                                                @if(($data->tambah ?? 0) > 0)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $data->tambah }}</span>
                                                @else
                                                    {{ $data->tambah ?? 0 }}
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                @if(($data->kurang ?? 0) > 0)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $data->kurang }}</span>
                                                @else
                                                    {{ $data->kurang ?? 0 }}
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                @if(($data->hapus ?? 0) > 0)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">{{ $data->hapus }}</span>
                                                @else
                                                    {{ $data->hapus ?? 0 }}
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                <span class="font-medium">{{ ($data->tambah ?? 0) + ($data->kurang ?? 0) + ($data->hapus ?? 0) }}</span>
                                            </x-table.cell>
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