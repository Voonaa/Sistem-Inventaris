<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Barang') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $barang->nama_barang }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kode Barang</p>
                                        <p class="font-semibold">{{ $barang->kode_barang }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kategori</p>
                                        <p class="font-semibold">{{ $kategoriLabel }}</p>
                                    </div>
                                    
                                    @if($barang->kategori == 'perpustakaan')
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Sub Kategori</p>
                                        <p class="font-semibold">{{ $subKategoriLabel ?? 'N/A' }}</p>
                                    </div>
                                    @endif

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kondisi</p>
                                        <div>
                                            @if($barang->kondisi == 'Baik')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                            @elseif($barang->kondisi == 'Kurang Baik')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                            @elseif($barang->kondisi == 'Rusak')
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $barang->kondisi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Jumlah Total</p>
                                        <p class="font-semibold">{{ $barang->jumlah }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Stok</p>
                                        <p class="font-semibold">{{ $barang->stok }}</p>
                                    </div>
                                    
                                    @if($barang->tahun_perolehan)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Tahun Perolehan</p>
                                        <p class="font-semibold">{{ $barang->tahun_perolehan }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($barang->harga_perolehan)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Harga Perolehan</p>
                                        <p class="font-semibold">Rp {{ number_format($barang->harga_perolehan, 0, ',', '.') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($barang->deskripsi)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Deskripsi</p>
                                <p>{{ $barang->deskripsi }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div>
                            @if($barang->gambar)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar</p>
                                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" class="w-full rounded-lg">
                            </div>
                            @endif
                            
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-md font-semibold text-gray-800 mb-2">Informasi Tambahan</h4>
                                
                                @if($barang->merek)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Merek</p>
                                    <p class="font-semibold">{{ $barang->merek }}</p>
                                </div>
                                @endif
                                
                                @if($barang->model)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Model</p>
                                    <p class="font-semibold">{{ $barang->model }}</p>
                                </div>
                                @endif
                                
                                @if($barang->nomor_seri)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Nomor Seri</p>
                                    <p class="font-semibold">{{ $barang->nomor_seri }}</p>
                                </div>
                                @endif
                                
                                @if($barang->lokasi)
                                <div>
                                    <p class="text-sm text-gray-600">Lokasi</p>
                                    <p class="font-semibold">{{ $barang->lokasi }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($barang->riwayatBarangs->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Barang</h3>
                        
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Aksi</x-table.heading>
                                    <x-table.heading>Jumlah</x-table.heading>
                                    <x-table.heading>Keterangan</x-table.heading>
                                    <x-table.heading>User</x-table.heading>
                                    <x-table.heading>Tanggal</x-table.heading>
                                </x-slot>
                                
                                <tbody>
                                    @foreach($barang->riwayatBarangs as $riwayat)
                                        <tr>
                                            <x-table.cell>
                                                @php
                                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                                    
                                                    if ($riwayat->jenis_aktivitas === 'tambah') {
                                                        $badgeClass = 'bg-green-100 text-green-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'kurang' || $riwayat->jenis_aktivitas === 'penyesuaian') {
                                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'peminjaman') {
                                                        $badgeClass = 'bg-blue-100 text-blue-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'pengembalian') {
                                                        $badgeClass = 'bg-purple-100 text-purple-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'perbaikan') {
                                                        $badgeClass = 'bg-orange-100 text-orange-800';
                                                    }
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded-full {{ $badgeClass }}">
                                                    {{ ucfirst($riwayat->jenis_aktivitas) }}
                                                </span>
                                            </x-table.cell>
                                            <x-table.cell>{{ $riwayat->jumlah }}</x-table.cell>
                                            <x-table.cell>{{ $riwayat->keterangan }}</x-table.cell>
                                            <x-table.cell>{{ $riwayat->user->name ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell>{{ $riwayat->created_at->format('d/m/Y H:i') }}</x-table.cell>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('barang.edit', $barang->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                            Edit Barang
                        </a>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Hapus Barang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 