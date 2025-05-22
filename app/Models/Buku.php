<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Buku extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'jumlah_halaman',
        'deskripsi',
        'kategori',
        'lokasi_rak',
        'stok',
        'dipinjam',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'jumlah_halaman' => 'integer',
        'stok' => 'integer',
        'dipinjam' => 'integer',
    ];
    
    /**
     * Get the peminjaman that belong to the buku.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
    
    /**
     * Get the riwayat barang that belong to the buku.
     */
    public function riwayatBarang(): HasMany
    {
        return $this->hasMany(RiwayatBarang::class);
    }
    
    /**
     * Get the available stock.
     */
    public function getStokTersediaAttribute()
    {
        return $this->stok - $this->dipinjam;
    }
    
    /**
     * Get the barang associated with the buku.
     */
    public function barang(): HasOne
    {
        return $this->hasOne(Barang::class);
    }
}
