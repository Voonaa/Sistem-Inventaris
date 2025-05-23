<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman</title>
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
        <h1>LAPORAN PEMINJAMAN INVENTARIS</h1>
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
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Total Peminjaman</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ count($peminjamans) }}</div>
                </td>
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Masih Dipinjam</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $peminjamans->where('status', 'dipinjam')->count() }}</div>
                </td>
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Sudah Dikembalikan</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</div>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Daftar Peminjaman -->
    <div class="section-title">Daftar Peminjaman</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="25%">Peminjam</th>
                <th width="25%">Barang</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Tanggal Kembali</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_peminjaman ?? $item->id }}</td>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->barang->nama_barang ?? ($item->buku->judul ?? 'N/A') }}</td>
                    <td>{{ $item->tanggal_pinjam ? date('d-m-Y', strtotime($item->tanggal_pinjam)) : 'N/A' }}</td>
                    <td>{{ $item->tanggal_kembali ? date('d-m-Y', strtotime($item->tanggal_kembali)) : 'N/A' }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem inventaris SMK Sasmita Jaya</p>
    </div>
</body>
</html> 