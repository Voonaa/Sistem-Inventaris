                                <x-input-label for="stok_display" :value="__('Jumlah Tersedia')" />
                                <x-text-input id="stok_display" class="block mt-1 w-full bg-gray-100" type="number" :value="old('stok', $barang->stok)" disabled />
                                <p class="text-xs text-gray-500 mt-1">Jumlah barang yang tersedia (tidak dapat diubah langsung)</p>
                                <input type="hidden" name="stok" value="{{ old('stok', (int)($barang->stok ?? 0)) }}">
                            </div>
                            
                            <!-- Kondisi --> 