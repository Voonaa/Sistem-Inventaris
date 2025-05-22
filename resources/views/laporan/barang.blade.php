<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Barang</h2>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Nama</x-table.heading>
                            <x-table.heading>Kategori</x-table.heading>
                            <x-table.heading>Sub Kategori</x-table.heading>
                            <x-table.heading>Stok</x-table.heading>
                        </x-slot>

                        @forelse($barang as $item)
                            <tr>
                                <x-table.cell>{{ $item->id }}</x-table.cell>
                                <x-table.cell>{{ $item->nama }}</x-table.cell>
                                <x-table.cell>{{ $item->kategori->nama ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->subKategori->nama ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->stok }}</x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="5" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data barang</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 