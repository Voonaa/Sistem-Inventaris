<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <!-- Total Items -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Total Barang</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalBarang }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </x-card>

                <!-- Stok Baik -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Stok Baik</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $stokBaik }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </x-card>

                <!-- Stok Kurang Baik -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Stok Kurang Baik</h3>
                            <p class="text-3xl font-bold text-yellow-600">{{ $stokKurang }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </x-card>

                <!-- Stok Rusak -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Stok Rusak</h3>
                            <p class="text-3xl font-bold text-red-600">{{ $stokRusak }}</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </x-card>

                <!-- Active Loans -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                            <p class="text-3xl font-bold text-purple-600">{{ $activeLoans }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Content Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Low Stock Items -->
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Stok Rendah (< 5)</h3>
                    @if(count($lowStock) > 0)
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Kode</x-table.heading>
                                    <x-table.heading>Nama</x-table.heading>
                                    <x-table.heading>Stok</x-table.heading>
                                </x-slot>
                                <tbody>
                                    @foreach($lowStock as $barang)
                                        <tr>
                                            <x-table.cell>{{ $barang->kode_barang }}</x-table.cell>
                                            <x-table.cell>{{ $barang->nama_barang ?? $barang->nama }}</x-table.cell>
                                            <x-table.cell>
                                                <span class="px-2 py-1 text-xs rounded-full {{ $barang->stok < 2 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $barang->stok }}
                                                </span>
                                            </x-table.cell>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('barang.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua barang →</a>
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada barang dengan stok rendah.</p>
                    @endif
                </x-card>

                <!-- Recent Activity -->
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h3>
                    @if(count($recentHistory) > 0)
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Barang</x-table.heading>
                                    <x-table.heading>Aksi</x-table.heading>
                                    <x-table.heading>User</x-table.heading>
                                    <x-table.heading>Waktu</x-table.heading>
                                </x-slot>
                                <tbody>
                                    @foreach($recentHistory as $history)
                                        <tr>
                                            <x-table.cell>
                                                @if($history->barang)
                                                    {{ $history->barang->nama_barang ?? $history->barang->nama }}
                                                @elseif($history->buku)
                                                    {{ $history->buku->judul }}
                                                @else
                                                    N/A
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                @php
                                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                                    
                                                    if ($history->jenis_aktivitas === 'tambah') {
                                                        $badgeClass = 'bg-green-100 text-green-800';
                                                    } elseif ($history->jenis_aktivitas === 'kurang' || $history->jenis_aktivitas === 'penyesuaian') {
                                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                    } elseif ($history->jenis_aktivitas === 'peminjaman') {
                                                        $badgeClass = 'bg-blue-100 text-blue-800';
                                                    } elseif ($history->jenis_aktivitas === 'pengembalian') {
                                                        $badgeClass = 'bg-purple-100 text-purple-800';
                                                    } elseif ($history->jenis_aktivitas === 'perbaikan') {
                                                        $badgeClass = 'bg-orange-100 text-orange-800';
                                                    }
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded-full {{ $badgeClass }}">
                                                    {{ ucfirst($history->jenis_aktivitas) }}
                                                </span>
                                            </x-table.cell>
                                            <x-table.cell>{{ $history->user->name ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell>{{ $history->created_at->format('d/m/Y H:i') }}</x-table.cell>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('riwayat-barang.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua aktivitas →</a>
                </div>
                    @else
                        <p class="text-gray-500">Tidak ada aktivitas terbaru.</p>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
