<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $peminjamans;

    public function __construct($peminjamans = null)
    {
        $this->peminjamans = $peminjamans ?? Peminjaman::with(['barang', 'user'])->get();
    }

    public function collection()
    {
        return $this->peminjamans;
    }

    public function headings(): array
    {
        return [
            'Peminjam',
            'Jenis',
            'Kelas',
            'Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Tanggal Dikembalikan',
            'Petugas',
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->peminjam,
            ucfirst($peminjaman->jenis),
            $peminjaman->kelas,
            $peminjaman->barang->nama_barang ?? '-',
            $peminjaman->jumlah,
            $peminjaman->tanggal_pinjam->format('d/m/Y'),
            $peminjaman->tanggal_kembali->format('d/m/Y'),
            ucfirst($peminjaman->status),
            $peminjaman->tanggal_dikembalikan ? $peminjaman->tanggal_dikembalikan->format('d/m/Y') : '-',
            $peminjaman->user->name ?? '-',
        ];
    }
} 