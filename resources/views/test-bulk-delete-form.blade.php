<!DOCTYPE html>
<html>
<head>
    <title>Test Bulk Delete</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 15px; background-color: #dc3545; color: white; border: none; cursor: pointer; }
        .btn:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <h1>Test Bulk Delete Form</h1>
    
    @if(session('success'))
        <div style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('barang.bulk-destroy') }}" method="POST" onsubmit="return confirmDelete()">
        @csrf
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all" onclick="toggleAll()"></th>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                    <tr>
                        <td><input type="checkbox" name="barang_ids[]" value="{{ $barang->id }}" class="item-checkbox"></td>
                        <td>{{ $barang->id }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if(count($barangs) > 0)
            <button type="submit" class="btn">Hapus Barang Terpilih</button>
        @endif
    </form>

    <script>
        function toggleAll() {
            const mainCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = mainCheckbox.checked;
            });
        }
        
        function confirmDelete() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            if (checked.length === 0) {
                alert('Silakan pilih setidaknya satu barang untuk dihapus.');
                return false;
            }
            
            return confirm('Apakah Anda yakin ingin menghapus ' + checked.length + ' barang yang dipilih?');
        }
    </script>
</body>
</html> 