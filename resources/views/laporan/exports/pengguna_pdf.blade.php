<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengguna</title>
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
        <h1>LAPORAN PENGGUNA SISTEM</h1>
        <p>SMK SASMITA JAYA</p>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>
    
    <!-- Summary Section -->
    <div class="summary">
        <h3 style="font-size: 14px; margin-bottom: 10px; color: #333;">Informasi Ringkas</h3>
        <table style="width: 100%; border-collapse: separate; border-spacing: 5px;">
            <tr>
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Total Pengguna</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ count($users) }}</div>
                </td>
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Admin</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $users->where('role', 'admin')->count() }}</div>
                </td>
                <td style="width: 33%; padding: 8px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                    <div style="font-size: 11px; color: #666;">Operator</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ $users->where('role', 'operator')->count() }}</div>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Daftar Pengguna -->
    <div class="section-title">Daftar Pengguna</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="5%">ID</th>
                <th width="25%">Nama</th>
                <th width="30%">Email</th>
                <th width="15%">Peran</th>
                <th width="20%">Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pengguna</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem inventaris SMK Sasmita Jaya</p>
    </div>
</body>
</html> 