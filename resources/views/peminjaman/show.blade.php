<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Peminjaman') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Informasi Peminjaman</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Status</p>
                                <div>
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
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Nama Peminjam</p>
                                <p class="font-semibold">{{ $peminjaman->peminjam }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Jenis Peminjam</p>
                                <p class="font-semibold">{{ ucfirst($peminjaman->jenis) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Kelas/Jabatan</p>
                                <p class="font-semibold">{{ $peminjaman->kelas }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Barang</p>
                                <p class="font-semibold">{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Jumlah</p>
                                <p class="font-semibold">{{ $peminjaman->jumlah }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Tanggal Pinjam</p>
                                <p class="font-semibold">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Tanggal Kembali</p>
                                <p class="font-semibold">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</p>
                            </div>
                            
                            @if($peminjaman->tanggal_dikembalikan)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Tanggal Dikembalikan</p>
                                <p class="font-semibold">{{ $peminjaman->tanggal_dikembalikan->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Petugas</p>
                        <p class="font-semibold">{{ $peminjaman->user->name ?? 'N/A' }}</p>
                    </div>
                    
                    @if($peminjaman->catatan)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Catatan</p>
                        <p class="font-semibold">{{ $peminjaman->catatan }}</p>
                    </div>
                    @endif
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                            Edit Peminjaman
                        </a>
                        
                        @if($peminjaman->status === 'dipinjam')
                        <form action="{{ route('peminjaman.return', $peminjaman->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin item sudah dikembalikan?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Kembalikan
                            </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 