<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <x-card>
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z" fill="currentColor"></path>
                                <path d="M22.4 23.1C22.4 24.2598 21.4598 25.2 20.3 25.2C19.1403 25.2 18.2 24.2598 18.2 23.1C18.2 21.9402 19.1403 21 20.3 21C21.4598 21 22.4 21.9402 22.4 23.1Z" fill="currentColor"></path>
                                <path d="M9.1 25.2C10.2598 25.2 11.2 24.2598 11.2 23.1C11.2 21.9402 10.2598 21 9.1 21C7.9402 21 7 21.9402 7 23.1C7 24.2598 7.9402 25.2 9.1 25.2Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalBarang }}</h4>
                            <div class="text-gray-500">Total Barang</div>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalPeminjaman }}</h4>
                            <div class="text-gray-500">Total Peminjaman</div>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalRiwayatBarang }}</h4>
                            <div class="text-gray-500">Total Riwayat Barang</div>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-card>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Peminjaman Terbaru</h3>
                    @if($recentPeminjaman->count() > 0)
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Barang</x-table.heading>
                                    <x-table.heading>Peminjam</x-table.heading>
                                    <x-table.heading>Tanggal Pinjam</x-table.heading>
                                    <x-table.heading>Status</x-table.heading>
                                </x-slot>
                                @foreach($recentPeminjaman as $peminjaman)
                                    <tr>
                                        <x-table.cell>{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell>{{ $peminjaman->peminjam ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell>{{ $peminjaman->tanggal_pinjam ? date('d-m-Y', strtotime($peminjaman->tanggal_pinjam)) : 'N/A' }}</x-table.cell>
                                        <x-table.cell>
                                            @if($peminjaman->status == 'dipinjam')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Dipinjam
                                                </span>
                                            @elseif($peminjaman->status == 'dikembalikan')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Dikembalikan
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($peminjaman->status) }}
                                                </span>
                                            @endif
                                        </x-table.cell>
                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada data peminjaman terbaru.</p>
                    @endif
                </x-card>

                <x-card>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Barang Terbaru</h3>
                    @if($recentRiwayat->count() > 0)
                        <div class="overflow-x-auto">
                            <x-table>
                                <x-slot name="header">
                                    <x-table.heading>Barang</x-table.heading>
                                    <x-table.heading>Petugas</x-table.heading>
                                    <x-table.heading>Tanggal</x-table.heading>
                                    <x-table.heading>Aktivitas</x-table.heading>
                                </x-slot>
                                @foreach($recentRiwayat as $riwayat)
                                    <tr>
                                        <x-table.cell>{{ $riwayat->barang->nama_barang ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell>{{ $riwayat->user->name ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell>{{ $riwayat->created_at ? date('d-m-Y', strtotime($riwayat->created_at)) : 'N/A' }}</x-table.cell>
                                        <x-table.cell>
                                            @if($riwayat->jenis_aktivitas == 'peminjaman')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Peminjaman
                                                </span>
                                            @elseif($riwayat->jenis_aktivitas == 'pengembalian')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pengembalian
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($riwayat->jenis_aktivitas) }}
                                                </span>
                                            @endif
                                        </x-table.cell>
                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada data riwayat barang terbaru.</p>
                    @endif
                </x-card>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('laporan.barang') }}" class="block">
                    <x-card>
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 text-lg font-semibold">Laporan Barang</div>
                        </div>
                    </x-card>
                </a>

                <a href="{{ route('laporan.perpustakaan') }}" class="block">
                    <x-card>
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-600 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-4 text-lg font-semibold">Laporan Perpustakaan</div>
                        </div>
                    </x-card>
                </a>

                <a href="{{ route('laporan.peminjaman') }}" class="block">
                    <x-card>
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 text-lg font-semibold">Laporan Peminjaman</div>
                        </div>
                    </x-card>
                </a>

                <a href="{{ route('laporan.riwayat-barang') }}" class="block">
                    <x-card>
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4 text-lg font-semibold">Riwayat Barang</div>
                        </div>
                    </x-card>
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 