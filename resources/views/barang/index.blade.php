<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
            @if(isset($activeKategori))
                <span class="text-gray-500 font-normal text-lg">
                    › {{ ucwords(str_replace('_', ' ', $activeKategori)) }}
                    @if(isset($activeSub) && $activeKategori === 'perpustakaan')
                        › {{ ucwords(str_replace('_', ' ', $activeSub)) }}
                    @endif
                </span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            @if(isset($activeKategori))
                                @php
                                    $categoryLabel = isset($categories[$activeKategori]) 
                                        ? (is_array($categories[$activeKategori]) 
                                            ? $categories[$activeKategori]['label'] 
                                            : $categories[$activeKategori])
                                        : ucwords(str_replace('_', ' ', $activeKategori));
                                    
                                    $subCategoryLabel = null;
                                    if(isset($activeSub) && $activeKategori === 'perpustakaan') {
                                        $subCategoryLabel = isset($categories['perpustakaan']['sub'][$activeSub]) 
                                            ? $categories['perpustakaan']['sub'][$activeSub]
                                            : ucwords(str_replace('_', ' ', $activeSub));
                                    }
                                @endphp
                                
                                Kategori: <span class="text-blue-600">{{ $categoryLabel }}</span>
                                @if($subCategoryLabel)
                                    › <span class="text-blue-600">{{ $subCategoryLabel }}</span>
                                @endif
                            @else
                                Manajemen Barang
                            @endif
                        </h3>
                        
                        @if(isset($activeKategori))
                            <a href="{{ route('barang.index') }}" class="text-sm text-blue-500 hover:underline mt-1 inline-block">
                                « Tampilkan semua barang
                            </a>
                        @endif
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('barang.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Tambah Barang
                        </a>
                        <a href="{{ route('barang.manage') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                            Hapus Barang
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Barang</div>
                            <div class="text-xl font-semibold">{{ $barangs->total() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Stok</div>
                            <div class="text-xl font-semibold">{{ $barangs->sum('stok') }} / {{ $barangs->sum('jumlah') }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Kondisi Baik</div>
                            <div class="text-xl font-semibold">{{ $barangs->where('kondisi', 'Baik')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Stok Tersedia</div>
                            <div class="text-xl font-semibold">{{ round(($barangs->sum('stok') / max(1, $barangs->sum('jumlah'))) * 100) }}%</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Kode</x-table.heading>
                            <x-table.heading>Nama</x-table.heading>
                            <x-table.heading>Kategori</x-table.heading>
                            <x-table.heading>Sub Kategori</x-table.heading>
                            <x-table.heading>Stok</x-table.heading>
                            <x-table.heading>Kondisi</x-table.heading>
                            <x-table.heading>Aksi</x-table.heading>
                        </x-slot>
                        
                        <tbody>
                            @forelse($barangs as $barang)
                                <tr>
                                    <x-table.cell>{{ $barang->kode_barang }}</x-table.cell>
                                    <x-table.cell>{{ $barang->nama_barang }}</x-table.cell>
                                    <x-table.cell>
                                        @php
                                            $categoryLabel = '';
                                            if(isset($categories[$barang->kategori])) {
                                                $categoryLabel = is_array($categories[$barang->kategori]) 
                                                    ? $categories[$barang->kategori]['label'] 
                                                    : $categories[$barang->kategori];
                                            } else {
                                                $categoryLabel = ucfirst(str_replace('_', ' ', $barang->kategori));
                                            }
                                        @endphp
                                        {{ $categoryLabel }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($barang->kategori == 'perpustakaan' && $barang->sub_kategori)
                                            @php
                                                $subCategoryLabel = '';
                                                if(isset($categories['perpustakaan']['sub'][$barang->sub_kategori])) {
                                                    $subCategoryLabel = $categories['perpustakaan']['sub'][$barang->sub_kategori];
                                                } else {
                                                    $subCategoryLabel = ucfirst(str_replace('_', ' ', $barang->sub_kategori));
                                                }
                                            @endphp
                                            {{ $subCategoryLabel }}
                                        @else
                                            -
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $barang->stok }} / {{ $barang->jumlah }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($barang->kondisi == 'Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                        @elseif($barang->kondisi == 'Kurang Baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                        @elseif($barang->kondisi == 'Rusak')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $barang->kondisi }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('barang.show', $barang->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('barang.edit', $barang->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </x-table.cell>
                                </tr>
                            @empty
                                <tr>
                                    <x-table.cell colspan="7" class="text-center py-4">
                                        Tidak ada data barang.
                                    </x-table.cell>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table>
                </div>
                
                <div class="mt-4">
                    @if(isset($activeKategori) || isset($activeSub))
                        {{ $barangs->appends(['kategori' => $activeKategori, 'sub' => $activeSub])->links() }}
                    @else
                        {{ $barangs->links() }}
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 