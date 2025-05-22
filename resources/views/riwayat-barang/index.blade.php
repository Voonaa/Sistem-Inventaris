<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Aktivitas Barang</h2>
                </div>

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Aktivitas</div>
                            <div class="text-xl font-semibold">{{ count($riwayatBarangs) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Tambah</div>
                            <div class="text-xl font-semibold">{{ $riwayatBarangs->where('jenis_aktivitas', 'tambah')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Kurang</div>
                            <div class="text-xl font-semibold">{{ $riwayatBarangs->where('jenis_aktivitas', 'kurang')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Hapus</div>
                            <div class="text-xl font-semibold">{{ $riwayatBarangs->where('jenis_aktivitas', 'hapus')->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Barang</x-table.heading>
                            <x-table.heading>Jenis Aktivitas</x-table.heading>
                            <x-table.heading>Jumlah</x-table.heading>
                            <x-table.heading>Stok Sebelum</x-table.heading>
                            <x-table.heading>Stok Sesudah</x-table.heading>
                            <x-table.heading>Petugas</x-table.heading>
                            <x-table.heading>Tanggal</x-table.heading>
                            <x-table.heading>Aksi</x-table.heading>
                        </x-slot>

                        <tbody>
                            @forelse($riwayatBarangs as $riwayat)
                                <tr>
                                    <x-table.cell>{{ $riwayat->id }}</x-table.cell>
                                    <x-table.cell>
                                        @if($riwayat->barang)
                                            {{ $riwayat->barang->nama_barang ?? 'N/A' }}
                                        @else
                                            <span class="text-gray-400">Barang telah dihapus</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($riwayat->jenis_aktivitas == 'tambah')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Tambah</span>
                                        @elseif($riwayat->jenis_aktivitas == 'kurang')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang</span>
                                        @elseif($riwayat->jenis_aktivitas == 'hapus')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Hapus</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst($riwayat->jenis_aktivitas) }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>{{ $riwayat->jumlah }}</x-table.cell>
                                    <x-table.cell>{{ $riwayat->stok_sebelum }}</x-table.cell>
                                    <x-table.cell>{{ $riwayat->stok_sesudah }}</x-table.cell>
                                    <x-table.cell>{{ $riwayat->user->name ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell>{{ $riwayat->created_at->format('d-m-Y H:i') }}</x-table.cell>
                                    <x-table.cell>
                                        <a href="{{ route('riwayat-barang.show', $riwayat->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </x-table.cell>
                                </tr>
                            @empty
                                <tr>
                                    <x-table.cell colspan="9" class="text-center py-4">
                                        <div class="text-gray-500">Tidak ada data riwayat barang</div>
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