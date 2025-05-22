<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromCollection, WithHeadings, WithMapping
{
    protected $barangs;

    public function __construct($barangs = null)
    {
        $this->barangs = $barangs ?? Barang::with('kategori', 'subKategori')->get();
    }

    public function collection()
    {
        return $this->barangs;
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Sub Kategori',
            'Jumlah Total',
            'Jumlah Tersedia',
            'Kondisi',
            'Lokasi',
            'Tahun Perolehan',
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->kategori->nama ?? '-',
            $barang->subKategori->nama ?? '-',
            $barang->jumlah,
            $barang->stok,
            $barang->kondisi,
            $barang->lokasi ?? '-',
            $barang->tahun_perolehan ?? '-',
        ];
    }
} 