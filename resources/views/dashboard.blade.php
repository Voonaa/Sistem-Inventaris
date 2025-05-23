@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Barang -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Barang</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_barang'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_kategori'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Peminjaman Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['peminjaman_aktif'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Barang Stok Menipis -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Barang Stok Menipis</h2>
            </div>
            <div class="p-4">
                @if($barangMenipis->isEmpty())
                    <p class="text-gray-500">Tidak ada barang dengan stok menipis</p>
                @else
                    <div class="space-y-4">
                        @foreach($barangMenipis as $barang)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $barang->nama_barang }}</p>
                                    <p class="text-sm text-gray-500">Kode: {{ $barang->kode_barang }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">
                                    Stok: {{ $barang->stok }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Peminjaman Terlambat -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Peminjaman Terlambat</h2>
            </div>
            <div class="p-4">
                @if($peminjamanTerlambat->isEmpty())
                    <p class="text-gray-500">Tidak ada peminjaman yang terlambat</p>
                @else
                    <div class="space-y-4">
                        @foreach($peminjamanTerlambat as $peminjaman)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $peminjaman->barang->nama_barang }}</p>
                                    <p class="text-sm text-gray-500">Peminjam: {{ $peminjaman->user->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    {{ $peminjaman->tanggal_kembali->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Peminjaman -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Tren Peminjaman (7 Hari Terakhir)</h2>
            <div class="h-64">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>

        <!-- Grafik Status Barang -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Status Barang</h2>
            <div class="h-64">
                <canvas id="statusBarangChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman Terakhir -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Riwayat Peminjaman Terakhir</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($riwayatPeminjaman as $peminjaman)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $peminjaman->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $peminjaman->barang->nama_barang }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $peminjaman->status === 'dipinjam' ? 'bg-green-100 text-green-800' : 
                                       ($peminjaman->status === 'terlambat' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik dari PHP ke JavaScript
    const peminjamanData = @json($peminjamanChart);
    const statusBarangData = @json($statusBarang);

    // Grafik Peminjaman
    new Chart(document.getElementById('peminjamanChart'), {
        type: 'line',
        data: {
            labels: peminjamanData.map(item => item.date),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: peminjamanData.map(item => item.total),
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    // Grafik Status Barang
    new Chart(document.getElementById('statusBarangChart'), {
        type: 'doughnut',
        data: {
            labels: statusBarangData.map(item => item.status),
            datasets: [{
                data: statusBarangData.map(item => item.total),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endpush
@endsection
