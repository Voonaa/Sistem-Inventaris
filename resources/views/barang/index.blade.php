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
                        <a href="{{ route('barang.manage') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
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
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Total Barang</div>
                                    <div class="text-xl font-semibold text-gray-900">{{ $barangs->total() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Kondisi Baik</div>
                                    <div class="text-xl font-semibold text-gray-900">{{ $barangs->where('kondisi', 'baik')->count() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Kondisi Rusak</div>
                                    <div class="text-xl font-semibold text-gray-900">{{ $barangs->where('kondisi', 'rusak')->count() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Sedang Dipinjam</div>
                                    <div class="text-xl font-semibold text-gray-900">{{ $barangs->filter(function($barang) { return $barang->stok < $barang->jumlah; })->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Box -->
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Cari barang (kode, nama, kategori, kondisi...)">
                    </div>
                    <div class="mt-1 text-sm text-gray-500">
                        Hasil pencarian: <span id="searchCount">{{ $barangs->count() }}</span> barang ditemukan
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="barangTable" class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sub Kategori</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kondisi</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($barangs as $index => $barang)
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $barang->kode_barang }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $barang->nama_barang }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
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
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
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
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        {{ $barang->stok }} {{ $barang->jumlah }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        @if($barang->kondisi == 'baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                        @elseif($barang->kondisi == 'kurang_baik')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                        @elseif($barang->kondisi == 'rusak')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst(str_replace('_', ' ', $barang->kondisi)) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-2 text-center border-b border-gray-200">
                                        Tidak ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

    <!-- JavaScript for Quick Search -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#barangTable tbody tr');
            const searchCount = document.getElementById('searchCount');
            
            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();
                let visibleCount = 0;
                
                tableRows.forEach(row => {
                    // Skip empty message row if it exists
                    if (row.querySelector('td[colspan="8"]')) {
                        row.style.display = tableRows.length === 1 ? '' : 'none';
                        return;
                    }
                    
                    const cells = row.querySelectorAll('td');
                    let found = false;
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                searchCount.textContent = visibleCount;
                
                // Show empty message if no rows match
                if (visibleCount === 0 && tableRows.length > 1) {
                    const firstRow = tableRows[0];
                    if (firstRow.querySelector('td[colspan="8"]')) {
                        firstRow.style.display = '';
                    }
                }
            });
        });
    </script>
</x-app-layout> 