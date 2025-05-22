<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Buku</h2>
                </div>

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Ringkas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Buku</div>
                            <div class="text-xl font-semibold">{{ count($buku) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Total Stok</div>
                            <div class="text-xl font-semibold">{{ $buku->sum('stok') }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm text-gray-500">Rata-rata Tahun Terbit</div>
                            <div class="text-xl font-semibold">{{ $buku->avg('tahun_terbit') ? round($buku->avg('tahun_terbit')) : '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Judul</x-table.heading>
                            <x-table.heading>Penulis</x-table.heading>
                            <x-table.heading>Penerbit</x-table.heading>
                            <x-table.heading>Tahun Terbit</x-table.heading>
                            <x-table.heading>Stok</x-table.heading>
                        </x-slot>

                        @forelse($buku as $item)
                            <tr>
                                <x-table.cell>{{ $item->id }}</x-table.cell>
                                <x-table.cell>{{ $item->judul }}</x-table.cell>
                                <x-table.cell>{{ $item->penulis }}</x-table.cell>
                                <x-table.cell>{{ $item->penerbit }}</x-table.cell>
                                <x-table.cell>{{ $item->tahun_terbit }}</x-table.cell>
                                <x-table.cell>{{ $item->stok }}</x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data buku</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 