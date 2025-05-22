<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Peminjaman</h2>
                </div>

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Peminjam</x-table.heading>
                            <x-table.heading>Buku</x-table.heading>
                            <x-table.heading>Tanggal Pinjam</x-table.heading>
                            <x-table.heading>Tanggal Kembali</x-table.heading>
                            <x-table.heading>Status</x-table.heading>
                        </x-slot>

                        @forelse($peminjaman as $item)
                            <tr>
                                <x-table.cell>{{ $item->id }}</x-table.cell>
                                <x-table.cell>{{ $item->user->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->buku->judul ?? 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->tanggal_pinjam ? date('d-m-Y', strtotime($item->tanggal_pinjam)) : 'N/A' }}</x-table.cell>
                                <x-table.cell>{{ $item->tanggal_kembali ? date('d-m-Y', strtotime($item->tanggal_kembali)) : 'N/A' }}</x-table.cell>
                                <x-table.cell>
                                    @if($item->status == 'dipinjam')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Dipinjam
                                        </span>
                                    @elseif($item->status == 'dikembalikan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data peminjaman</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 