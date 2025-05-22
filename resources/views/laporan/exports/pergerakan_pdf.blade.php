<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pergerakan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <h1>Laporan Pergerakan Barang</h1>
    
    <div class="date-range">
        Periode: {{ date('d-m-Y', strtotime($startDate)) }} s/d {{ date('d-m-Y', strtotime($endDate)) }}
    </div>
    
    <!-- Summary Section -->
    <div style="margin-bottom: 20px; margin-top: 15px; padding: 10px; background-color: #f5f5f5; border-radius: 5px;">
        <h3 style="font-size: 14px; margin-bottom: 10px; color: #333;">Informasi Ringkas</h3>
        <table style="width: 100%; border-collapse: separate; border-spacing: 5px;">
            <tr>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Total Transaksi</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ count($riwayats) }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Tambah</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $riwayats->where('jenis_aktivitas', 'tambah')->count() }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Kurang</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $riwayats->where('jenis_aktivitas', 'kurang')->count() }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Hapus</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $riwayats->where('jenis_aktivitas', 'hapus')->count() }}</div>
                </td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Barang</th>
                <th>Jenis Aktivitas</th>
                <th>Jumlah</th>
                <th>Stok Sebelum</th>
                <th>Stok Sesudah</th>
                <th>User</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ ucfirst($item->jenis_aktivitas) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->stok_sebelum }}</td>
                    <td>{{ $item->stok_sesudah }}</td>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data pergerakan barang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html> 