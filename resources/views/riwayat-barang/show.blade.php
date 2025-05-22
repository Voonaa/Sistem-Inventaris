<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('riwayat-barang.index') }}" class="text-blue-600 hover:text-blue-900">
                    <span class="inline-flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Riwayat
                    </span>
                </a>
            </div>

            <x-card>
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Aktivitas Barang</h2>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ID Aktivitas</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->id }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->created_at->format('d-m-Y H:i:s') }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jenis Aktivitas</dt>
                                <dd class="mt-1 text-sm">
                                    @if($riwayatBarang->jenis_aktivitas == 'tambah')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Tambah</span>
                                    @elseif($riwayatBarang->jenis_aktivitas == 'kurang')
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang</span>
                                    @elseif($riwayatBarang->jenis_aktivitas == 'hapus')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Hapus</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst($riwayatBarang->jenis_aktivitas) }}</span>
                                    @endif
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Petugas</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->user->name ?? 'N/A' }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->jumlah }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stok Sebelum</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->stok_sebelum }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stok Sesudah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->stok_sesudah }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->keterangan ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                
                @if($riwayatBarang->barang)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Barang</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kode Barang</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->barang->kode_barang }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Barang</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->barang->nama_barang }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->barang->kategori_label }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stok Saat Ini</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->barang->stok }} / {{ $riwayatBarang->barang->jumlah }}</dd>
                            </div>
                            
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $riwayatBarang->barang->deskripsi ?? '-' }}</dd>
                            </div>
                            
                            @if($riwayatBarang->barang->gambar)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Gambar</dt>
                                <dd class="mt-1">
                                    <img src="{{ asset('storage/' . $riwayatBarang->barang->gambar) }}" 
                                         alt="{{ $riwayatBarang->barang->nama_barang }}" 
                                         class="h-48 object-contain">
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
                @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Barang terkait dengan aktivitas ini telah dihapus.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="mt-6">
                    <a href="{{ route('riwayat-barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 