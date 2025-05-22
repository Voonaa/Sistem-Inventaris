<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Barang extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'kategori_id',
        'sub_kategori_id',
        'merek',
        'model',
        'nomor_seri',
        'tahun_perolehan',
        'kondisi',
        'status',
        'lokasi',
        'jumlah',
        'stok',
        'harga_perolehan',
        'sumber_dana',
        'is_buku',
        'buku_id',
        'gambar',
        'created_by',
        'updated_by',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_perolehan' => 'integer',
        'jumlah' => 'integer',
        'stok' => 'integer',
        'harga_perolehan' => 'decimal:2',
        'is_buku' => 'boolean',
    ];
    
    /**
     * Get the kategori that owns the barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    
    /**
     * Get the sub-kategori that owns the barang.
     */
    public function subKategori(): BelongsTo
    {
        return $this->belongsTo(SubKategori::class);
    }
    
    /**
     * Get the buku associated with the barang.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
    
    /**
     * Get the peminjamans for the barang.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
    
    /**
     * Get the riwayat barangs for the barang.
     */
    public function riwayatBarangs(): HasMany
    {
        return $this->hasMany(RiwayatBarang::class);
    }
    
    /**
     * Get the user who created the barang.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Get the user who last updated the barang.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
