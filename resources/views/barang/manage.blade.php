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
                            <div class="text-sm text-gray-500">Total Stok</div>
                            <div class="text-xl font-semibold">{{ $barangs->sum('stok') }} / {{ $barangs->sum('jumlah') }}</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('barang.bulk-destroy') }}" method="POST" id="bulk-form">
                    @csrf
                    
                    <div class="overflow-x-auto">
                        <x-table>
                            <x-slot name="header">
                                <x-table.heading class="w-8">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </x-table.heading>
                                <x-table.heading>Kode</x-table.heading>
                                <x-table.heading>Nama</x-table.heading>
                                <x-table.heading>Kategori</x-table.heading>
                                <x-table.heading>Stok</x-table.heading>
                                <x-table.heading>Kondisi</x-table.heading>
                                <x-table.heading>Aksi</x-table.heading>
                            </x-slot>
                            
                            <tbody>
                                @forelse($barangs as $barang)
                                    <tr>
                                        <x-table.cell>
                                            <input type="checkbox" name="barang_ids[]" value="{{ $barang->id }}" class="barang-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </x-table.cell>
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
                                            @if($barang->kategori == 'perpustakaan' && $barang->sub_kategori)
                                                <span class="text-xs text-gray-500">
                                                    @php
                                                        $subCategoryLabel = '';
                                                        if(isset($categories['perpustakaan']['sub'][$barang->sub_kategori])) {
                                                            $subCategoryLabel = $categories['perpustakaan']['sub'][$barang->sub_kategori];
                                                        } else {
                                                            $subCategoryLabel = ucfirst(str_replace('_', ' ', $barang->sub_kategori));
                                                        }
                                                    @endphp
                                                    ({{ $subCategoryLabel }})
                                                </span>
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
                    
                    <div class="mt-4 flex justify-between items-center">
                        @if($barangs->count() > 0)
                            <button type="button" id="bulk-delete-btn" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Hapus Barang Terpilih
                            </button>
                        @else
                            <div></div>
                        @endif
                        
                        <div class="mt-4">
                            @if(isset($activeKategori) || isset($activeSub))
                                {{ $barangs->appends(['kategori' => $activeKategori, 'sub' => $activeSub])->links() }}
                            @else
                                {{ $barangs->links() }}
                            @endif
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <!-- Confirmation Modal for Bulk Delete -->
    <div x-data="{ open: false }" x-show="open" class="fixed inset-0 overflow-y-auto z-50" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" class="fixed inset-0 transition-opacity" @click="open = false" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Hapus Barang Terpilih
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus semua barang yang dipilih? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" id="confirm-bulk-delete">
                        Hapus
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle bulk select/deselect
            const selectAllCheckbox = document.getElementById('select-all');
            const barangCheckboxes = document.querySelectorAll('.barang-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            
            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.barang-checkbox:checked').length;
                bulkDeleteBtn.disabled = checkedCount === 0;
                if (checkedCount > 0) {
                    bulkDeleteBtn.textContent = `Hapus ${checkedCount} Barang Terpilih`;
                } else {
                    bulkDeleteBtn.textContent = 'Hapus Barang Terpilih';
                }
            }
            
            selectAllCheckbox.addEventListener('change', function() {
                barangCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateBulkDeleteButton();
            });
            
            barangCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(barangCheckboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(barangCheckboxes).some(cb => cb.checked);
                    
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = anyChecked && !allChecked;
                    
                    updateBulkDeleteButton();
                });
            });
            
            // Handle bulk delete
            const bulkForm = document.getElementById('bulk-form');
            const bulkDeleteModal = document.querySelector('[x-data="{ open: false }"]');
            const confirmBulkDeleteBtn = document.getElementById('confirm-bulk-delete');
            
            bulkDeleteBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.barang-checkbox:checked').length > 0) {
                    // Open the confirmation modal using Alpine.js
                    const alpineInstance = Alpine.data('{ open: false }');
                    if (alpineInstance) {
                        // We need to set the Alpine data property
                        // Since we cannot directly manipulate Alpine internals, we use this approach
                        bulkDeleteModal.__x.$data.open = true;
                    }
                }
            });
            
            confirmBulkDeleteBtn.addEventListener('click', function() {
                bulkForm.submit();
            });
        });
    </script>
    @endpush
</x-app-layout> 