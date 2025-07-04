<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data"
                          x-data="{ 
                              kategori: '{{ old('kategori') }}', 
                              showSubKategori: false
                          }"
                          x-init="showSubKategori = kategori === 'perpustakaan'">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Barang -->
                            <div>
                                <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                                <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang')" required />
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>
                            
                            <!-- Nama Barang -->
                            <div>
                                <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required />
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                            
                            <!-- Kategori -->
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori')" />
                                <select id="kategori" name="kategori" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                        required
                                        x-model="kategori"
                                        x-on:change="showSubKategori = (kategori === 'perpustakaan')">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $category)
                                        @if(is_array($category))
                                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $category['label'] }}</option>
                                        @else
                                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>
                            
                            <!-- Sub Kategori (Only for Perpustakaan) -->
                            <div x-show="showSubKategori">
                                <x-input-label for="sub_kategori" :value="__('Sub Kategori')" />
                                <select id="sub_kategori" name="sub_kategori" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                        :required="showSubKategori">
                                    <option value="">Pilih Sub Kategori</option>
                                    @foreach($categories['perpustakaan']['sub'] as $subKey => $subValue)
                                        <option value="{{ $subKey }}" {{ old('sub_kategori') == $subKey ? 'selected' : '' }}>
                                            {{ $subValue }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('sub_kategori')" class="mt-2" />
                            </div>
                            
                            <!-- Jumlah -->
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah Barang')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', 1)" min="1" required />
                                <p class="text-xs text-gray-500 mt-1">Jumlah total barang yang tersedia</p>
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            
                            <!-- Hidden Stok field - will be set equal to jumlah -->
                            <input type="hidden" name="stok" :value="document.getElementById('jumlah')?.value || 1">
                            
                            <!-- Kondisi -->
                            <div>
                                <x-input-label for="kondisi" :value="__('Kondisi')" />
                                <select id="kondisi" name="kondisi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="kurang_baik" {{ old('kondisi') == 'kurang_baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>
                            
                            <!-- Gambar -->
                            <div>
                                <x-input-label for="gambar" :value="__('Gambar')" />
                                <input type="file" id="gambar" name="gambar" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" accept="image/*" />
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG, GIF (Maks: 2MB)</p>
                                <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="mt-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('barang.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
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
</x-app-layout> 