<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Barang: ') }} {{ $barang->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('riwayat-barang.item') }}" class="text-blue-600 hover:text-blue-900">
                    <span class="inline-flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Pilih Barang Lain
                    </span>
                </a>
            </div>

            <div class="mb-6">
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Barang</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kode Barang</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $barang->kode_barang }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Barang</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $barang->nama_barang }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ ucwords(str_replace('_', ' ', $barang->kategori)) }}
                                        @if($barang->sub_kategori)
                                            <span class="text-gray-500">
                                                » {{ ucwords(str_replace('_', ' ', $barang->sub_kategori)) }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $barang->stok }} / {{ $barang->jumlah }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kondisi</dt>
                                    <dd class="mt-1">
                                        @if($barang->kondisi == 'Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                        @elseif($barang->kondisi == 'Kurang Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                        @elseif($barang->kondisi == 'Rusak')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $barang->kondisi }}</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            @if($barang->gambar)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Gambar</h4>
                                    <img src="{{ asset('storage/' . $barang->gambar) }}" 
                                         alt="{{ $barang->nama_barang }}" 
                                         class="h-48 object-contain">
                                </div>
                            @endif
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi</h4>
                                <p class="text-sm text-gray-900">{{ $barang->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            <x-card>
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Aktivitas</h2>
                    <p class="text-sm text-gray-600 mt-1">Daftar seluruh aktivitas untuk barang ini</p>
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
                                    <div class="text-xl font-semibold text-gray-900">{{ count($riwayat) }}</div>
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
                                    <div class="text-xl font-semibold text-gray-900">{{ $riwayat->where('jenis_aktivitas', 'tambah')->count() }}</div>
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
                                    <div class="text-xl font-semibold text-gray-900">{{ $riwayat->where('jenis_aktivitas', 'kurang')->count() }}</div>
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
                                    <div class="text-xl font-semibold text-gray-900">{{ $riwayat->where('jenis_aktivitas', 'hapus')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Jenis Aktivitas</x-table.heading>
                            <x-table.heading>Jumlah</x-table.heading>
                            <x-table.heading>Jumlah Sebelum</x-table.heading>
                            <x-table.heading>Jumlah Sesudah</x-table.heading>
                            <x-table.heading>Petugas</x-table.heading>
                            <x-table.heading>Tanggal</x-table.heading>
                        </x-slot>
                        
                        <tbody>
                            @forelse($riwayat as $item)
                                <tr>
                                    <x-table.cell>{{ $item->id }}</x-table.cell>
                                    <x-table.cell>
                                        @if($item->jenis_aktivitas == 'tambah')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Tambah</span>
                                        @elseif($item->jenis_aktivitas == 'kurang')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang</span>
                                        @elseif($item->jenis_aktivitas == 'hapus')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Hapus</span>
                                        @elseif($item->jenis_aktivitas == 'perbaikan')
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Perbaikan</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst($item->jenis_aktivitas) }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $item->jumlah }}</x-table.cell>
                                    <x-table.cell>{{ $item->stok_sebelum }}</x-table.cell>
                                    <x-table.cell>{{ $item->stok_sesudah }}</x-table.cell>
                                    <x-table.cell>{{ $item->user->name ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell>{{ $item->created_at->format('d-m-Y H:i') }}</x-table.cell>
                                </tr>
                            @empty
                                <tr>
                                    <x-table.cell colspan="7" class="text-center">
                                        <div class="text-gray-500">Tidak ada data riwayat untuk barang ini</div>
                                    </x-table.cell>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 