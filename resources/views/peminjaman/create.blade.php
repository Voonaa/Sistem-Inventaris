<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Peminjaman') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Peminjam -->
                            <div>
                                <x-input-label for="peminjam" :value="__('Nama Peminjam')" />
                                <x-text-input id="peminjam" class="block mt-1 w-full" type="text" name="peminjam" :value="old('peminjam')" required autofocus />
                                <x-input-error :messages="$errors->get('peminjam')" class="mt-2" />
                            </div>
                            
                            <!-- Jenis Peminjam -->
                            <div>
                                <x-input-label for="jenis" :value="__('Jenis Peminjam')" />
                                <select id="jenis" name="jenis" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="siswa" {{ old('jenis') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="guru" {{ old('jenis') == 'guru' ? 'selected' : '' }}>Guru</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>
                            
                            <!-- Kelas -->
                            <div>
                                <x-input-label for="kelas" :value="__('Kelas/Jabatan')" />
                                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')" required />
                                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
                            </div>
                            
                            <!-- Barang -->
                            <div>
                                <x-input-label for="barang_id" :value="__('Barang')" />
                                <select id="barang_id" name="barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-max="{{ $barang->stok }}">
                                            {{ $barang->nama_barang }} (Jumlah: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('barang_id')" class="mt-2" />
                            </div>
                            
                            <!-- Jumlah -->
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', 1)" min="1" required />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            
                            <!-- Tanggal Pinjam -->
                            <div>
                                <x-input-label for="tanggal_pinjam" :value="__('Tanggal Pinjam')" />
                                <x-text-input id="tanggal_pinjam" class="block mt-1 w-full" type="date" name="tanggal_pinjam" :value="old('tanggal_pinjam', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_pinjam')" class="mt-2" />
                            </div>
                            
                            <!-- Tanggal Kembali -->
                            <div>
                                <x-input-label for="tanggal_kembali" :value="__('Tanggal Kembali')" />
                                <x-text-input id="tanggal_kembali" class="block mt-1 w-full" type="date" name="tanggal_kembali" :value="old('tanggal_kembali', date('Y-m-d', strtotime('+7 days')))" required />
                                <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('peminjaman.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
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
            const form = document.querySelector('form');
            const barangSelect = document.getElementById('barang_id');
            const jumlahInput = document.getElementById('jumlah');
            
            // Store available stock for each barang
            const barangStocks = {
                @foreach($barangs as $barang)
                    {{ $barang->id }}: {{ $barang->stok }},
                @endforeach
            };
            
            // Check stock when item changes or jumlah changes
            function checkStock() {
                const selectedBarangId = barangSelect.value;
                const requestedAmount = parseInt(jumlahInput.value) || 0;
                
                if (selectedBarangId && barangStocks[selectedBarangId]) {
                    const availableStock = barangStocks[selectedBarangId];
                    
                    if (requestedAmount > availableStock) {
                        alert(`Jumlah melebihi jumlah tersedia (${availableStock})`);
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
            
            // Add form submit handler
            form.addEventListener('submit', function(e) {
                const selectedBarangId = barangSelect.value;
                const requestedAmount = parseInt(jumlahInput.value) || 0;
                
                if (!selectedBarangId) {
                    e.preventDefault();
                    alert('Silakan pilih barang terlebih dahulu');
                    return;
                }
                
                if (requestedAmount <= 0) {
                    e.preventDefault();
                    alert('Jumlah harus lebih dari 0');
                    return;
                }
                
                if (selectedBarangId && barangStocks[selectedBarangId]) {
                    const availableStock = barangStocks[selectedBarangId];
                    if (requestedAmount > availableStock) {
                        e.preventDefault();
                        alert(`Jumlah melebihi stok tersedia (${availableStock})`);
                        return;
                    }
                }
            });
            
            // Initial check
            checkStock();
        });
    </script>
    @endpush
</x-app-layout> 