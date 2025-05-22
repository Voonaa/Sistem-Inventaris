<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Peminjaman') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Peminjam -->
                            <div>
                                <x-input-label for="peminjam" :value="__('Nama Peminjam')" />
                                <x-text-input id="peminjam" class="block mt-1 w-full" type="text" name="peminjam" :value="old('peminjam', $peminjaman->peminjam)" required />
                                <x-input-error :messages="$errors->get('peminjam')" class="mt-2" />
                            </div>
                            
                            <!-- Jenis Peminjam -->
                            <div>
                                <x-input-label for="jenis" :value="__('Jenis Peminjam')" />
                                <select id="jenis" name="jenis" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="siswa" {{ old('jenis', $peminjaman->jenis) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="guru" {{ old('jenis', $peminjaman->jenis) == 'guru' ? 'selected' : '' }}>Guru</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>
                            
                            <!-- Kelas -->
                            <div>
                                <x-input-label for="kelas" :value="__('Kelas/Jabatan')" />
                                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas', $peminjaman->kelas)" required />
                                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
                            </div>
                            
                            <!-- Barang -->
                            <div>
                                <x-input-label for="barang_id" :value="__('Barang')" />
                                <select id="barang_id" name="barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" 
                                            {{ old('barang_id', $peminjaman->barang_id) == $barang->id ? 'selected' : '' }}
                                            data-stok="{{ ($barang->id == $peminjaman->barang_id) ? $barang->stok + $peminjaman->jumlah : $barang->stok }}">
                                            {{ $barang->nama_barang }} (Stok: {{ ($barang->id == $peminjaman->barang_id) ? $barang->stok + $peminjaman->jumlah : $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('barang_id')" class="mt-2" />
                            </div>
                            
                            <!-- Jumlah -->
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', $peminjaman->jumlah)" min="1" required />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            
                            <!-- Tanggal Pinjam -->
                            <div>
                                <x-input-label for="tanggal_pinjam" :value="__('Tanggal Pinjam')" />
                                <x-text-input id="tanggal_pinjam" class="block mt-1 w-full" type="date" name="tanggal_pinjam" :value="old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_pinjam')" class="mt-2" />
                            </div>
                            
                            <!-- Tanggal Kembali -->
                            <div>
                                <x-input-label for="tanggal_kembali" :value="__('Tanggal Kembali')" />
                                <x-text-input id="tanggal_kembali" class="block mt-1 w-full" type="date" name="tanggal_kembali" :value="old('tanggal_kembali', $peminjaman->tanggal_kembali->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="dikembalikan" {{ old('status', $peminjaman->status) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            @if($peminjaman->tanggal_dikembalikan)
                            <div>
                                <x-input-label for="tanggal_dikembalikan" :value="__('Tanggal Dikembalikan')" />
                                <x-text-input id="tanggal_dikembalikan" class="block mt-1 w-full" type="date" name="tanggal_dikembalikan" :value="$peminjaman->tanggal_dikembalikan->format('Y-m-d')" disabled />
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('peminjaman.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const barangSelect = document.getElementById('barang_id');
            const jumlahInput = document.getElementById('jumlah');
            const currentBarangId = "{{ $peminjaman->barang_id }}";
            const currentJumlah = {{ $peminjaman->jumlah }};
            
            // Store available stock for each barang
            const barangStocks = {};
            
            // Setup stock data
            document.querySelectorAll('#barang_id option').forEach(option => {
                if (option.value) {
                    barangStocks[option.value] = parseInt(option.getAttribute('data-stok')) || 0;
                }
            });
            
            // Check stock when item changes or jumlah changes
            function checkStock() {
                const selectedBarangId = barangSelect.value;
                const requestedAmount = parseInt(jumlahInput.value) || 0;
                
                if (selectedBarangId && barangStocks[selectedBarangId]) {
                    const availableStock = barangStocks[selectedBarangId];
                    
                    if (requestedAmount > availableStock) {
                        alert(`Jumlah melebihi stok tersedia (${availableStock})`);
                        jumlahInput.value = availableStock;
                    }
                    
                    // Set max attribute
                    jumlahInput.setAttribute('max', availableStock);
                }
            }
            
            // Add event listeners
            barangSelect.addEventListener('change', checkStock);
            jumlahInput.addEventListener('change', checkStock);
            
            // Initial check
            checkStock();
        });
    </script>
    @endpush
</x-app-layout> 