<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Peminjaman</h3>
                    <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Peminjaman
                    </a>
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

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Peminjam</x-table.heading>
                            <x-table.heading>Jenis</x-table.heading>
                            <x-table.heading>Kelas</x-table.heading>
                            <x-table.heading>Barang</x-table.heading>
                            <x-table.heading>Jumlah</x-table.heading>
                            <x-table.heading>Tanggal Pinjam</x-table.heading>
                            <x-table.heading>Tanggal Kembali</x-table.heading>
                            <x-table.heading>Status</x-table.heading>
                            <x-table.heading>Aksi</x-table.heading>
                        </x-slot>
                        
                        <tbody>
                            @forelse($peminjamans as $peminjaman)
                                <tr>
                                    <x-table.cell>{{ $peminjaman->peminjam }}</x-table.cell>
                                    <x-table.cell>{{ ucfirst($peminjaman->jenis) }}</x-table.cell>
                                    <x-table.cell>{{ $peminjaman->kelas }}</x-table.cell>
                                    <x-table.cell>{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell>{{ $peminjaman->jumlah }}</x-table.cell>
                                    <x-table.cell>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</x-table.cell>
                                    <x-table.cell>{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</x-table.cell>
                                    <x-table.cell>
                                        @if($peminjaman->status === 'dipinjam')
                                            @if($peminjaman->tanggal_kembali->isPast())
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Terlambat</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Dipinjam</span>
                                            @endif
                                        @elseif($peminjaman->status === 'dikembalikan')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $peminjaman->status }}</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            @if($peminjaman->status === 'dipinjam')
                                                <form action="{{ route('peminjaman.return', $peminjaman->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin item sudah dikembalikan?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
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
                                    <x-table.cell colspan="9" class="text-center py-4">
                                        Tidak ada data peminjaman.
                                    </x-table.cell>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table>
                </div>
                
                <div class="mt-4">
                    {{ $peminjamans->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 