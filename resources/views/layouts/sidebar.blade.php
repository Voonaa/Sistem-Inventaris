<div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
    <!-- Logo -->
    <div class="flex items-center justify-center flex-shrink-0 px-4">
        <h1 class="text-xl font-bold text-blue-600">Inventaris SMK</h1>
    </div>
    
    <!-- Navigation Links -->
    <div class="mt-8 flex-grow flex flex-col">
        <nav class="flex-1 px-2 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <!-- Barang (Equipment) with Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('barang.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" type="button" class="{{ request()->routeIs('barang.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-left">
                    <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('barang.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Barang
                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{'rotate-90': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="open" class="pl-8 space-y-1">
                    <!-- All Items -->
                    <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.index') && !request()->has('kategori') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                        Semua Barang
                    </a>
                    
                    <!-- Create Item -->
                    <a href="{{ route('barang.create') }}" class="{{ request()->routeIs('barang.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                        Tambah Barang
                    </a>
                    
                    <!-- Manage Items -->
                    <a href="{{ route('barang.manage') }}" class="{{ request()->routeIs('barang.manage') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                        Hapus Barang
                    </a>
                    
                    <!-- Categories -->
                    @foreach(config('categories') as $key => $category)
                        @if(is_array($category) && $key === 'perpustakaan')
                            <!-- Perpustakaan with subcategories -->
                            <div x-data="{ open: {{ request()->has('kategori') && request('kategori') === $key ? 'true' : 'false' }} }" class="space-y-1 mt-1">
                                <button @click="open = !open" type="button" class="{{ request()->has('kategori') && request('kategori') === $key ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} flex items-center px-2 py-1 text-sm rounded-md w-full text-left">
                                    {{ $category['label'] }}
                                    <svg class="ml-auto h-4 w-4 transform transition-transform duration-200" :class="{'rotate-90': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" class="pl-4">
                                    <!-- All perpustakaan items -->
                                    <a href="{{ route('barang.index', ['kategori' => $key]) }}" class="{{ request()->has('kategori') && request('kategori') === $key && !request()->has('sub') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                                        Semua {{ $category['label'] }}
                                    </a>
                                    
                                    <!-- Subcategories -->
                                    @foreach($category['sub'] as $subKey => $subValue)
                                        <a href="{{ route('barang.index', ['kategori' => $key, 'sub' => $subKey]) }}" class="{{ request()->has('kategori') && request('kategori') === $key && request('sub') === $subKey ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                                            {{ $subValue }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!is_array($category))
                            <!-- Regular category -->
                            <a href="{{ route('barang.index', ['kategori' => $key]) }}" class="{{ request()->has('kategori') && request('kategori') === $key ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-700' }} block px-2 py-1 text-sm">
                                {{ $category }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Peminjaman (Borrowing) -->
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('peminjaman.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Peminjaman
            </a>

            <!-- Laporan (Reports) -->
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('laporan.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Laporan
            </a>

            <!-- Pengguna (Users) -->
            <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('pengguna.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Pengguna
            </a>

            <!-- History (Activity Log) -->
            <a href="{{ route('history.index') }}" class="{{ request()->routeIs('history.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('history.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                History
            </a>
        </nav>
    </div>
    
    <!-- Footer -->
    <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
        <div class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
                <div>
                    <svg class="inline-block h-9 w-9 rounded-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-gray-500 group-hover:text-gray-700">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 