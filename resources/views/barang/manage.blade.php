<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hapus Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Item List (full width) -->
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Barang</h3>
                    
                    <!-- Filter Form -->
                    <div class="flex space-x-2">
                        <form action="{{ route('barang.manage') }}" method="GET" class="flex space-x-2">
                            <select name="kategori" class="text-sm rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $key => $category)
                                    <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                        @if(is_array($category))
                                            {{ $category['label'] }}
                                        @else
                                            {{ $category }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            
                            @if(request('kategori') === 'perpustakaan')
                                <select name="sub" class="text-sm rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Semua Sub Kategori</option>
                                    @foreach($categories['perpustakaan']['sub'] as $subKey => $subValue)
                                        <option value="{{ $subKey }}" {{ request('sub') == $subKey ? 'selected' : '' }}>
                                            {{ $subValue }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                            @if(request('kategori') || request('sub'))
                                <a href="{{ route('barang.manage') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">Reset</a>
                            @endif
                        </form>
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
                            <div class="text-sm text-gray-500">Barang Kondisi Baik</div>
                            <div class="text-xl font-semibold">{{ $barangs->where('kondisi', 'Baik')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Barang Kondisi Rusak</div>
                            <div class="text-xl font-semibold">{{ $barangs->where('kondisi', 'Rusak')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Jumlah</div>
                            <div class="text-xl font-semibold">{{ $barangs->sum('stok') }} {{ $barangs->sum('jumlah') }}</div>
                        </div>
                    </div>
                </div>

                @if(session('debug'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                    <p>Debug Info: {{ session('debug') }}</p>
                </div>
                @endif

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
                                        {{ $barang->kategori->nama ?? 'Tidak Ada Kategori' }}
                                        @if($barang->subKategori)
                                            <span class="text-xs text-gray-500">
                                                ({{ $barang->subKategori->nama }})
                                            </span>
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

                                            <!-- Direct delete link -->
                                            <a href="{{ route('barang.bulk-destroy-get') }}?ids={{ $barang->id }}" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')"
                                               class="text-red-600 hover:text-red-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-center border-b border-gray-200">
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
                    if (row.querySelector('td[colspan="7"]')) {
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
                    if (firstRow.querySelector('td[colspan="7"]')) {
                        firstRow.style.display = '';
                    }
                }
            });
        });
    </script>
</x-app-layout> 