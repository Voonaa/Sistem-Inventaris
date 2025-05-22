<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h2>
                    <a href="{{ route('pengguna.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Pengguna
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>ID</x-table.heading>
                            <x-table.heading>Nama</x-table.heading>
                            <x-table.heading>Email</x-table.heading>
                            <x-table.heading>Peran</x-table.heading>
                            <x-table.heading>Terdaftar</x-table.heading>
                            <x-table.heading>Aksi</x-table.heading>
                        </x-slot>

                        @forelse($users as $user)
                            <tr>
                                <x-table.cell>{{ $user->id }}</x-table.cell>
                                <x-table.cell>{{ $user->name }}</x-table.cell>
                                <x-table.cell>{{ $user->email }}</x-table.cell>
                                <x-table.cell>
                                    @if($user->role == 'admin')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Admin
                                        </span>
                                    @elseif($user->role == 'operator')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Operator
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Viewer
                                        </span>
                                    @endif
                                </x-table.cell>
                                <x-table.cell>{{ $user->created_at->format('d-m-Y') }}</x-table.cell>
                                <x-table.cell>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('pengguna.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('pengguna.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">Tidak ada data pengguna</div>
                                </x-table.cell>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 