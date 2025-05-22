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