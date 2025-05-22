<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data"
                          x-data="{ 
                              kategoriId: '{{ old('kategori_id', $barang->kategori_id) }}', 
                              subKategoris: [],
                              oldSubKategoriId: '{{ old('sub_kategori_id', $barang->sub_kategori_id) }}',
                              async getSubKategoris() {
                                  if (!this.kategoriId) {
                                      this.subKategoris = [];
                                      return;
                                  }
                                  try {
                                      const response = await fetch(`/api/sub-kategoris?kategori_id=${this.kategoriId}`);
                                      this.subKategoris = await response.json();
                                  } catch (error) {
                                      console.error('Error loading subcategories:', error);
                                      this.subKategoris = [];
                                  }
                              }
                          }"
                          x-init="getSubKategoris()">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Barang -->
                            <div>
                                <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                                <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang', $barang->kode_barang)" required />
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>
                            
                            <!-- Nama Barang -->
                            <div>
                                <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang)" required />
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                            
                            <!-- Kategori -->
                            <div>
                                <x-input-label for="kategori_id" :value="__('Kategori')" />
                                <select id="kategori_id" name="kategori_id" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                        required
                                        x-model="kategoriId"
                                        x-on:change="getSubKategoris()">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                            </div>
                            
                            <!-- Sub Kategori -->
                            <div>
                                <x-input-label for="sub_kategori_id" :value="__('Sub Kategori')" />
                                <select id="sub_kategori_id" name="sub_kategori_id" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                        required>
                                    <option value="">Pilih Sub Kategori</option>
                                    <template x-for="subKategori in subKategoris" :key="subKategori.id">
                                        <option :value="subKategori.id" 
                                                x-text="subKategori.nama"
                                                :selected="oldSubKategoriId == subKategori.id"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('sub_kategori_id')" class="mt-2" />
                            </div>
                            
                            <!-- Jumlah -->
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', $barang->jumlah)" min="0" required />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            
                            <!-- Jumlah Tersedia -->
                            <div>
                                <x-input-label for="stok" :value="__('Stok')" />
                                <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $barang->stok)" min="0" required />
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                            
                            <!-- Kondisi -->
                            <div>
                                <x-input-label for="kondisi" :value="__('Kondisi')" />
                                <select id="kondisi" name="kondisi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik" {{ old('kondisi', $barang->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Kurang Baik" {{ old('kondisi', $barang->kondisi) == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    <option value="Rusak" {{ old('kondisi', $barang->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>
                            
                            <!-- Gambar -->
                            <div>
                                <x-input-label for="gambar" :value="__('Gambar')" />
                                @if($barang->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama }}" class="h-24 w-auto object-contain">
                                        <p class="text-sm text-gray-500">Gambar saat ini</p>
                                    </div>
                                @endif
                                <input type="file" id="gambar" name="gambar" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" accept="image/*" />
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG, GIF (Maks: 2MB)</p>
                                <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="mt-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('barang.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
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
</x-app-layout> 