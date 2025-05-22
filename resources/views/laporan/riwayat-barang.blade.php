<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Riwayat Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Riwayat Barang</h2>
                </div>

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Riwayat</div>
                            <div class="text-xl font-semibold">{{ count($riwayat) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Barang Masuk</div>
                            <div class="text-xl font-semibold">{{ $riwayat->where('tipe_riwayat', 'masuk')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Barang Keluar</div>
                            <div class="text-xl font-semibold">{{ $riwayat->where('tipe_riwayat', 'keluar')->count() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Transaksi</div>
                            <div class="text-xl font-semibold">{{ $riwayat->sum('jumlah') }}</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Barang</x-table.heading>
                            <x-table.heading>Petugas</x-table.heading>
                            <x-table.heading>Tipe</x-table.heading>
                            <x-table.heading>Jumlah</x-table.heading>
                            <x-table.heading>Tanggal</x-table.heading>
                            <x-table.heading>Keterangan</x-table.heading>
                        </x-slot>

                        @forelse($riwayat as $item)
                            <tr>
                                <x-table.cell>{{ $item->id }}</x-table.cell>
                                <x-table.cell>{{ $item->barang->nama ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->user->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>
                                    @if($item->tipe_riwayat == 'masuk')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Masuk
                                        </span>
                                    @elseif($item->tipe_riwayat == 'keluar')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Keluar
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($item->tipe_riwayat) }}
                                        </span>
                                    @endif
                                </x-table.cell>
                                <x-table.cell>{{ $item->jumlah }}</x-table.cell>
                                <x-table.cell>{{ $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->keterangan ?? '-' }}</x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="7" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data riwayat barang</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 