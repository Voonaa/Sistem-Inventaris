<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pergerakan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            margin: 0;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
        .summary {
            margin-bottom: 20px; 
            padding: 10px; 
            background-color: #f5f5f5; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PERGERAKAN BARANG</h1>
        <p>SMK SASMITA JAYA</p>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>
    
    <div class="date-range">
        Periode: {{ date('d-m-Y', strtotime($startDate)) }} s/d {{ date('d-m-Y', strtotime($endDate)) }}
    </div>
    
    <!-- Summary Section -->
    <div class="summary">
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
    
    <!-- Daftar Pergerakan Barang -->
    <div class="section-title">Daftar Pergerakan Barang</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="25%">Barang</th>
                <th width="10%">Jenis</th>
                <th width="10%">Jumlah</th>
                <th width="15%">Jumlah Sebelum</th>
                <th width="15%">Jumlah Sesudah</th>
                <th width="10%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_riwayat ?? $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ ucfirst($item->jenis_aktivitas) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->stok_sebelum }}</td>
                    <td>{{ $item->stok_sesudah }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data pergerakan barang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem inventaris SMK Sasmita Jaya</p>
    </div>
</body>
</html> 