<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Riwayat Aktivitas</title>
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
        <h1>LAPORAN RIWAYAT AKTIVITAS BARANG</h1>
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
                    <div style="font-size: 11px; color: #666;">Total Aktivitas</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ count($histories) }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Barang Masuk</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $histories->where('jenis_aktivitas', 'masuk')->count() }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Barang Keluar</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $histories->where('jenis_aktivitas', 'keluar')->count() }}</div>
                </td>
                <td style="width: 25%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Perubahan</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $histories->whereNotIn('jenis_aktivitas', ['masuk', 'keluar'])->count() }}</div>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Daftar Aktivitas -->
    <div class="section-title">Daftar Riwayat Aktivitas</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Waktu</th>
                <th width="15%">Petugas</th>
                <th width="20%">Barang</th>
                <th width="10%">Jenis</th>
                <th width="10%">Jumlah</th>
                <th width="25%">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ ucfirst($item->jenis_aktivitas) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data riwayat aktivitas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem inventaris SMK Sasmita Jaya</p>
    </div>
</body>
</html> 